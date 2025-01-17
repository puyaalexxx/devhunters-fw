import { defineConfig } from "vite";
import * as path from "path";
import * as dotenv from "dotenv";
import { dhtuGetFileEntries, dhtuGetViteConfigs } from "devhunters-utils";

// Load environment variables from the .env file
dotenv.config();
const ROOT = path.resolve("../../..");
const BASE = __dirname.replace(ROOT, "");
// this is needed because the pcs s files keys are the same as the ts ones, and they are overriding each other in the input area
const tsFilesSuffix = "-script";

const pcssFiles = dhtuGetFileEntries(path, "assets/styles/modules/**/*.pcss", "pcss");
const tsFiles = dhtuGetFileEntries(path, "assets/scripts/modules/**/*.ts", "ts", tsFilesSuffix);

export default defineConfig(({ command }) => {
    const separate = process.env.VITE_SEPARATE === "true";
    const isDevelopmentEnv = process.env.DHT_IS_DEV_ENVIRONMENT === "true";

    //get vite configs
    const {
        input,
        manualChunks,
        entryFileNames,
        assetFileNames,
        cssCodeSplit,
    } = dhtuGetViteConfigs(separate, tsFiles, pcssFiles, tsFilesSuffix, {
        mainEntry: "assets/scripts",
        tsChunks: "assets/scripts/modules",
        assetFileNames: "assets",
    });

    return {
        base: `${BASE}/assets/dist/`,
        define: {
            "$": "window.jQuery",
            "process.env.DHT_IS_DEV_ENVIRONMENT": JSON.stringify(isDevelopmentEnv),
            __IS_DEV__: JSON.stringify(process.env.VITE_IS_DEV === "true"),
        },
        build: {
            manifest: true,
            outDir: `assets/dist`,
            assetsDir: ".",
            emptyOutDir: true,
            sourcemap: isDevelopmentEnv,
            minify: !isDevelopmentEnv,  // Disable minification
            rollupOptions: {
                input: input,
                output: {
                    entryFileNames: entryFileNames,
                    chunkFileNames: "[name].js",
                    manualChunks: manualChunks,
                    assetFileNames: assetFileNames,
                },
                external: ["jquery"],
            },
            cssCodeSplit: cssCodeSplit,
            watch: command === "serve" ? {} : null, // watch mode available for dev mode only
        },
        plugins: [],
        resolve: {
            alias: {
                "@": path.resolve(__dirname, "assets"),
                "@ts": path.resolve(__dirname, "assets/scripts"),
                "@pcss": path.resolve(__dirname, "assets/styles"),
                "@dist": path.resolve(__dirname, "assets/dist"),
                "@helpers": path.resolve(__dirname, "assets/scripts/helpers"),
            },
        },
    };
});