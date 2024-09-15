/**
 * Helper function to generate TypeScript file names and their paths
 *
 * @param tsFileNames Typescript files
 * @param folders     Folder were the ts files are located
 *
 * @return object
 */
function getTsEntries(tsFileNames, folders) {
    return {
        /////////modules folder
        [folders.modulesFolder]: [
            tsFileNames.fw,
        ],

        /////////extensions/sidebars - folder
        [folders.sidebarsFolder]: [
            tsFileNames.create_sidebars,
        ],

        /////////extensions/options - folder
        [folders.optionsFolder]: [
            tsFileNames.dashboard_page_template,
        ],

        /////////extensions/options/containers - folder
        [folders.containersFolder]: [
            tsFileNames.sidemenu,
            tsFileNames.tabsmenu,
        ],

        /////////extensions/options/groups - folder
        [folders.groupsFolder]: [
            tsFileNames.tabs,
            tsFileNames.accordion,
            tsFileNames.addable_box,
        ],

        /////////extensions/options/toggles - folder
        [folders.togglesFolder]: [
            tsFileNames.toggle,
        ],

        /////////extensions/options/fields - folder
        [folders.fieldsFolder]: [
            tsFileNames.switch,
            tsFileNames.multiinput,
            tsFileNames.ace_editor,
            tsFileNames.colorpicker,
            tsFileNames.datepicker,
            tsFileNames.timepicker,
            tsFileNames.datetimepicker,
            tsFileNames.rangeslider,
            tsFileNames.radio_image,
            tsFileNames.multi_options,
            tsFileNames.upload_image,
            tsFileNames.upload,
            tsFileNames.upload_gallery,
            tsFileNames.icon,
            tsFileNames.typography,
        ],

    };
}

module.exports = getTsEntries;