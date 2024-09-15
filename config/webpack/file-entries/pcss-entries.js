/**
 * Helper function to generate Pcss file names and their paths
 *
 * @param pcssFileNames Pcss files
 * @param folders       Folder were the ts files are located
 *
 * @return object
 */
function getPcssEntries(pcssFileNames, folders) {
    return {
        /////////features folder
        [folders.modulesFolder]: [
            pcssFileNames.fw,
        ],

        /////////extensions/sidebars - folder
        [folders.sidebarsFolder]: [
            pcssFileNames.create_sidebars,
        ],

        /////////extensions/options - folder
        [folders.optionsFolder]: [
            pcssFileNames.dashboard_page_template,
        ],

        /////////extensions/options/containers - folder
        [folders.containersFolder]: [
            pcssFileNames.sidemenu,
            pcssFileNames.tabsmenu,
        ],

        /////////extensions/options/groups - folder
        [folders.groupsFolder]: [
            pcssFileNames.group,
            pcssFileNames.tabs,
            pcssFileNames.accordion,
            pcssFileNames.addable_box,
        ],

        /////////extensions/options/toggles - folder
        [folders.togglesFolder]: [
            pcssFileNames.toggle,
        ],

        /////////extensions/options/fields - folder
        [folders.fieldsFolder]: [
            pcssFileNames.checkbox,
            pcssFileNames.radio,
            pcssFileNames.borders,
            pcssFileNames.spacing,
            pcssFileNames.switch,
            pcssFileNames.multiinput,
            pcssFileNames.colorpicker,
            pcssFileNames.datepicker,
            pcssFileNames.timepicker,
            pcssFileNames.datetimepicker,
            pcssFileNames.rangeslider,
            pcssFileNames.radio_image,
            pcssFileNames.multi_options,
            pcssFileNames.upload_image,
            pcssFileNames.upload,
            pcssFileNames.upload_gallery,
            pcssFileNames.icon,
            pcssFileNames.typography,
            pcssFileNames.wpeditor,
        ],
    };
}

module.exports = getPcssEntries;
