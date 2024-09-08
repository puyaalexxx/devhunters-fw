/*
 * compile ts files in different folders
 * js file locations (where the ts files are compiled)
 **/
function getJSFilesLocations(chunkData, jsPaths, scriptsFileNames) {
    /////////general js file
    if (chunkData.chunk.name === scriptsFileNames.general_script) {
        return jsPaths.js_general + scriptsFileNames.general_script + ".js";
    }

    /////////dashboard page template
    if (chunkData.chunk.name === scriptsFileNames.dashboard_page_template_script) {
        return jsPaths.js_options_general + scriptsFileNames.dashboard_page_template_script + ".js";
    }

    /////////extensions - options - containers - js
    if (chunkData.chunk.name === scriptsFileNames.sidemenu_script) {
        return jsPaths.js_options_containers + scriptsFileNames.sidemenu_script + ".js";
    } //sidemenu container
    if (chunkData.chunk.name === scriptsFileNames.tabsmenu_script) {
        return jsPaths.js_options_containers + scriptsFileNames.tabsmenu_script + ".js";
    } //tabsmenu container

    /////////extensions - options - groups - js
    if (chunkData.chunk.name === scriptsFileNames.tabs_script) {
        return jsPaths.js_options_groups + scriptsFileNames.tabs_script + ".js";
    } //tabs
    if (chunkData.chunk.name === scriptsFileNames.accordion_script) {
        return jsPaths.js_options_groups + scriptsFileNames.accordion_script + ".js";
    } //accordion
    if (chunkData.chunk.name === scriptsFileNames.addable_box_script) {
        return jsPaths.js_options_groups + scriptsFileNames.addable_box_script + ".js";
    } //addable box

    /////////extensions - options - groups - js
    if (chunkData.chunk.name === scriptsFileNames.toggle_script) {
        return jsPaths.js_options_toggles + scriptsFileNames.toggle_script + ".js";
    } //toggle

    /////////extensions - options - js
    if (chunkData.chunk.name === scriptsFileNames.switch_script) {
        return jsPaths.js_options_fields + scriptsFileNames.switch_script + ".js";
    } //switch option file
    if (chunkData.chunk.name === scriptsFileNames.multiinput_script) {
        return jsPaths.js_options_fields + scriptsFileNames.multiinput_script + ".js";
    } //multiinput option file
    if (chunkData.chunk.name === scriptsFileNames.ace_editor_script) {
        return jsPaths.js_options_fields + scriptsFileNames.ace_editor_script + ".js";
    } //ace editor option file
    if (chunkData.chunk.name === scriptsFileNames.colorpicker_script) {
        return jsPaths.js_options_fields + scriptsFileNames.colorpicker_script + ".js";
    } //colorpicker option file
    if (chunkData.chunk.name === scriptsFileNames.datepicker_script) {
        return jsPaths.js_options_fields + scriptsFileNames.datepicker_script + ".js";
    } //datepicker option file
    if (chunkData.chunk.name === scriptsFileNames.timepicker_script) {
        return jsPaths.js_options_fields + scriptsFileNames.timepicker_script + ".js";
    } //timepicker option file
    if (chunkData.chunk.name === scriptsFileNames.datetimepicker_script) {
        return jsPaths.js_options_fields + scriptsFileNames.datetimepicker_script + ".js";
    } //datetimepicker option file
    if (chunkData.chunk.name === scriptsFileNames.rangeslider_script) {
        return jsPaths.js_options_fields + scriptsFileNames.rangeslider_script + ".js";
    } //rangeslider option file
    if (chunkData.chunk.name === scriptsFileNames.radio_image_script) {
        return jsPaths.js_options_fields + scriptsFileNames.radio_image_script + ".js";
    } // radio image
    if (chunkData.chunk.name === scriptsFileNames.multi_options_script) {
        return jsPaths.js_options_fields + scriptsFileNames.multi_options_script + ".js";
    } //multioptions option file
    if (chunkData.chunk.name === scriptsFileNames.upload_image_script) {
        return jsPaths.js_options_fields + scriptsFileNames.upload_image_script + ".js";
    } //upload image option file
    if (chunkData.chunk.name === scriptsFileNames.upload_script) {
        return jsPaths.js_options_fields + scriptsFileNames.upload_script + ".js";
    } //upload option file
    if (chunkData.chunk.name === scriptsFileNames.upload_gallery_script) {
        return jsPaths.js_options_fields + scriptsFileNames.upload_gallery_script + ".js";
    } //upload gallery option file
    if (chunkData.chunk.name === scriptsFileNames.icon_script) {
        return jsPaths.js_options_fields + scriptsFileNames.icon_script + ".js";
    } //icon option file
    if (chunkData.chunk.name === scriptsFileNames.typography_script) {
        return jsPaths.js_options_fields + scriptsFileNames.typography_script + ".js";
    } //typography

    /////////extensions - sidebars - js
    if (chunkData.chunk.name === scriptsFileNames.create_sidebars_script) {
        return jsPaths.js_extension_sidebars + scriptsFileNames.create_sidebars_script + ".js";
    }

    // output to the js folder
    return jsPaths.js_general + "[name].js";
}

module.exports = getJSFilesLocations;
