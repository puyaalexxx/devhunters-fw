import { dhtuRemoveJsGeneratedFiles } from "devhunters-utils";

const pathsToClean = [
    "assets/scripts/modules/**/*.js",  // Glob pattern
    "assets/scripts/types/**/*.js",  // Glob pattern
    "assets/scripts/helpers/vite/**/*.js",  // Glob pattern
    "assets/scripts/helpers/utils/**/*.js",  // Glob pattern
    "assets/scripts/main.js",        // Specific file
];

dhtuRemoveJsGeneratedFiles(pathsToClean).then(r => {
});