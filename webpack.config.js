const path = require("path");
const webpack = require("webpack");
//minify css files and also adds possibility to compile pcss files to specific css files
const MiniCssExtractPlugin = require("mini-css-extract-plugin");
//webpack is creating also js files that are empty for css files, this plugin removed them
const RemoveEmptyScriptsPlugin = require("webpack-remove-empty-scripts");
//minify js content
const TerserPlugin = require("terser-webpack-plugin");

//load paths
const tsPaths = require("./config/webpack/path-variables/ts-paths-variables");
const pcssPaths = require("./config/webpack/path-variables/pcss-paths-variables");
const jsPaths = require("./config/webpack/path-variables/js-paths-variables");
const cssPaths = require("./config/webpack/path-variables/css-paths-variables");
//load script files names
const scriptsFileNames = require("./config/webpack/file-names/scripts-file-names");
const stylesFileNames = require("./config/webpack/file-names/styles-file-names");
//file locations (where the pcss and ts files are compiled)
const getCSSFilesLocations = require("./config/webpack/file-locations/css-files-locations");
const getJSFilesLocations = require("./config/webpack/file-locations/js-files-locations");
// ts and pcss files entries
const createTsEntry = require("./config/webpack/file-entries/ts-entries");
const createCssEntry = require("./config/webpack/file-entries/pcss-entries");

module.exports = {
    mode: "development", // or 'production'
    entry: {
        ...createTsEntry(scriptsFileNames, tsPaths),
        ...createCssEntry(stylesFileNames, pcssPaths),

        //CSS entries
        //many entries to one
        /*css: [
            './assets/styles/postcss/create-sidebars.pcss',
            './assets/styles/postcss/options/checkbox.pcss',
        ]*/
    },
    output: {
        path: path.resolve(__dirname, "assets"),
        assetModuleFilename: "[name][ext]",

        //compile ts files in different folders
        filename: (chunkData) => {
            //js file locations (where the ts files are compiled)
            return getJSFilesLocations(chunkData, jsPaths, scriptsFileNames);
        },
    },
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
                use: "ts-loader", // Use ts-loader for compilation
                exclude: /node_modules/, // Exclude node_modules directory
            },
            //this area is to generate the postcss images with the same name without a hash and in the images folder
            {
                test: /\.(png|jpe?g|gif|svg|webp)$/i,
                type: "asset/resource", // Use asset/resource to emit the asset as a separate file
                generator: {
                    filename: "images/[name][ext]", // Specify output directory for images
                },
            },
        ],
    },
    devtool: "source-map", // Enable source maps
    resolve: {
        extensions: [".ts", ".tsx", ".js", ".css"], // Resolve TypeScript and JavaScript extensions,
        modules: [path.resolve(__dirname, "node_modules"), path.resolve(__dirname, "node_modules/ace-builds")],
        alias: {
            "ace-builds": path.resolve(__dirname, "node_modules/ace-builds"),
        },
    },
    plugins: [
        new webpack.SourceMapDevToolPlugin({
            test: /\.(ts|js|css|mjs)$/, // Match JavaScript, CSS, and module files
            filename: "[file].map", // Output source map file names
        }),
        // MiniCssExtractPlugin instance for 'options-checkbox' entry
        new MiniCssExtractPlugin({
            filename: (chunkData) => {
                //css file locations (where the pcss files are compiled)
                return getCSSFilesLocations(chunkData, cssPaths, stylesFileNames);
            },
        }),
        // Add RemoveEmptyScriptsPlugin to remove empty JavaScript files
        new RemoveEmptyScriptsPlugin(),
    ],
    optimization: {
        minimizer: [new TerserPlugin()], // Minify JavaScript using terser-webpack-plugin
    },
    externals: {
        jquery: "jQuery",
    },
};
