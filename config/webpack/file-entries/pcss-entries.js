// Helper function to generate PCSS entries
function createCssEntry(stylesFileNames, pcssPaths) {
    return {
        /////////general pcss file
        [stylesFileNames.general_style]: pcssPaths.pcss_general + stylesFileNames.general_style.replace("-style", "") + ".pcss", // dht wrapper area CSS entry point

        /////////dashboard page template
        [stylesFileNames.dashboard_page_template_style]:
            pcssPaths.pcss_options_general + stylesFileNames.dashboard_page_template_style.replace("-style", "") + ".pcss", // dht wrapper area CSS entry point

        /////////extensions - options - container - css
        [stylesFileNames.sidemenu_style]: pcssPaths.pcss_options_containers + stylesFileNames.sidemenu_style.replace("-style", "") + ".pcss", // sidemenu container CSS entry point

        /////////extensions - options - groups - css
        [stylesFileNames.group_style]: pcssPaths.pcss_options_groups + stylesFileNames.group_style.replace("-style", "") + ".pcss", // group group CSS entry point
        [stylesFileNames.tabs_style]: pcssPaths.pcss_options_groups + stylesFileNames.tabs_style.replace("-style", "") + ".pcss", // tabs group CSS entry point
        [stylesFileNames.accordion_style]: pcssPaths.pcss_options_groups + stylesFileNames.accordion_style.replace("-style", "") + ".pcss", // accordion group CSS entry point
        [stylesFileNames.addable_box_style]: pcssPaths.pcss_options_groups + stylesFileNames.addable_box_style.replace("-style", "") + ".pcss", // addable box group CSS entry point

        /////////extensions - options - toggles - css
        [stylesFileNames.toggle_style]: pcssPaths.pcss_options_toggles + stylesFileNames.toggle_style.replace("-style", "") + ".pcss", // toggle group CSS entry point

        /////////extensions - options - css
        [stylesFileNames.checkbox_style]: pcssPaths.pcss_options_fields + stylesFileNames.checkbox_style.replace("-style", "") + ".pcss", // Checkbox CSS entry point
        [stylesFileNames.radio_style]: pcssPaths.pcss_options_fields + stylesFileNames.radio_style.replace("-style", "") + ".pcss", // radio CSS entry point
        [stylesFileNames.switch_style]: pcssPaths.pcss_options_fields + stylesFileNames.switch_style.replace("-style", "") + ".pcss", // switch CSS entry point
        [stylesFileNames.multiinput_style]: pcssPaths.pcss_options_fields + stylesFileNames.multiinput_style.replace("-style", "") + ".pcss", // multiinput CSS entry point
        [stylesFileNames.colorpicker_style]: pcssPaths.pcss_options_fields + stylesFileNames.colorpicker_style.replace("-style", "") + ".pcss", // colorpicker CSS entry point
        [stylesFileNames.datepicker_style]: pcssPaths.pcss_options_fields + stylesFileNames.datepicker_style.replace("-style", "") + ".pcss", // datepicker CSS entry point
        [stylesFileNames.timepicker_style]: pcssPaths.pcss_options_fields + stylesFileNames.timepicker_style.replace("-style", "") + ".pcss", // timepicker CSS entry point
        [stylesFileNames.datetimepicker_style]: pcssPaths.pcss_options_fields + stylesFileNames.datetimepicker_style.replace("-style", "") + ".pcss", // datetimepicker CSS entry point
        [stylesFileNames.rangeslider_style]: pcssPaths.pcss_options_fields + stylesFileNames.rangeslider_style.replace("-style", "") + ".pcss", // range slider CSS entry point
        [stylesFileNames.spacing_style]: pcssPaths.pcss_options_fields + stylesFileNames.spacing_style.replace("-style", "") + ".pcss", // spacing CSS entry point
        [stylesFileNames.radio_image_style]: pcssPaths.pcss_options_fields + stylesFileNames.radio_image_style.replace("-style", "") + ".pcss", // radio images CSS entry point
        [stylesFileNames.multi_options_style]: pcssPaths.pcss_options_fields + stylesFileNames.multi_options_style.replace("-style", "") + ".pcss", // multi options CSS entry point
        [stylesFileNames.borders_style]: pcssPaths.pcss_options_fields + stylesFileNames.borders_style.replace("-style", "") + ".pcss", // borders CSS entry point
        [stylesFileNames.upload_image_style]: pcssPaths.pcss_options_fields + stylesFileNames.upload_image_style.replace("-style", "") + ".pcss", // upload image CSS entry point
        [stylesFileNames.upload_style]: pcssPaths.pcss_options_fields + stylesFileNames.upload_style.replace("-style", "") + ".pcss", // upload CSS entry point
        [stylesFileNames.upload_gallery_style]: pcssPaths.pcss_options_fields + stylesFileNames.upload_gallery_style.replace("-style", "") + ".pcss", // upload gallery CSS entry point
        [stylesFileNames.icon_style]: pcssPaths.pcss_options_fields + stylesFileNames.icon_style.replace("-style", "") + ".pcss", // icon CSS entry point
        [stylesFileNames.typography_style]: pcssPaths.pcss_options_fields + stylesFileNames.typography_style.replace("-style", "") + ".pcss", // typography CSS entry point
        [stylesFileNames.wpeditor_style]: pcssPaths.pcss_options_fields + stylesFileNames.wpeditor_style.replace("-style", "") + ".pcss", // wp editor CSS entry point

        /////////extensions - sidebars - css
        [stylesFileNames.create_sidebars_style]: pcssPaths.pcss_extension_sidebars + stylesFileNames.create_sidebars_style.replace("-style", "") + ".pcss", // Sidebars CSS entry point*/
    };
}

module.exports = createCssEntry;
