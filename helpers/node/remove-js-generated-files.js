import { dhtuRemoveJsGeneratedFiles } from "devhunters-utils";

const pathsToClean = [
    "assets/scripts/modules/**/*.js",  // Glob pattern
    "assets/scripts/types/**/*.js",  // Glob pattern
    "helpers/node/vite/**/*.js",  // Glob pattern
    "helpers/node/utils/**/*.js",  // Glob pattern
    "assets/scripts/main.js",        // Specific file
];

dhtuRemoveJsGeneratedFiles(pathsToClean).then(r => {
});