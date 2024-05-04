const path = require('path')
const MiniCssExtractPlugin = require('mini-css-extract-plugin')
const RemoveEmptyScriptsPlugin = require('webpack-remove-empty-scripts')

////////////////////////files
//ts files
const checkbox_script = 'checkbox-script'
const create_sidebars_script = 'create-sidebars-script'

//css files
const checkbox_style = 'checkbox-style'
const create_sidebars_style = 'create-sidebars-style'

module.exports = {
    mode: 'development', // or 'production'
    entry: {
        // TypeScript files entries
        [create_sidebars_script]:
            './assets/scripts/ts/' +
            create_sidebars_script.replace('-script', '') +
            '.ts',
        [checkbox_script]:
            './assets/scripts/ts/options/' +
            checkbox_script.replace('-script', '') +
            '.ts',

        //CSS entries
        //many entries to one
        /*css: [
            './assets/styles/postcss/create-sidebars.pcss',
            './assets/styles/postcss/options/checkbox.pcss',
        ],*/
        [checkbox_style]:
            './assets/styles/postcss/options/' +
            checkbox_style.replace('-style', '') +
            '.pcss', // Checkbox CSS entry point

        [create_sidebars_style]:
            './assets/styles/postcss/' +
            create_sidebars_style.replace('-style', '') +
            '.pcss', // Sidebars CSS entry point
    },
    output: {
        path: path.resolve(__dirname, 'assets'),

        //compile ts files in different folders
        filename: (chunkData) => {
            //output to the options folder
            if (chunkData.chunk.name === checkbox_script) {
                return 'scripts/js/options/' + checkbox_script + '.js'
            }
            // output to the js folder
            return 'scripts/js/[name].js'
        },
    },
    module: {
        rules: [
            {
                oneOf: [
                    {
                        test: /\.pcss$/, // Match PostCSS files
                        use: [
                            MiniCssExtractPlugin.loader, // minify css files
                            //'style-loader',
                            'css-loader', // Resolve CSS imports
                            'postcss-loader', // Process CSS with PostCSS
                        ],
                    },
                    {
                        test: /\.tsx?$/, // Match TypeScript files
                        use: 'ts-loader', // Use ts-loader for compilation
                        exclude: /node_modules/, // Exclude node_modules directory
                    },
                ],
            },
        ],
    },
    resolve: {
        extensions: ['.ts', '.tsx', '.js', '.css', '.pcss'], // Resolve TypeScript and JavaScript extensions,
        modules: [path.resolve(__dirname, 'node_modules')],
    },
    plugins: [
        // MiniCssExtractPlugin instance for 'options-checkbox' entry
        new MiniCssExtractPlugin({
            filename: (chunkData) => {
                //checkbox option file
                if (chunkData.chunk.name === checkbox_style) {
                    return 'styles/css/options/' + checkbox_style + '.css' // Output to 'css/options' folder
                }

                // For other entry points, output to root 'css' folder
                return 'styles/css/[name].css'
            },
        }),
        // Add RemoveEmptyScriptsPlugin to remove empty JavaScript files
        new RemoveEmptyScriptsPlugin(),
    ],
    externals: {
        jquery: 'jQuery',
    },
    // Other webpack configuration options...
}
