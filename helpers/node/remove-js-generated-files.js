const { globSync } = require("glob");
const { unlink, access } = require("fs").promises;
const { constants } = require("fs");

//check if the file exists
async function fileExists(filePath) {
    try {
        await access(filePath, constants.F_OK);
        return true;
    } catch {
        return false;
    }
}

/**
 * Remove all the tsc compiler js generated files alongside ts files.
 *
 * They are added in dev environment by the tsc command
 * Remove those js files for production environment
 * The file is used in the package.json > scripts area
 *
 * @return
 */
async function removeJsGeneratedFiles() {
    try {
        //add here all the paths that you want to clean up
        const pathsToClean = [
            "assets/scripts/modules/**/*.js",  // Glob pattern
            "assets/scripts/types/**/*.js",  // Glob pattern
            "helpers/node/vite/**/*.js",  // Glob pattern
            "assets/scripts/main.js",        // Specific file
        ];

        for (const item of pathsToClean) {
            // Check if item is a glob pattern or a specific file
            if (item.includes("**")) {
                // Handle as glob pattern
                const files = globSync(item);

                for (const file of files) {

                    //if file does not exist, skip
                    if (!(await fileExists(file))) return;

                    try {
                        await unlink(file);
                    } catch (err) {
                        console.error(`Error removing file ${file}`, err);
                    }
                }
            } else {

                //if file does not exist, skip
                if (!(await fileExists(item))) return;

                // Handle as specific file
                try {
                    await unlink(item);
                } catch (err) {
                    console.error(`Error removing file ${item}`, err);
                }
            }
        }
    } catch (err) {
        console.error("Error processing files", err);
    }
}

removeJsGeneratedFiles().then(r => {
});