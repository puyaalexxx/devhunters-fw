//terser-webpack-plugin - suggestion
const path = require("path");
const webpack = require("webpack");
//minify css files and also adds possibility to compile pcss files to specific css files
const MiniCssExtractPlugin = require("mini-css-extract-plugin");
//webpack is creating also js files that are empty for css files, this plugin removed them
const RemoveEmptyScriptsPlugin = require("webpack-remove-empty-scripts");
//some webpack help functionality
const webpackHelpersSettings = require("./config/webpack/helpers");
////////env config//////
const dotenv = require("dotenv");
// Load the appropriate .env file based on NODE_ENV
const envFile = process.env.NODE_ENV === "production" ? ".env.production" : ".env.development";
dotenv.config({path: envFile});


const wbpSettings = webpackHelpersSettings(path);
module.exports = {
    mode: process.env.FW_ENVIRONMENT,
    entry: wbpSettings.entry,
    output: wbpSettings.output,
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
    optimization: wbpSettings.optimization,
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
        new MiniCssExtractPlugin(wbpSettings.miniCssExtractPlugin),
        // Add RemoveEmptyScriptsPlugin to remove empty JavaScript files
        new RemoveEmptyScriptsPlugin(),
        new webpack.DefinePlugin({
            "process.env.FW_ENVIRONMENT": JSON.stringify(process.env.FW_ENVIRONMENT),
        }),
    ],
    externals: {
        jquery: "jQuery",
    },
};
