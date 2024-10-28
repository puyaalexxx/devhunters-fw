import { dhtuGetTsFileNamesFromPaths } from "devhunters-utils/utils/ts-file-names";

/**
 * Get the current page existent modules by its classes
 *
 * @return object
 */
export function getCurrentPageModules(allModules: Record<string, () => Promise<unknown>>) {

    // get all ts file names as an object with key-value pairs
    const tsFileNames = dhtuGetTsFileNamesFromPaths(allModules);

    console.log(tsFileNames);

    // get existent page modules
    return [
        //general files that should always be loaded
        "fw",

        //core - vb
        $(".dht-vb-enabled").length ? tsFileNames.vb : "",

        //sidebars
        $("#widgets-right").length ? tsFileNames.create_sidebars : "",

        //options
        $(".dht-wrapper").length ? tsFileNames.dashboard_page : "",

        //options - containers
        $(".dht-cosidebar").length ? tsFileNames.sidemenu : "", //change to class at the end
        $(".dht-tabsmenu-container").length ? tsFileNames.tabsmenu : "",
        $(".dht-field-child-wrapper.dht-field-child-tabs").length ? tsFileNames.tabs : "",

        //options - groups
        $(".dht-field-child-wrapper.dht-field-child-accordion").length ? tsFileNames.accordion : "",
        $(".dht-field-child-wrapper.dht-field-child-panel").length ? tsFileNames.panel : "",
        $(".dht-field-child-wrapper.dht-field-child-addable-box").length ? tsFileNames.addable_box : "",

        //options - toggles
        $(".dht-field-child-wrapper.dht-field-child-toggle").length ? tsFileNames.toggle : "",

        //options - fields
        $(".dht-field-wrapper-input").length ? tsFileNames.input : "",
        $(".dht-field-wrapper-textarea").length ? tsFileNames.textarea : "",
        $(".dht-field-wrapper-editor").length ? tsFileNames.wpeditor : "",
        $(".dht-field-child-wrapper.dht-field-child-switch").length ? tsFileNames.switch : "",
        $(".dht-field-child-wrapper.dht-field-child-multiinput").length ? tsFileNames.multiinput : "",
        $(".dht-field-child-wrapper.dht-field-child-code-editor").length ? tsFileNames.ace_editor : "",
        $(".dht-field-child-wrapper.dht-field-child-borders").length ? tsFileNames.borders : "",
        $(".dht-field-child-wrapper.dht-field-child-colorpicker").length ? tsFileNames.colorpicker : "",
        $(".dht-field-child-wrapper.dht-field-child-image-select").length ? tsFileNames.radio_image : "",
        $(".dht-field-child-wrapper.dht-field-child-icons").length ? tsFileNames.icon : "",
        $(".dht-field-child-wrapper.dht-field-child-datepicker .dht-datepicker").length ? tsFileNames.datepicker : "",
        $(".dht-field-child-wrapper.dht-field-child-timepicker .dht-timepicker").length ? tsFileNames.timepicker : "",
        $(".dht-field-child-wrapper.dht-field-child-datetimepicker .dht-datetimepicker").length ? tsFileNames.datetimepicker : "",
        $(".dht-field-child-wrapper.dht-field-child-rangeslider").length ? tsFileNames.rangeslider : "",
        $(".dht-field-child-wrapper.dht-field-child-multioptions").length ? tsFileNames.multi_options : "",
        $(".dht-field-child-wrapper.dht-field-child-upload-image").length ? tsFileNames.upload_image : "",
        $(".dht-field-child-wrapper.dht-field-child-upload-item").length ? tsFileNames.upload : "",
        $(".dht-field-child-wrapper.dht-field-child-upload-gallery").length ? tsFileNames.upload_gallery : "",
        $(".dht-field-child-wrapper.dht-field-child-typography").length ? tsFileNames.typography : "",
    ].filter((fileName) => fileName !== "");
}
