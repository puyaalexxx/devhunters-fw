/*
 * compile pcss files in different folders
 * css file locations (where the pcss files are compiled)
 **/
function getCSSFilesLocations(chunkData, cssPaths, stylesFileNames) {
    /////////general css file
    if (chunkData.chunk.name === stylesFileNames.general_style) {
        return cssPaths.css_general + stylesFileNames.general_style + ".css";
    }

    /////////dashboard options template
    if (chunkData.chunk.name === stylesFileNames.dashboard_page_template_style) {
        return cssPaths.css_options_general + stylesFileNames.dashboard_page_template_style + ".css";
    }

    /////////extensions - options - containers - css
    if (chunkData.chunk.name === stylesFileNames.sidemenu_style) {
        return cssPaths.css_options_containers + stylesFileNames.sidemenu_style + ".css";
    } //sidemenu container file

    /////////extensions - options - groups - css
    if (chunkData.chunk.name === stylesFileNames.group_style) {
        return cssPaths.css_options_groups + stylesFileNames.group_style + ".css";
    } //group group file
    if (chunkData.chunk.name === stylesFileNames.tabs_style) {
        return cssPaths.css_options_groups + stylesFileNames.tabs_style + ".css";
    } //tabs group file
    if (chunkData.chunk.name === stylesFileNames.accordion_style) {
        return cssPaths.css_options_groups + stylesFileNames.accordion_style + ".css";
    } //accordion group file
    if (chunkData.chunk.name === stylesFileNames.addable_box_style) {
        return cssPaths.css_options_groups + stylesFileNames.addable_box_style + ".css";
    } //addable box group file

    /////////extensions - options - toggles - css
    if (chunkData.chunk.name === stylesFileNames.toggle_style) {
        return cssPaths.css_options_toggles + stylesFileNames.toggle_style + ".css";
    } //toggle group file

    /////////extensions - options - css
    if (chunkData.chunk.name === stylesFileNames.checkbox_style) {
        return cssPaths.css_options_fields + stylesFileNames.checkbox_style + ".css";
    } //checkbox option file
    if (chunkData.chunk.name === stylesFileNames.radio_style) {
        return cssPaths.css_options_fields + stylesFileNames.radio_style + ".css";
    } //radio option file
    if (chunkData.chunk.name === stylesFileNames.switch_style) {
        return cssPaths.css_options_fields + stylesFileNames.switch_style + ".css";
    } //radio option file
    if (chunkData.chunk.name === stylesFileNames.multiinput_style) {
        return cssPaths.css_options_fields + stylesFileNames.multiinput_style + ".css";
    } //multiinput option file
    if (chunkData.chunk.name === stylesFileNames.colorpicker_style) {
        return cssPaths.css_options_fields + stylesFileNames.colorpicker_style + ".css";
    } //colorpicker option file
    if (chunkData.chunk.name === stylesFileNames.datepicker_style) {
        return cssPaths.css_options_fields + stylesFileNames.datepicker_style + ".css";
    } //datepicker option file
    if (chunkData.chunk.name === stylesFileNames.timepicker_style) {
        return cssPaths.css_options_fields + stylesFileNames.timepicker_style + ".css";
    } //timepicker option file
    if (chunkData.chunk.name === stylesFileNames.datetimepicker_style) {
        return cssPaths.css_options_fields + stylesFileNames.datetimepicker_style + ".css";
    } //datetimepicker option file
    if (chunkData.chunk.name === stylesFileNames.rangeslider_style) {
        return cssPaths.css_options_fields + stylesFileNames.rangeslider_style + ".css";
    } //rangeslider option file
    if (chunkData.chunk.name === stylesFileNames.spacing_style) {
        return cssPaths.css_options_fields + stylesFileNames.spacing_style + ".css";
    } //spacing option file
    if (chunkData.chunk.name === stylesFileNames.radio_image_style) {
        return cssPaths.css_options_fields + stylesFileNames.radio_image_style + ".css";
    } //radio images option file
    if (chunkData.chunk.name === stylesFileNames.multi_options_style) {
        return cssPaths.css_options_fields + stylesFileNames.multi_options_style + ".css";
    } //multi options option file
    if (chunkData.chunk.name === stylesFileNames.borders_style) {
        return cssPaths.css_options_fields + stylesFileNames.borders_style + ".css";
    } //border option file
    if (chunkData.chunk.name === stylesFileNames.upload_image_style) {
        return cssPaths.css_options_fields + stylesFileNames.upload_image_style + ".css";
    } //upload image option file
    if (chunkData.chunk.name === stylesFileNames.upload_style) {
        return cssPaths.css_options_fields + stylesFileNames.upload_style + ".css";
    } //upload option file
    if (chunkData.chunk.name === stylesFileNames.upload_gallery_style) {
        return cssPaths.css_options_fields + stylesFileNames.upload_gallery_style + ".css";
    } //upload gallery option file
    if (chunkData.chunk.name === stylesFileNames.icon_style) {
        return cssPaths.css_options_fields + stylesFileNames.icon_style + ".css";
    } //icon option file
    if (chunkData.chunk.name === stylesFileNames.typography_style) {
        return cssPaths.css_options_fields + stylesFileNames.typography_style + ".css";
    } //typography option file
    if (chunkData.chunk.name === stylesFileNames.wpeditor_style) {
        return cssPaths.css_options_fields + stylesFileNames.wpeditor_style + ".css";
    } //wp editor option file

    /////////extensions - sidebars - css
    if (chunkData.chunk.name === stylesFileNames.create_sidebars_style) {
        return cssPaths.css_extension_sidebars + stylesFileNames.create_sidebars_style + ".css";
    }

    // For other entry points, output to root 'css' folder
    return cssPaths.css_general + "[name].css";
}

module.exports = getCSSFilesLocations;
