import { defineConfig } from "vite";
import path from "path";

const ROOT = path.resolve("../../..");
const BASE = __dirname.replace(ROOT, "");

/*process.env.NODE_ENV === "production"*/
export default defineConfig({
    base: `${BASE}/assets/dist/`,
    define: {
        "$": "window.jQuery",
    },
    build: {
        manifest: true,
        assetsDir: ".",
        outDir: `assets/dist`,
        emptyOutDir: true,
        sourcemap: true,
        rollupOptions: {
            input: [
                "assets/scripts/main.ts",
                //'resources/styles/styles.scss',
            ],
            output: {
                entryFileNames: "main.js",
                chunkFileNames: "[name].js", // Define how to name the chunk files (remove hash from the name)
                assetFileNames: "[hash].[ext]",
                manualChunks(id) {
                    //get only the modules folder files
                    if (id.includes("assets/scripts/modules")) {
                        const parts = id.split("assets/scripts/modules")[1].split("/");

                        // Return a custom chunk name based on the file name
                        return parts.length > 1
                            ? `js/${parts[parts.length - 1].replace(".ts", "")}`
                            : `js/[name].js`; // Fallback if path parts are not found
                    }
                },
            },
            external: ["jquery"],
        },
    },
    plugins: [],
    resolve: {
        alias: {
            "@": path.resolve(__dirname, "assets"),
            "@ts": path.resolve(__dirname, "assets/scripts/modules"),
        },
    },
});
