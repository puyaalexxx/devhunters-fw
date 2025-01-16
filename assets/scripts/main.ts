import { dhtuLoadModule } from "devhunters-utils/utils/dynamic-module-loading";

/**
 * get the current page existent modules from localized script
 * and from the localized script area
 *
 * @return string[]
 */
export function getCurrentPageModules() {
    // @ts-ignore
    const optionsModules = dht_framework_dynamic_modules_info;

    return optionsModules ?? [];
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
    const allModules = import.meta.glob("@ts/modules/**/*.ts");

    //get existent current page modules
    const pageModules = getCurrentPageModules();

    //dynamically load every existent page module
    for (const fileName of pageModules) {
        await dhtuLoadModule(allModules, fileName);
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