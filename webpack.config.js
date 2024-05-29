const path = require("path");
const webpack = require("webpack");
//minify css files and also adds possibility to compile pcss files to specific css files
const MiniCssExtractPlugin = require("mini-css-extract-plugin");
//webpack is creating also js files that are empty for css files, this plugin removed them
const RemoveEmptyScriptsPlugin = require("webpack-remove-empty-scripts");
//minify js content
const TerserPlugin = require("terser-webpack-plugin");

////////////////////////files

//////////////////////////////////////////ts files
/////////extensions - options - ts
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
const upload_image_script = "upload-image-script";
const upload_script = "upload-script";
const upload_gallery_script = "upload-gallery-script";
const icon_script = "icon-script";
const typography_script = "typography-script";

/////////extensions - options - groups - ts
const tabs_script = "tabs-script";
const accordion_script = "accordion-script";

/////////extensions - sidebars - ts
const create_sidebars_script = "create-sidebars-script";

//components - preloader - ts
const preloader_script = "preloader-script";

////////////////////////////////////////css files
/////////extensions - options - pcss
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
const upload_image_style = "upload-image-style";
const upload_style = "upload-style";
const upload_gallery_style = "upload-gallery-style";
const icon_style = "icon-style";
const typography_style = "typography-style";

/////////extensions - options - groups - pcss
const group_style = "group-style";
const tabs_style = "tabs-style";
const accordion_style = "accordion-style";

/////////extensions - sidebars - pcss
const create_sidebars_style = "create-sidebars-style";

/////////components - preloader - pcss
const preloader_style = "preloader-style";

module.exports = {
    mode: "development", // or 'production'
    entry: {
        // TypeScript files entries

        /////////extensions - options - wrapper - ts
        [dht_wrapper_area_script]: "./assets/scripts/ts/extensions/options/" + dht_wrapper_area_script.replace("-script", "") + ".ts",
        /////////extensions - options - ts
        [switch_script]: "./assets/scripts/ts/extensions/options/options/" + switch_script.replace("-script", "") + ".ts",
        [multiinput_script]: "./assets/scripts/ts/extensions/options/options/" + multiinput_script.replace("-script", "") + ".ts",
        [ace_editor_script]: "./assets/scripts/ts/extensions/options/options/" + ace_editor_script.replace("-script", "") + ".ts",
        [colorpicker_script]: "./assets/scripts/ts/extensions/options/options/" + colorpicker_script.replace("-script", "") + ".ts",
        [datepicker_script]: "./assets/scripts/ts/extensions/options/options/" + datepicker_script.replace("-script", "") + ".ts",
        [timepicker_script]: "./assets/scripts/ts/extensions/options/options/" + timepicker_script.replace("-script", "") + ".ts",
        [datetimepicker_script]: "./assets/scripts/ts/extensions/options/options/" + datetimepicker_script.replace("-script", "") + ".ts",
        [rangeslider_script]: "./assets/scripts/ts/extensions/options/options/" + rangeslider_script.replace("-script", "") + ".ts",
        [radio_image_script]: "./assets/scripts/ts/extensions/options/options/" + radio_image_script.replace("-script", "") + ".ts",
        [multi_options_script]: "./assets/scripts/ts/extensions/options/options/" + multi_options_script.replace("-script", "") + ".ts",
        [upload_image_script]: "./assets/scripts/ts/extensions/options/options/" + upload_image_script.replace("-script", "") + ".ts",
        [upload_script]: "./assets/scripts/ts/extensions/options/options/" + upload_script.replace("-script", "") + ".ts",
        [upload_gallery_script]: "./assets/scripts/ts/extensions/options/options/" + upload_gallery_script.replace("-script", "") + ".ts",
        [icon_script]: "./assets/scripts/ts/extensions/options/options/" + icon_script.replace("-script", "") + ".ts",
        [typography_script]: "./assets/scripts/ts/extensions/options/options/" + typography_script.replace("-script", "") + ".ts",

        /////////extensions - options - groups - ts
        [tabs_script]: "./assets/scripts/ts/extensions/options/groups/" + tabs_script.replace("-script", "") + ".ts",
        [accordion_script]: "./assets/scripts/ts/extensions/options/groups/" + accordion_script.replace("-script", "") + ".ts",

        /////////extensions - sidebars - ts
        [create_sidebars_script]: "./assets/scripts/ts/extensions/sidebars/" + create_sidebars_script.replace("-script", "") + ".ts",

        /////////components - preloader - ts
        [preloader_script]: "./assets/scripts/ts/components/preloader/" + preloader_script.replace("-script", "") + ".ts",

        //CSS entries
        //many entries to one
        /*css: [
            './assets/styles/postcss/create-sidebars.pcss',
            './assets/styles/postcss/options/checkbox.pcss',
        ],*/

        /////////extensions - options - wrapper - css
        [dht_wrapper_area_style]: "./assets/styles/postcss/extensions/options/" + dht_wrapper_area_style.replace("-style", "") + ".pcss", // dht wrapper area CSS entry point
        /////////extensions - options - css
        [checkbox_style]: "./assets/styles/postcss/extensions/options/options/" + checkbox_style.replace("-style", "") + ".pcss", // Checkbox CSS entry point
        [radio_style]: "./assets/styles/postcss/extensions/options/options/" + radio_style.replace("-style", "") + ".pcss", // radio CSS entry point
        [switch_style]: "./assets/styles/postcss/extensions/options/options/" + switch_style.replace("-style", "") + ".pcss", // switch CSS entry point
        [multiinput_style]: "./assets/styles/postcss/extensions/options/options/" + multiinput_style.replace("-style", "") + ".pcss", // multiinput CSS entry point
        [colorpicker_style]: "./assets/styles/postcss/extensions/options/options/" + colorpicker_style.replace("-style", "") + ".pcss", // colorpicker CSS entry point
        [datepicker_style]: "./assets/styles/postcss/extensions/options/options/" + datepicker_style.replace("-style", "") + ".pcss", // datepicker CSS entry point
        [timepicker_style]: "./assets/styles/postcss/extensions/options/options/" + timepicker_style.replace("-style", "") + ".pcss", // timepicker CSS entry point
        [datetimepicker_style]: "./assets/styles/postcss/extensions/options/options/" + datetimepicker_style.replace("-style", "") + ".pcss", // datetimepicker CSS entry point
        [rangeslider_style]: "./assets/styles/postcss/extensions/options/options/" + rangeslider_style.replace("-style", "") + ".pcss", // range slider CSS entry point
        [spacing_style]: "./assets/styles/postcss/extensions/options/options/" + spacing_style.replace("-style", "") + ".pcss", // spacing CSS entry point
        [radio_image_style]: "./assets/styles/postcss/extensions/options/options/" + radio_image_style.replace("-style", "") + ".pcss", // radio images CSS entry point
        [multi_options_style]: "./assets/styles/postcss/extensions/options/options/" + multi_options_style.replace("-style", "") + ".pcss", // multi options CSS entry point
        [borders_style]: "./assets/styles/postcss/extensions/options/options/" + borders_style.replace("-style", "") + ".pcss", // multi options CSS entry point
        [upload_image_style]: "./assets/styles/postcss/extensions/options/options/" + upload_image_style.replace("-style", "") + ".pcss", // multi options CSS entry point
        [upload_style]: "./assets/styles/postcss/extensions/options/options/" + upload_style.replace("-style", "") + ".pcss", // multi options CSS entry point
        [upload_gallery_style]: "./assets/styles/postcss/extensions/options/options/" + upload_gallery_style.replace("-style", "") + ".pcss", // multi options CSS entry point
        [icon_style]: "./assets/styles/postcss/extensions/options/options/" + icon_style.replace("-style", "") + ".pcss", // multi options CSS entry point
        [typography_style]: "./assets/styles/postcss/extensions/options/options/" + typography_style.replace("-style", "") + ".pcss", // multi options CSS entry point

        /////////extensions - options - groups - css
        [group_style]: "./assets/styles/postcss/extensions/options/groups/" + group_style.replace("-style", "") + ".pcss", // multi options CSS entry point
        [tabs_style]: "./assets/styles/postcss/extensions/options/groups/" + tabs_style.replace("-style", "") + ".pcss", // multi options CSS entry point
        [accordion_style]: "./assets/styles/postcss/extensions/options/groups/" + accordion_style.replace("-style", "") + ".pcss", // multi options CSS entry point

        /////////extensions - sidebars - css
        [create_sidebars_style]: "./assets/styles/postcss/extensions/sidebars/" + create_sidebars_style.replace("-style", "") + ".pcss", // Sidebars CSS entry point

        /////////components - preloader - css
        [preloader_style]: "./assets/styles/postcss/components/preloader/" + preloader_style.replace("-style", "") + ".pcss", // Sidebars CSS entry point
    },
    output: {
        path: path.resolve(__dirname, "assets"),
        assetModuleFilename: "[name][ext]",

        //compile ts files in different folders
        filename: (chunkData) => {
            /////////extensions - options - js
            if (chunkData.chunk.name === dht_wrapper_area_script) {
                return "scripts/js/extensions/options/" + dht_wrapper_area_script + ".js";
            } //dht wrapper option file
            if (chunkData.chunk.name === switch_script) {
                return "scripts/js/extensions/options/options/" + switch_script + ".js";
            } //switch option file
            if (chunkData.chunk.name === multiinput_script) {
                return "scripts/js/extensions/options/options/" + multiinput_script + ".js";
            } //multiinput option file
            if (chunkData.chunk.name === ace_editor_script) {
                return "scripts/js/extensions/options/options/" + ace_editor_script + ".js";
            } //ace editor option file
            if (chunkData.chunk.name === colorpicker_script) {
                return "scripts/js/extensions/options/options/" + colorpicker_script + ".js";
            } //colorpicker option file
            if (chunkData.chunk.name === datepicker_script) {
                return "scripts/js/extensions/options/options/" + datepicker_script + ".js";
            } //datepicker option file
            if (chunkData.chunk.name === timepicker_script) {
                return "scripts/js/extensions/options/options/" + timepicker_script + ".js";
            } //timepicker option file
            if (chunkData.chunk.name === datetimepicker_script) {
                return "scripts/js/extensions/options/options/" + datetimepicker_script + ".js";
            } //datetimepicker option file
            if (chunkData.chunk.name === rangeslider_script) {
                return "scripts/js/extensions/options/options/" + rangeslider_script + ".js";
            } //rangeslider option file
            if (chunkData.chunk.name === radio_image_script) {
                return "scripts/js/extensions/options/options/" + radio_image_script + ".js";
            } // radio image
            if (chunkData.chunk.name === multi_options_script) {
                return "scripts/js/extensions/options/options/" + multi_options_script + ".js";
            } //multioptions option file
            if (chunkData.chunk.name === upload_image_script) {
                return "scripts/js/extensions/options/options/" + upload_image_script + ".js";
            } //upload image option file
            if (chunkData.chunk.name === upload_script) {
                return "scripts/js/extensions/options/options/" + upload_script + ".js";
            } //upload option file
            if (chunkData.chunk.name === upload_gallery_script) {
                return "scripts/js/extensions/options/options/" + upload_gallery_script + ".js";
            } //upload gallery option file
            if (chunkData.chunk.name === icon_script) {
                return "scripts/js/extensions/options/options/" + icon_script + ".js";
            } //icon option file
            if (chunkData.chunk.name === typography_script) {
                return "scripts/js/extensions/options/options/" + typography_script + ".js";
            } //typography

            /////////extensions - options - group - js
            if (chunkData.chunk.name === tabs_script) {
                return "scripts/js/extensions/options/groups/" + tabs_script + ".js";
            } //tabs
            if (chunkData.chunk.name === accordion_script) {
                return "scripts/js/extensions/options/groups/" + accordion_script + ".js";
            } //accordion

            /////////extensions - options - js
            if (chunkData.chunk.name === create_sidebars_script) {
                return "scripts/js/extensions/sidebars/" + create_sidebars_script + ".js";
            }

            /////////components - preloader - js
            if (chunkData.chunk.name === preloader_script) {
                return "scripts/js/components/preloader/" + preloader_script + ".js";
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
                /////////extensions - options - css
                if (chunkData.chunk.name === dht_wrapper_area_style) {
                    return "styles/css/extensions/options/" + dht_wrapper_area_style + ".css";
                } //dht wrapper area  file
                if (chunkData.chunk.name === checkbox_style) {
                    return "styles/css/extensions/options/options/" + checkbox_style + ".css";
                } //checkbox option file

                if (chunkData.chunk.name === radio_style) {
                    return "styles/css/extensions/options/options/" + radio_style + ".css";
                } //radio option file
                if (chunkData.chunk.name === switch_style) {
                    return "styles/css/extensions/options/options/" + switch_style + ".css";
                } //radio option file
                if (chunkData.chunk.name === multiinput_style) {
                    return "styles/css/extensions/options/options/" + multiinput_style + ".css";
                } //multiinput option file
                if (chunkData.chunk.name === colorpicker_style) {
                    return "styles/css/extensions/options/options/" + colorpicker_style + ".css";
                } //colorpicker option file
                if (chunkData.chunk.name === datepicker_style) {
                    return "styles/css/extensions/options/options/" + datepicker_style + ".css";
                } //datepicker option file
                if (chunkData.chunk.name === timepicker_style) {
                    return "styles/css/extensions/options/options/" + timepicker_style + ".css";
                } //timepicker option file
                if (chunkData.chunk.name === datetimepicker_style) {
                    return "styles/css/extensions/options/options/" + datetimepicker_style + ".css";
                } //datetimepicker option file
                if (chunkData.chunk.name === rangeslider_style) {
                    return "styles/css/extensions/options/options/" + rangeslider_style + ".css";
                } //rangeslider option file
                if (chunkData.chunk.name === spacing_style) {
                    return "styles/css/extensions/options/options/" + spacing_style + ".css";
                } //spacing option file
                if (chunkData.chunk.name === radio_image_style) {
                    return "styles/css/extensions/options/options/" + radio_image_style + ".css";
                } //radio images option file
                if (chunkData.chunk.name === multi_options_style) {
                    return "styles/css/extensions/options/options/" + multi_options_style + ".css";
                } //multi options option file
                if (chunkData.chunk.name === borders_style) {
                    return "styles/css/extensions/options/options/" + borders_style + ".css";
                } //border option file
                if (chunkData.chunk.name === upload_image_style) {
                    return "styles/css/extensions/options/options/" + upload_image_style + ".css";
                } //upload image option file
                if (chunkData.chunk.name === upload_style) {
                    return "styles/css/extensions/options/options/" + upload_style + ".css";
                } //upload option file
                if (chunkData.chunk.name === upload_gallery_style) {
                    return "styles/css/extensions/options/options/" + upload_gallery_style + ".css";
                } //upload gallery option file
                if (chunkData.chunk.name === icon_style) {
                    return "styles/css/extensions/options/options/" + icon_style + ".css";
                } //icon option file
                if (chunkData.chunk.name === typography_style) {
                    return "styles/css/extensions/options/options/" + typography_style + ".css";
                } //typography option file

                /////////extensions - options - groups - css
                if (chunkData.chunk.name === group_style) {
                    return "styles/css/extensions/options/groups/" + group_style + ".css";
                } //group option file
                if (chunkData.chunk.name === tabs_style) {
                    return "styles/css/extensions/options/groups/" + tabs_style + ".css";
                } //tabs option file
                if (chunkData.chunk.name === accordion_style) {
                    return "styles/css/extensions/options/groups/" + accordion_style + ".css";
                } //accordion option file

                /////////extensions - sidebars - css
                if (chunkData.chunk.name === create_sidebars_style) {
                    return "styles/css/extensions/sidebars/" + create_sidebars_style + ".css";
                }

                /////////components - preloader - css
                if (chunkData.chunk.name === preloader_style) {
                    return "styles/css/components/preloader/" + preloader_style + ".css";
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
