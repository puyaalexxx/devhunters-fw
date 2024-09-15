////////Webpack plugins//////
const path = require("path");
const webpack = require("webpack");
//minify css files and also adds possibility to compile pcss files to specific css files
const MiniCssExtractPlugin = require("mini-css-extract-plugin");
//webpack is creating also js files that are empty for css files, this plugin removed them
const RemoveEmptyScriptsPlugin = require("webpack-remove-empty-scripts");
//clean js/css directory when compiling files
const { CleanWebpackPlugin } = require("clean-webpack-plugin");

////////env config//////
let isDevEnvironment = process.env.NODE_ENV === "development";

////////helper settings from config folder//////
//get ts file settings
const folders = require("./config/webpack/file-names/ts-pcss-folders");
const tsFileNames = require("./config/webpack/file-names/ts-file-names");
const getTsEntries = require("./config/webpack/file-entries/ts-entries");
const pcssFileNames = require("./config/webpack/file-names/pcss-file-names");
const getPcssEntries = require("./config/webpack/file-entries/pcss-entries");

const tsEntries = Object.entries(getTsEntries(tsFileNames, folders));
const pcssEntries = Object.entries(getPcssEntries(pcssFileNames, folders));

//isDevEnvironment = false;

let entry = {};
let output = {};
let optimization = {};
let cssOutput = {};

if (isDevEnvironment) {
    const entries = {};
    // ts files
    for (const [filesPath, files] of tsEntries) {
        for (const file of files) {
            entries[file + "-script-suffix"] = "./assets/scripts/ts/modules/" + filesPath + file + ".ts";
        }
    }
    //pcss files
    for (const [filesPath, files] of pcssEntries) {
        for (const file of files) {
            entries[file + "-style-suffix"] = "./assets/styles/postcss/modules/" + filesPath + file + ".pcss";
        }
    }

    entry = entries;

    output = {
        path: path.resolve(__dirname, "assets"),
        assetModuleFilename: "[name][ext]",
        filename: (chunkData) => {
            // Access the name of the chunk
            let customChunkName = chunkData.chunk.name || "default";

            return `scripts/js/${customChunkName.replace("-script-suffix", "")}.js`;
        },
    };

    cssOutput = {
        filename: (chunkData) => {
            // Access the name of the chunk
            let customChunkName = chunkData.chunk.name || "default";

            return `styles/css/${customChunkName.replace("-style-suffix", "")}.css`;
        },
    };

} else {

    //pcss files
    const entries = {};
    for (const [filesPath, files] of pcssEntries) {
        for (const file of files) {
            entries[file + "-style-suffix"] = "./assets/styles/postcss/modules/" + filesPath + file + ".pcss";
        }
    }

    entry = {
        main: "./assets/scripts/ts/main.ts", // Your entry point for JS
        ...entries, // Your entry point for PCSS
    };

    output = {
        path: path.resolve(__dirname, "assets"),
        assetModuleFilename: "[name][ext]",
        chunkFilename: (chunkData) => {
            // Access the name of the chunk
            let customChunkName = chunkData.chunk.name || "";

            // Grab the file name instead of the webpack generated chunk name
            for (const [filesPath, files] of tsEntries) {
                // Convert the filePath to use dashes instead of slashes
                const normalizedFilePath = filesPath.replace(/\//g, "-");

                // Check if the chunk name starts with the normalized filePath
                if (customChunkName.startsWith(normalizedFilePath)) {
                    // Remove the normalized filePath from the beginning of the customChunkName
                    const fileName = customChunkName.slice(normalizedFilePath.length);

                    //if file exists in the files array
                    if (files.includes(fileName)) {
                        customChunkName = fileName;
                        break;
                    }
                }
            }

            // Return the path for the chunk file
            return `scripts/js/${customChunkName}.js`;
        },
        filename: "scripts/js/[name].js", // Specify the output file name
    };

    cssOutput = {
        filename: "styles/css/[name].css",
    };

    optimization = {
        splitChunks: {
            chunks: "all", // Split all chunks
            minSize: 20000, // Minimum size for a chunk to be generated
            //maxSize: 0,
            minChunks: 1, // Minimum number of chunks that must share a module before splitting
            automaticNameDelimiter: "-",
            cacheGroups: {
                defaultVendors: {
                    //test: /[\\/]node_modules[\\/]/,
                    test: /[\\/]node_modules[\\/](?!ace-builds)/, // Exclude ace-builds from being bundled here
                    name: "vendors",
                    chunks: "all",
                    priority: -10,
                },
                styles: {
                    name: "main.min", // Bundle all styles into a single CSS file called main-bunle.css
                    test: /\.pcss$/,
                    chunks: "all",
                    enforce: true,
                    priority: 1, // Ensure priority to avoid conflicts
                },
                default: {
                    minChunks: 2,
                    priority: -20,
                    reuseExistingChunk: true,
                    filename: "[name].js", // Use a custom filename pattern
                },
            },
        },
        runtimeChunk: false,
    };
}


module.exports = {
    mode: process.env.NODE_ENV,
    entry: entry,
    output: output,
    module: {
        rules: [
            {
                test: /\.pcss$/, // Match PostCSS files
                use: [
                    MiniCssExtractPlugin.loader, // minify css files
                    //"style-loader",
                    "css-loader", // Resolve CSS imports
                    "postcss-loader",
                ],
            },
            {
                test: /\.ts?$/, // Match TypeScript files
                //test: /^(?!.*\.d\.ts$).*\.ts$/,
                use: "ts-loader", // Use ts-loader for compilation
                exclude: [
                    ///\.d\.ts$/, // Exclude .d.ts files
                    /node_modules/, // Exclude node_modules directory
                    /\.d\.ts$/, // Exclude .d.ts files
                    path.resolve(__dirname, "assets/scripts/ts/types"),
                ],
            },
            //this area is to generate the postcss images with the same name without a hash and in the images folder
            {
                test: /\.(png|jpe?g|gif|svg|webp)$/i,
                type: "asset/resource", // Use asset/resource to emit the asset as a separate file
                generator: {
                    filename: "images/[name][ext]", // Specify output directory for images
                },
            },
            // Rule for HTML files (if you don't want to process them)
            {
                test: /\.html$/,
                include: path.resolve(__dirname, "assets/scripts/ts"),
                use: "ignore-loader", // Ignore HTML files in the specified directory
            },
        ],
    },
    //used for webpack chunk feature
    optimization: optimization,
    devtool: "source-map", // Enable source maps
    resolve: {
        extensions: [".js", ".jsx", ".ts", ".tsx", ".css"], // Resolve TypeScript and JavaScript extensions,
        modules: [path.resolve(__dirname, "node_modules"), path.resolve(__dirname, "node_modules/ace-builds")],
    },
    plugins: [
        new webpack.SourceMapDevToolPlugin({
            test: /\.(ts|js|css|mjs)$/, // Match JavaScript, CSS, and module files
            filename: "[file].map", // Output source map file names
        }),
        // MiniCssExtractPlugin instance for 'options-checkbox' entry
        new MiniCssExtractPlugin(cssOutput),
        // Add RemoveEmptyScriptsPlugin to remove empty JavaScript files
        new RemoveEmptyScriptsPlugin(),
        //constants to be used in browser
        new webpack.DefinePlugin({
            //DHT_IS_DEV_ENVIRONMENT: JSON.stringify(isDevEnvironment),
        }),
        new CleanWebpackPlugin({
            cleanOnceBeforeBuildPatterns: [
                path.resolve(__dirname, "assets/scripts/js/**/*"),
                path.resolve(__dirname, "assets/styles/css/**/*"),
            ],
        }),
        new webpack.IgnorePlugin({
            resourceRegExp: /\.html$/,
            contextRegExp: /assets\/scripts\/ts/,
        }),
    ],
    externals: {
        jquery: "jQuery",
        "ace-builds": "ace-builds", // Treat 'ace-builds' as an external dependency
    },
};
