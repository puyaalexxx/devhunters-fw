import scriptsFileNames from "../../../config/webpack/file-names/scripts-file-names";
import createTsEntry from "../../../config/webpack/file-entries/ts-entries";

/**
 * This function is responsible for modules dynamic loading
 * It will be used to dynamically loading the files in
 * Webpack and its code spitting feature
 *
 * @param fileName : string
 *
 * @return void
 */
export async function dhtDynamicLoadingFrameworkFiles(fileName: string) {
    switch (fileName) {

        /////////////////// options bundle ///////////////////
        case 'upload-image':
            //const chunkName = 'upload-image';
            const {initializetUploadImage} = await import(/* webpackChunkName: "options" */ './extensions/options/fields/upload-image');

            initializetUploadImage();

            break;
        default:
            console.warn(`No module found for this file: ${fileName}`);
    }
}

/**
 * This function is used to handle dynamic modules loading from the
 * dhtDynamicLoadingFrameworkFiles, it will pass each file name there and
 * load each module accordingly
 *
 * @param fileName : string
 *
 * @return void
 */
function dhtHandleFileLoad(fileName: string) {
    dhtDynamicLoadingFrameworkFiles(fileName)
        .then(() => {
            console.log(`${fileName} module loaded successfully.`);
        })
        .catch(err => {
            console.error(`Error loading ${fileName} module:`, err);
        });
}


/**
 * Initialize dynamic modules loading by passing
 * the file names of the ts files from the framework
 *
 * @return void
 */
function initializeDynamicModulesLoading() {
    // Define the type to use for TypeScript type checking
    type ScriptFileNames = {
        [key: string]: string;
    };
    // Assert the type of imported object
    const typedScriptsFileNames = scriptsFileNames as ScriptFileNames;

    //go over all script files
    Object.values(typedScriptsFileNames).forEach(fileName => {

        console.log(fileName);

        dhtHandleFileLoad(fileName);
    });
}

//initialize the dynamic module loading
initializeDynamicModulesLoading();