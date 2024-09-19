import { defineConfig } from "vite";
import path from "path";
import getFileEntries from "./helpers/node/vite/file-entries";
import getViteConfigs from "./helpers/node/vite/config-helpers";

// Assuming getFileEntries is already defined elsewhere in your code
const ROOT = path.resolve("../../..");
const BASE = __dirname.replace(ROOT, "");

const pcssFiles = getFileEntries(path, "assets/styles/modules/**/*.pcss", "pcss");
const tsFilesSuffix = "-script"; // this is needed because the pcss files keys are the same as the ts ones, and they are overriding each other in the input area
const tsFiles = getFileEntries(path, "assets/scripts/modules/**/*.ts", "ts", tsFilesSuffix);

export default defineConfig(({ mode }) => {

    const isDevelopmentEnv = mode === "development";
    //constant used in postcss.config file
    process.env.DHT_IS_DEV_ENVIRONMENT = isDevelopmentEnv.toString();

    //get vite configs
    const {
        input,
        manualChunks,
        entryFileNames,
        cssCodeSplit,
    } = getViteConfigs(isDevelopmentEnv, tsFiles, pcssFiles, tsFilesSuffix);

    return {
        base: `${BASE}/assets/dist/`,
        define: {
            "$": "window.jQuery",
            "process.env.DHT_IS_DEV_ENVIRONMENT": JSON.stringify(isDevelopmentEnv),
        },
        build: {
            manifest: true,
            outDir: `assets/dist`,
            assetsDir: ".",
            emptyOutDir: true,
            sourcemap: isDevelopmentEnv,
            rollupOptions: {
                input: input,
                output: {
                    entryFileNames: entryFileNames,
                    chunkFileNames: "[name].js",
                    manualChunks: manualChunks,
                    assetFileNames: (assetInfo) => {
                        if (assetInfo.name && assetInfo.name.endsWith(".css")) {
                            const fileName = assetInfo.name.replace(".css", "");
                            return assetInfo.name.includes("style.css")
                                ? `main[extname]`
                                : `css/${fileName}[extname]`;
                        }
                        return "assets/[name][extname]";
                    },
                },
                external: ["jquery"],
            },
            cssCodeSplit: cssCodeSplit,
        },
        css: {
            postcss: path.resolve(__dirname, "postcss.config.js"),
            devSourcemap: isDevelopmentEnv, // Enable source maps for CSS in development mode
        },
        plugins: [
            {
                name: "php",
                handleHotUpdate({ file, server }) {
                    if (file.endsWith(".php")) {
                        server.ws.send({ type: "full-reload" });
                    }
                },
            },
        ],
        resolve: {
            alias: {
                "@": path.resolve(__dirname, "assets"),
                "@ts": path.resolve(__dirname, "assets/scripts/modules"),
            },
        },
    };
});