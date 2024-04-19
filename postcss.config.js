// postcss.config.js
module.exports = {
    plugins: [
        require('postcss-preset-env')({
            stage: 1,
        }),
        require('autoprefixer')(),
        require('postcss-import')(),
        /*require('postcss-assets')({
            loadPath  : ['dist/img']
        }),*/
        /*require('cssnano')({
            preset: 'default'
        }),*/
        require('precss'),
    ],
}
