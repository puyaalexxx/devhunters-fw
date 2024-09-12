// Helper function to generate PCSS entries
function createCssEntry(stylesFileNames, pcssPaths) {
    return {
        /////////fw pcss file
        [stylesFileNames.fw]: pcssPaths.pcss_general + stylesFileNames.fw + ".pcss", // dht wrapper area CSS entry point

        /////////dashboard page template
        [stylesFileNames.dashboard_page_template]:
        pcssPaths.pcss_options_general + stylesFileNames.dashboard_page_template + ".pcss", // dht wrapper area CSS entry point

        /////////extensions - options - container - css
        [stylesFileNames.sidemenu]: pcssPaths.pcss_options_containers + stylesFileNames.sidemenu + ".pcss", // sidemenu container CSS entry point
        [stylesFileNames.tabsmenu]: pcssPaths.pcss_options_containers + stylesFileNames.tabsmenu + ".pcss", // tabsmenu container CSS entry point

        /////////extensions - options - groups - css
        [stylesFileNames.group]: pcssPaths.pcss_options_groups + stylesFileNames.group + ".pcss", // group group CSS entry point
        [stylesFileNames.tabs]: pcssPaths.pcss_options_groups + stylesFileNames.tabs + ".pcss", // tabs group CSS entry point
        [stylesFileNames.accordionStyle]: pcssPaths.pcss_options_groups + stylesFileNames.accordionStyle + ".pcss", // accordion group CSS entry point
        [stylesFileNames.addable_box]: pcssPaths.pcss_options_groups + stylesFileNames.addable_box + ".pcss", // addable box group CSS entry point

        /////////extensions - options - toggles - css
        [stylesFileNames.toggle]: pcssPaths.pcss_options_toggles + stylesFileNames.toggle + ".pcss", // toggle group CSS entry point

        /////////extensions - options - css
        [stylesFileNames.checkbox]: pcssPaths.pcss_options_fields + stylesFileNames.checkbox + ".pcss", // Checkbox CSS entry point
        [stylesFileNames.radio]: pcssPaths.pcss_options_fields + stylesFileNames.radio + ".pcss", // radio CSS entry point
        [stylesFileNames.switchStyle]: pcssPaths.pcss_options_fields + stylesFileNames.switchStyle + ".pcss", // switch CSS entry point
        [stylesFileNames.multiinput]: pcssPaths.pcss_options_fields + stylesFileNames.multiinput + ".pcss", // multiinput CSS entry point
        [stylesFileNames.colorpicker]: pcssPaths.pcss_options_fields + stylesFileNames.colorpicker + ".pcss", // colorpicker CSS entry point
        [stylesFileNames.datepicker]: pcssPaths.pcss_options_fields + stylesFileNames.datepicker + ".pcss", // datepicker CSS entry point
        [stylesFileNames.timepickerStyle]: pcssPaths.pcss_options_fields + stylesFileNames.timepickerStyle + ".pcss", // timepicker CSS entry point
        [stylesFileNames.datetimepickerStyle]: pcssPaths.pcss_options_fields + stylesFileNames.datetimepickerStyle + ".pcss", // datetimepicker CSS entry point
        [stylesFileNames.rangeslider]: pcssPaths.pcss_options_fields + stylesFileNames.rangeslider + ".pcss", // range slider CSS entry point
        [stylesFileNames.spacing]: pcssPaths.pcss_options_fields + stylesFileNames.spacing + ".pcss", // spacing CSS entry point
        [stylesFileNames.radio_image]: pcssPaths.pcss_options_fields + stylesFileNames.radio_image + ".pcss", // radio images CSS entry point
        [stylesFileNames.multi_options]: pcssPaths.pcss_options_fields + stylesFileNames.multi_options + ".pcss", // multi options CSS entry point
        [stylesFileNames.borders]: pcssPaths.pcss_options_fields + stylesFileNames.borders + ".pcss", // borders CSS entry point
        [stylesFileNames.upload_image]: pcssPaths.pcss_options_fields + stylesFileNames.upload_image + ".pcss", // upload image CSS entry point
        [stylesFileNames.upload]: pcssPaths.pcss_options_fields + stylesFileNames.upload + ".pcss", // upload CSS entry point
        [stylesFileNames.upload_gallery]: pcssPaths.pcss_options_fields + stylesFileNames.upload_gallery + ".pcss", // upload gallery CSS entry point
        [stylesFileNames.icon]: pcssPaths.pcss_options_fields + stylesFileNames.icon + ".pcss", // icon CSS entry point
        [stylesFileNames.typography]: pcssPaths.pcss_options_fields + stylesFileNames.typography + ".pcss", // typography CSS entry point
        [stylesFileNames.wpeditorStyle]: pcssPaths.pcss_options_fields + stylesFileNames.wpeditorStyle + ".pcss", // wp editor CSS entry point

        /////////extensions - sidebars - css
        [stylesFileNames.create_sidebars]: pcssPaths.pcss_extension_sidebars + stylesFileNames.create_sidebars + ".pcss", // Sidebars CSS entry point*/
    };
}

module.exports = createCssEntry;
