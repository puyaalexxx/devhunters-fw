// Helper function to generate TypeScript entries
function createTsEntry(scriptsFileNames, tsPaths) {
    return {
        // TypeScript files entries

        /////////fw ts file
        [scriptsFileNames.fw]: tsPaths.ts_general + scriptsFileNames.fw.replace("-js", "") + ".ts",

        /////////dashboard page template
        [scriptsFileNames.dashboard_page_template]:
        tsPaths.ts_options_general + scriptsFileNames.dashboard_page_template.replace("-js", "") + ".ts",

        /////////extensions - options - containers - ts
        [scriptsFileNames.sidemenu]: tsPaths.ts_options_containers + scriptsFileNames.sidemenu.replace("-js", "") + ".ts",
        [scriptsFileNames.tabsmenu]: tsPaths.ts_options_containers + scriptsFileNames.tabsmenu.replace("-js", "") + ".ts",

        /////////extensions - options - groups - ts
        [scriptsFileNames.tabs]: tsPaths.ts_options_groups + scriptsFileNames.tabs.replace("-js", "") + ".ts",
        [scriptsFileNames.accordionScript]: tsPaths.ts_options_groups + scriptsFileNames.accordionScript.replace("-js", "") + ".ts",
        [scriptsFileNames.addable_box]: tsPaths.ts_options_groups + scriptsFileNames.addable_box.replace("-js", "") + ".ts",

        /////////extensions - options - toggles - ts
        [scriptsFileNames.toggle]: tsPaths.ts_options_toggles + scriptsFileNames.toggle.replace("-js", "") + ".ts",

        /////////extensions - options - ts
        [scriptsFileNames.switch]: tsPaths.ts_options_fields + scriptsFileNames.switch.replace("-js", "") + ".ts",
        [scriptsFileNames.multiinput]: tsPaths.ts_options_fields + scriptsFileNames.multiinput.replace("-js", "") + ".ts",
        [scriptsFileNames.ace_editor]: tsPaths.ts_options_fields + scriptsFileNames.ace_editor.replace("-js", "") + ".ts",
        [scriptsFileNames.colorpicker]: tsPaths.ts_options_fields + scriptsFileNames.colorpicker.replace("-js", "") + ".ts",
        [scriptsFileNames.datepicker]: tsPaths.ts_options_fields + scriptsFileNames.datepicker.replace("-js", "") + ".ts",
        [scriptsFileNames.timepickerScript]: tsPaths.ts_options_fields + scriptsFileNames.timepickerScript.replace("-js", "") + ".ts",
        [scriptsFileNames.datetimepickerScript]: tsPaths.ts_options_fields + scriptsFileNames.datetimepickerScript.replace("-js", "") + ".ts",
        [scriptsFileNames.rangeslider]: tsPaths.ts_options_fields + scriptsFileNames.rangeslider.replace("-js", "") + ".ts",
        [scriptsFileNames.radio_image]: tsPaths.ts_options_fields + scriptsFileNames.radio_image.replace("-js", "") + ".ts",
        [scriptsFileNames.multi_options]: tsPaths.ts_options_fields + scriptsFileNames.multi_options.replace("-js", "") + ".ts",
        [scriptsFileNames.upload_image]: tsPaths.ts_options_fields + scriptsFileNames.upload_image.replace("-js", "") + ".ts",
        [scriptsFileNames.upload]: tsPaths.ts_options_fields + scriptsFileNames.upload.replace("-js", "") + ".ts",
        [scriptsFileNames.upload_gallery]: tsPaths.ts_options_fields + scriptsFileNames.upload_gallery.replace("-js", "") + ".ts",
        [scriptsFileNames.icon]: tsPaths.ts_options_fields + scriptsFileNames.icon.replace("-js", "") + ".ts",
        [scriptsFileNames.typography]: tsPaths.ts_options_fields + scriptsFileNames.typography.replace("-js", "") + ".ts",
    };
}

module.exports = createTsEntry;