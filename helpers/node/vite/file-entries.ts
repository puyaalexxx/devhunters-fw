import { globSync } from "glob";

/**
 * Get all file names and their paths
 *
 * @param path Path module from Vite
 * @param searchPaths
 * @param fileExtension
 * @param keySuffix Suffix used for key names
 *
 * @return
 */
export function getFileEntries(path: any, searchPaths: string, fileExtension: string, keySuffix = "") {

    //get all the files from the path
    const files = globSync(searchPaths); // Adjust this path to match your folder structure

    const entries = {};
    //get file name and its path
    files.forEach((file) => {
        const name = path.basename(file, "." + fileExtension);
        entries[name + keySuffix] = file;
    });

    return entries;
}

export default getFileEntries;


