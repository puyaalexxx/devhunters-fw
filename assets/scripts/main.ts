import getCurrentPageModules from "../../helpers/node/vite/current-page-ts-files";

/**
 * Helper function to load modules dynamically
 *
 * @return void
 */
async function loadModule(modules: Record<string, () => Promise<unknown>>, fileName: string, fileExtension = "ts") {
    try {
        const searchModule = `/${fileName}.${fileExtension}`;

        //see if the module path exists in the modules object from the vite glob function
        const fullModulePath = Object.keys(modules).find((key: string) =>
            key.includes(searchModule),
        );

        //if path exist, load it dynamically
        if (fullModulePath) {
            await modules[fullModulePath]();
        }

    } catch (err) {
        console.error(`Error loading ${fileName} module:`, err);
    }
}

/**
 * This function is responsible for dynamic loading the js modules
 * It will be used to dynamically loading the files in Webpack
 * and its code spitting feature
 *
 * This function will load all modules from the /modules folder
 *
 * @return void
 */
async function initializeJSDynamicModulesLoading() {

    //get all the ts files that needs to be dynamically loaded
    const allModules = import.meta.glob("@ts/**/*.ts");

    //get existent current page modules
    const pageModules = getCurrentPageModules(allModules);

    //dynamically load every existent page module
    for (const fileName of pageModules) {
        await loadModule(allModules, fileName);
    }

}

//initialize the dynamic module loading
initializeJSDynamicModulesLoading()
    .then(() => {
        //console.log("Modules loaded and initialized.");
    })
    .catch(err => {
        console.error("Error during ts module initialization:", err);
    });