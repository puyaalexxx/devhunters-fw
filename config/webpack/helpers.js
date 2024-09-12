//load paths
const tsPaths = require("./path-variables/ts-paths-variables");
const pcssPaths = require("./path-variables/pcss-paths-variables");

//load script files names
const scriptsFileNames = require("./file-names/scripts-file-names");
const stylesFileNames = require("./file-names/styles-file-names");

// ts and pcss files entries
const createTsEntry = require("./file-entries/ts-entries");
const createCssEntry = require("./file-entries/pcss-entries");

/**
 * Webpack helper function to return several object settings
 *
 * @param path  Path module
 *
 * @return object
 */
function webpackHelpersSettings(path) {

    let entry = {};
    let optimization = {};
    let output = {};
    let miniCssExtractPlugin = {};

    if (process.env.FW_ENVIRONMENT === "development") {

        entry = {
            ...createTsEntry(scriptsFileNames, tsPaths),
            ...createCssEntry(stylesFileNames, pcssPaths),
        };

        output = {
            path: path.resolve(__dirname, "../../assets"),
            assetModuleFilename: "[name][ext]",

            // output to the assets/scripts/js folder
            filename: "scripts/js/[name].js",
        };

        miniCssExtractPlugin = {
            // output to the assets/styles/css folder
            filename: "styles/css/[name].css",
        };

    } else {
        entry = './assets/scripts/ts/main.ts'; // Your main entry file

        optimization = {
            splitChunks: {
                chunks: 'all', // Split all chunks
                minSize: 20000, // Minimum size for a chunk to be generated
                //maxSize: 0,
                minChunks: 1, // Minimum number of chunks that must share a module before splitting
                automaticNameDelimiter: '-',
                cacheGroups: {
                    defaultVendors: {
                        test: /[\\/]node_modules[\\/]/,
                        priority: -10
                    },
                    default: {
                        minChunks: 2,
                        priority: -20,
                        reuseExistingChunk: true
                    },
                },
            },
        };

        output = {
            path: path.resolve(__dirname, "../../assets/scripts/js"),
            filename: 'main.js', // Specify the output file name
            chunkFilename: "[name].bundle.js", // Dynamic chunk filenames
            assetModuleFilename: "[name][ext]"
        };

        miniCssExtractPlugin = {
            filename: "[name].bundle.css",
            chunkFilename: "[name].bundle.css", // Dynamic output for CSS chunks
        }
    }

    return {entry, optimization, output, miniCssExtractPlugin};
}

module.exports = webpackHelpersSettings;
