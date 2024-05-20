import { defineConfig } from "vite";
import react from "@vitejs/plugin-react";

// https://vitejs.dev/config/
export default defineConfig({
    plugins: [react()],
    build: {
        outDir: "../dist-react-app", // specify the output directory relative to the current directory
        emptyOutDir: true, // This ensures the output directory is emptied before building
        manifest: true,
    },
    resolve: {
        alias: {
            "@": "/react-app/src", // Adjust according to your directory structure
        },
    },
    server: {
        port: 3000,
    },
});
