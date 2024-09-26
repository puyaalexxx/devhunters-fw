const isDevelopmentEnv = process.env.DHT_IS_DEV_ENVIRONMENT === "true";
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
        ...(isDevelopmentEnv ? {} : {
            cssnano: {
                preset: "default",
            },
        }), // Enable cssnano only in production
        "postcss-assets": {
            relative: isDevelopmentEnv ? "assets/dist/css/" : "assets/dist/",
            loadPaths: ["**"],
        },
        "postcss-combine-duplicated-selectors": {},
    },
};
