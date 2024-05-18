const path = require("path");
const webpack = require("webpack");
//minify css files and also adds possibility to compile pcss files to specific css files
const MiniCssExtractPlugin = require("mini-css-extract-plugin");
//webpack is creating also js files that are empty for css files, this plugin removed them
const RemoveEmptyScriptsPlugin = require("webpack-remove-empty-scripts");
//minify js content
const TerserPlugin = require("terser-webpack-plugin");

////////////////////////files
//ts files

//extensions
const dht_wrapper_area_script = "dht-wrapper-area-script";
const switch_script = "switch-script";
const multiinput_script = "multiinput-script";
const ace_editor_script = "ace-editor-script";
const colorpicker_script = "colorpicker-script";
const datepicker_script = "datepicker-script";
const timepicker_script = "timepicker-script";
const datetimepicker_script = "datetimepicker-script";
const rangeslider_script = "rangeslider-script";
const radio_image_script = "radio-image-script";
const multi_options_script = "multi-options-script";

const create_sidebars_script = "create-sidebars-script";

//components
const preloader_script = "preloader-script";

//css files

//extensions
const dht_wrapper_area_style = "dht-wrapper-area-style";
const checkbox_style = "checkbox-style";
const radio_style = "radio-style";
const switch_style = "switch-style";
const multiinput_style = "multiinput-style";
const colorpicker_style = "colorpicker-style";
const datepicker_style = "datepicker-style";
const timepicker_style = "timepicker-style";
const datetimepicker_style = "datetimepicker-style";
const rangeslider_style = "rangeslider-style";
const spacing_style = "spacing-style";
const radio_image_style = "radio-image-style";
const multi_options_style = "multi-options-style";
const borders_style = "borders-style";

const create_sidebars_style = "create-sidebars-style";

//components
const preloader_style = "preloader-style";

module.exports = {
    mode: "development", // or 'production'
    entry: {
        // TypeScript files entries

        //extensions
        //options
        [dht_wrapper_area_script]: "./assets/scripts/ts/extensions/options/" + dht_wrapper_area_script.replace("-script", "") + ".ts",
        [switch_script]: "./assets/scripts/ts/extensions/options/" + switch_script.replace("-script", "") + ".ts",
        [multiinput_script]: "./assets/scripts/ts/extensions/options/" + multiinput_script.replace("-script", "") + ".ts",
        [ace_editor_script]: "./assets/scripts/ts/extensions/options/" + ace_editor_script.replace("-script", "") + ".ts",
        [colorpicker_script]: "./assets/scripts/ts/extensions/options/" + colorpicker_script.replace("-script", "") + ".ts",
        [datepicker_script]: "./assets/scripts/ts/extensions/options/" + datepicker_script.replace("-script", "") + ".ts",
        [timepicker_script]: "./assets/scripts/ts/extensions/options/" + timepicker_script.replace("-script", "") + ".ts",
        [datetimepicker_script]: "./assets/scripts/ts/extensions/options/" + datetimepicker_script.replace("-script", "") + ".ts",
        [rangeslider_script]: "./assets/scripts/ts/extensions/options/" + rangeslider_script.replace("-script", "") + ".ts",
        [radio_image_script]: "./assets/scripts/ts/extensions/options/" + radio_image_script.replace("-script", "") + ".ts",
        [multi_options_script]: "./assets/scripts/ts/extensions/options/" + multi_options_script.replace("-script", "") + ".ts",

        //sidebars
        [create_sidebars_script]: "./assets/scripts/ts/extensions/" + create_sidebars_script.replace("-script", "") + ".ts",

        //components
        [preloader_script]: "./assets/scripts/ts/components/" + preloader_script.replace("-script", "") + ".ts",

        //CSS entries
        //many entries to one
        /*css: [
            './assets/styles/postcss/create-sidebars.pcss',
            './assets/styles/postcss/options/checkbox.pcss',
        ],*/

        //extensions
        //options styles
        [dht_wrapper_area_style]: "./assets/styles/postcss/extensions/options/" + dht_wrapper_area_style.replace("-style", "") + ".pcss", // dht wrapper area CSS entry point
        [checkbox_style]: "./assets/styles/postcss/extensions/options/" + checkbox_style.replace("-style", "") + ".pcss", // Checkbox CSS entry point
        [radio_style]: "./assets/styles/postcss/extensions/options/" + radio_style.replace("-style", "") + ".pcss", // radio CSS entry point
        [switch_style]: "./assets/styles/postcss/extensions/options/" + switch_style.replace("-style", "") + ".pcss", // switch CSS entry point
        [multiinput_style]: "./assets/styles/postcss/extensions/options/" + multiinput_style.replace("-style", "") + ".pcss", // multiinput CSS entry point
        [colorpicker_style]: "./assets/styles/postcss/extensions/options/" + colorpicker_style.replace("-style", "") + ".pcss", // colorpicker CSS entry point
        [datepicker_style]: "./assets/styles/postcss/extensions/options/" + datepicker_style.replace("-style", "") + ".pcss", // datepicker CSS entry point
        [timepicker_style]: "./assets/styles/postcss/extensions/options/" + timepicker_style.replace("-style", "") + ".pcss", // timepicker CSS entry point
        [datetimepicker_style]: "./assets/styles/postcss/extensions/options/" + datetimepicker_style.replace("-style", "") + ".pcss", // datetimepicker CSS entry point
        [rangeslider_style]: "./assets/styles/postcss/extensions/options/" + rangeslider_style.replace("-style", "") + ".pcss", // range slider CSS entry point
        [spacing_style]: "./assets/styles/postcss/extensions/options/" + spacing_style.replace("-style", "") + ".pcss", // spacing CSS entry point
        [radio_image_style]: "./assets/styles/postcss/extensions/options/" + radio_image_style.replace("-style", "") + ".pcss", // radio images CSS entry point
        [multi_options_style]: "./assets/styles/postcss/extensions/options/" + multi_options_style.replace("-style", "") + ".pcss", // multi options CSS entry point
        [borders_style]: "./assets/styles/postcss/extensions/options/" + borders_style.replace("-style", "") + ".pcss", // multi options CSS entry point

        //sidebars
        [create_sidebars_style]: "./assets/styles/postcss/extensions/" + create_sidebars_style.replace("-style", "") + ".pcss", // Sidebars CSS entry point

        //components
        [preloader_style]: "./assets/styles/postcss/components/" + preloader_style.replace("-style", "") + ".pcss", // Sidebars CSS entry point
    },
    output: {
        path: path.resolve(__dirname, "assets"),
        assetModuleFilename: "[name][ext]",

        //compile ts files in different folders
        filename: (chunkData) => {
            //output to the options folder
            if (chunkData.chunk.name === dht_wrapper_area_script) {
                return "scripts/js/extensions/options/" + dht_wrapper_area_script + ".js";
            }
            if (chunkData.chunk.name === switch_script) {
                return "scripts/js/extensions/options/" + switch_script + ".js";
            }
            if (chunkData.chunk.name === multiinput_script) {
                return "scripts/js/extensions/options/" + multiinput_script + ".js";
            }
            if (chunkData.chunk.name === ace_editor_script) {
                return "scripts/js/extensions/options/" + ace_editor_script + ".js";
            }
            if (chunkData.chunk.name === colorpicker_script) {
                return "scripts/js/extensions/options/" + colorpicker_script + ".js";
            }
            if (chunkData.chunk.name === datepicker_script) {
                return "scripts/js/extensions/options/" + datepicker_script + ".js";
            }
            if (chunkData.chunk.name === timepicker_script) {
                return "scripts/js/extensions/options/" + timepicker_script + ".js";
            }
            if (chunkData.chunk.name === datetimepicker_script) {
                return "scripts/js/extensions/options/" + datetimepicker_script + ".js";
            }
            if (chunkData.chunk.name === rangeslider_script) {
                return "scripts/js/extensions/options/" + rangeslider_script + ".js";
            }
            if (chunkData.chunk.name === radio_image_script) {
                return "scripts/js/extensions/options/" + radio_image_script + ".js";
            }
            if (chunkData.chunk.name === multi_options_script) {
                return "scripts/js/extensions/options/" + multi_options_script + ".js";
            }

            //sidebars
            if (chunkData.chunk.name === create_sidebars_script) {
                return "scripts/js/extensions/" + create_sidebars_script + ".js";
            }

            //components
            if (chunkData.chunk.name === preloader_script) {
                return "scripts/js/components/" + preloader_script + ".js";
            }

            // output to the js folder
            return "scripts/js/[name].js";
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
                //dht wrapper area  file
                if (chunkData.chunk.name === dht_wrapper_area_style) {
                    return "styles/css/extensions/options/" + dht_wrapper_area_style + ".css"; // Output to 'css/options' folder
                }

                //////////extensions
                //options
                if (chunkData.chunk.name === checkbox_style) {
                    return "styles/css/extensions/options/" + checkbox_style + ".css"; // Output to 'css/options' folder
                } //checkbox option file

                if (chunkData.chunk.name === radio_style) {
                    return "styles/css/extensions/options/" + radio_style + ".css";
                } //radio option file
                if (chunkData.chunk.name === switch_style) {
                    return "styles/css/extensions/options/" + switch_style + ".css";
                } //radio option file
                if (chunkData.chunk.name === multiinput_style) {
                    return "styles/css/extensions/options/" + multiinput_style + ".css";
                } //multiinput option file
                if (chunkData.chunk.name === colorpicker_style) {
                    return "styles/css/extensions/options/" + colorpicker_style + ".css";
                } //colorpicker option file
                if (chunkData.chunk.name === datepicker_style) {
                    return "styles/css/extensions/options/" + datepicker_style + ".css";
                } //datepicker option file
                if (chunkData.chunk.name === timepicker_style) {
                    return "styles/css/extensions/options/" + timepicker_style + ".css";
                } //timepicker option file
                if (chunkData.chunk.name === datetimepicker_style) {
                    return "styles/css/extensions/options/" + datetimepicker_style + ".css";
                } //datetimepicker option file
                if (chunkData.chunk.name === rangeslider_style) {
                    return "styles/css/extensions/options/" + rangeslider_style + ".css";
                } //rangeslider option file
                if (chunkData.chunk.name === spacing_style) {
                    return "styles/css/extensions/options/" + spacing_style + ".css";
                } //spacing option file
                if (chunkData.chunk.name === radio_image_style) {
                    return "styles/css/extensions/options/" + radio_image_style + ".css";
                } //radio images option file
                if (chunkData.chunk.name === multi_options_style) {
                    return "styles/css/extensions/options/" + multi_options_style + ".css";
                } //multi options option file
                if (chunkData.chunk.name === borders_style) {
                    return "styles/css/extensions/options/" + borders_style + ".css";
                } //border option file

                //sidebars
                if (chunkData.chunk.name === create_sidebars_style) {
                    return "styles/css/extensions/" + create_sidebars_style + ".css";
                }

                //////////components
                //preloader
                if (chunkData.chunk.name === preloader_style) {
                    return "styles/css/components/" + preloader_style + ".css";
                }

                // For other entry points, output to root 'css' folder
                return "styles/css/[name].css";
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
    // Other webpack configuration options...
};
