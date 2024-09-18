// postcss.config.js
module.exports = {
    plugins: [
        require("postcss-preset-env")({
            stage: 1,
        }),
        require("autoprefixer")(),
        require("postcss-import")(),
        require("postcss-assets")({
            loadPaths: ["./assets/images"],
        }),
        /* require("cssnano")({
             preset: "default",
         }),*/
        require("precss"),
        require("postcss-combine-duplicated-selectors"),
    ],
};
