// Helper function to generate TypeScript entries
function createTsEntry(scriptsFileNames, tsPaths) {
    return {
        // TypeScript files entries

        /////////general ts file
        [scriptsFileNames.general_script]: tsPaths.ts_general + scriptsFileNames.general_script.replace("-script", "") + ".ts",

        /////////dashboard page template
        [scriptsFileNames.dashboard_page_template_script]:
            tsPaths.ts_options_general + scriptsFileNames.dashboard_page_template_script.replace("-script", "") + ".ts",

        /////////extensions - options - containers - ts
        [scriptsFileNames.sidemenu_script]: tsPaths.ts_options_containers + scriptsFileNames.sidemenu_script.replace("-script", "") + ".ts",

        /////////extensions - options - groups - ts
        [scriptsFileNames.tabs_script]: tsPaths.ts_options_groups + scriptsFileNames.tabs_script.replace("-script", "") + ".ts",
        [scriptsFileNames.accordion_script]: tsPaths.ts_options_groups + scriptsFileNames.accordion_script.replace("-script", "") + ".ts",
        [scriptsFileNames.addable_box_script]: tsPaths.ts_options_groups + scriptsFileNames.addable_box_script.replace("-script", "") + ".ts",

        /////////extensions - options - toggles - ts
        [scriptsFileNames.toggle_script]: tsPaths.ts_options_toggles + scriptsFileNames.toggle_script.replace("-script", "") + ".ts",

        /////////extensions - options - ts
        [scriptsFileNames.switch_script]: tsPaths.ts_options_fields + scriptsFileNames.switch_script.replace("-script", "") + ".ts",
        [scriptsFileNames.multiinput_script]: tsPaths.ts_options_fields + scriptsFileNames.multiinput_script.replace("-script", "") + ".ts",
        [scriptsFileNames.ace_editor_script]: tsPaths.ts_options_fields + scriptsFileNames.ace_editor_script.replace("-script", "") + ".ts",
        [scriptsFileNames.colorpicker_script]: tsPaths.ts_options_fields + scriptsFileNames.colorpicker_script.replace("-script", "") + ".ts",
        [scriptsFileNames.datepicker_script]: tsPaths.ts_options_fields + scriptsFileNames.datepicker_script.replace("-script", "") + ".ts",
        [scriptsFileNames.timepicker_script]: tsPaths.ts_options_fields + scriptsFileNames.timepicker_script.replace("-script", "") + ".ts",
        [scriptsFileNames.datetimepicker_script]: tsPaths.ts_options_fields + scriptsFileNames.datetimepicker_script.replace("-script", "") + ".ts",
        [scriptsFileNames.rangeslider_script]: tsPaths.ts_options_fields + scriptsFileNames.rangeslider_script.replace("-script", "") + ".ts",
        [scriptsFileNames.radio_image_script]: tsPaths.ts_options_fields + scriptsFileNames.radio_image_script.replace("-script", "") + ".ts",
        [scriptsFileNames.multi_options_script]: tsPaths.ts_options_fields + scriptsFileNames.multi_options_script.replace("-script", "") + ".ts",
        [scriptsFileNames.upload_image_script]: tsPaths.ts_options_fields + scriptsFileNames.upload_image_script.replace("-script", "") + ".ts",
        [scriptsFileNames.upload_script]: tsPaths.ts_options_fields + scriptsFileNames.upload_script.replace("-script", "") + ".ts",
        [scriptsFileNames.upload_gallery_script]: tsPaths.ts_options_fields + scriptsFileNames.upload_gallery_script.replace("-script", "") + ".ts",
        [scriptsFileNames.icon_script]: tsPaths.ts_options_fields + scriptsFileNames.icon_script.replace("-script", "") + ".ts",
        [scriptsFileNames.typography_script]: tsPaths.ts_options_fields + scriptsFileNames.typography_script.replace("-script", "") + ".ts",
    };
}

module.exports = createTsEntry;
