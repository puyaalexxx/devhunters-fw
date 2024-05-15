// postcss.config.js
module.exports = {
    plugins: [
        require("postcss-preset-env")({
            stage: 1,
        }),
        require("autoprefixer")(),
        require("postcss-import")(),
        require("postcss-assets")({
            relative: true, // Resolve paths relative to the CSS file directory
            loadPaths: ["assets/images/"], // Path to search for assets
            basePath: "assets/", // Base path for URLs
        }),
        require("cssnano")({
            preset: "default",
        }),
        require("precss"),
    ],
};
