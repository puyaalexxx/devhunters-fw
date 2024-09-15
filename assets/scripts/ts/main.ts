import getTsEntries from "../../../config/webpack/file-entries/ts-entries";
import tsFileNames from "../../../config/webpack/file-names/ts-file-names";
import folders from "../../../config/webpack/file-names/ts-pcss-folders";
import jQuery from "jquery";

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

    //load the general framework file. It should be loaded always
    await import(/* webpackChunkName: "[request]" */ "./modules/fw");

    // Helper function to load modules dynamically
    const loadModule = async (fileName: string, filePath: string) => {
        try {
            await import(/* webpackChunkName: "[request]" */ `./modules/${filePath}${fileName}`);
        } catch (err) {
            console.error(`Error loading ${fileName} module:`, err);
        }
    };
    // Main wrapper area where all elements are placed
    const $wrapperArea = jQuery(".dht-wrapper");

    // Define key-element mappings for conditional module loading
    const moduleConditions: ModuleConditions = {
        [tsFileNames.create_sidebars]: jQuery("#widgets-right"),
        [tsFileNames.dashboard_page_template]: $wrapperArea,
        [tsFileNames.sidemenu]: jQuery("#dht-cosidebar"), //change to class at the end
        [tsFileNames.tabsmenu]: jQuery(".dht-tabsmenu-container"),
        [tsFileNames.tabs]: jQuery(".dht-field-child-wrapper.dht-field-child-tabs"),
        [tsFileNames.accordion]: jQuery(".dht-field-child-wrapper.dht-field-child-accordion"),
        [tsFileNames.addable_box]: jQuery(".dht-field-child-wrapper.dht-field-child-addable-box"),
        [tsFileNames.toggle]: jQuery(".dht-field-child-wrapper.dht-field-child-toggle"),
        [tsFileNames.switch]: jQuery(".dht-field-child-wrapper.dht-field-child-switch"),
        [tsFileNames.multiinput]: jQuery(".dht-field-child-wrapper.dht-field-child-multiinput"),
        [tsFileNames.ace_editor]: jQuery(".dht-field-child-wrapper.dht-field-child-code-editor"),
        [tsFileNames.colorpicker]: jQuery(".dht-field-child-wrapper.dht-field-child-colorpicker"),
        [tsFileNames.datepicker]: jQuery(".dht-field-child-wrapper.dht-field-child-datepicker .dht-datepicker"),
        [tsFileNames.timepicker]: jQuery(".dht-field-child-wrapper.dht-field-child-timepicker .dht-timepicker"),
        [tsFileNames.datetimepicker]: jQuery(".dht-field-child-wrapper.dht-field-child-datetimepicker .dht-datetimepicker"),
        [tsFileNames.rangeslider]: jQuery(".dht-field-child-wrapper.dht-field-child-rangeslider"),
        [tsFileNames.radio_image]: jQuery(".dht-field-child-wrapper.dht-field-child-image-select"),
        [tsFileNames.multi_options]: jQuery(".dht-field-child-wrapper.dht-field-child-multioptions"),
        [tsFileNames.upload_image]: jQuery(".dht-field-child-wrapper.dht-field-child-upload-image"),
        [tsFileNames.upload]: jQuery(".dht-field-child-wrapper.dht-field-child-upload-item"),
        [tsFileNames.upload_gallery]: jQuery(".dht-field-child-wrapper.dht-field-child-upload-gallery"),
        [tsFileNames.icon]: jQuery(".dht-field-child-wrapper.dht-field-child-icons"),
        [tsFileNames.typography]: jQuery(".dht-field-child-wrapper.dht-field-child-typography"),
    };

    // Use a for...of loop to handle asynchronous module loading
    for (const [filesPath, files] of Object.entries(getTsEntries(tsFileNames, folders))) {
        //get each ts file
        for (const file of files) {
            //check if file should be loaded
            const element = moduleConditions[file];

            // If the jQuery object exists and has elements, load the module
            if (element && element.length) {
                await loadModule(file, filesPath);
            }
        }
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