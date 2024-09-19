module.exports = {
    plugins: {
        "postcss-preset-env": {
            stage: 1,
        },
        "postcss-simple-vars": {}, // Add this if you are using variables
        autoprefixer: {},
        "postcss-import": {},
        "postcss-mixins": {},
        "postcss-nested": {},
        cssnano: {
            preset: "default",
        }, // For minification in production
        "postcss-assets": {
            relative: process.env.DHT_IS_DEV_ENVIRONMENT === "true" ? "assets/dist/css/" : "assets/dist/",
            loadPaths: ["**"],
        },
        "postcss-combine-duplicated-selectors": {},
    },
};
