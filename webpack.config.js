const path = require('path');

module.exports = {
    mode: 'development', // or 'production'
    entry: {
        // Define entry points for each TypeScript file in the source directory
        'create-sidebars': './assets/scripts/ts/create-sidebars.ts',

        // Add more entries as needed
    },
    output: {
        // Output directory for the compiled JavaScript files
        path: path.resolve(__dirname, 'assets/scripts/js'),
        // Name of the compiled JavaScript files, [name] will be replaced with the entry point name
        filename: '[name].js',
    },
    module: {
        rules: [
            {
                test: /\.tsx?$/, // Match TypeScript files
                use: 'ts-loader', // Use ts-loader for compilation
                exclude: /node_modules/, // Exclude node_modules directory
            },
            {
                test: /\.css$/,
                use: [
                    'style-loader',
                    'css-loader',
                    'postcss-loader' // Add PostCSS loader
                ]
            }
        ],
    },
    resolve: {
        extensions: ['.ts', '.tsx', '.js', '.css'], // Resolve TypeScript and JavaScript extensions,
        modules: [path.resolve(__dirname, 'node_modules')]
    },
    externals: {
        jquery: 'jQuery',
    }
    // Other webpack configuration options...
};