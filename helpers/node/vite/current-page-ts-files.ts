import { dhtuGetTsFileNamesFromPaths } from "devhunters-utils/utils/ts-file-names";

/**
 * Get the current page existent modules by its classes
 *
 * @return object
 */
export function getCurrentPageModules(allModules: Record<string, () => Promise<unknown>>) {

    // get all ts file names as an object with key-value pairs
    const tsFileNames = dhtuGetTsFileNamesFromPaths(allModules);

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

        //options - groups
        $(".dht-field-wrapper-accordion").length ? tsFileNames.accordion : "",
        $(".dht-field-wrapper-panel").length ? tsFileNames.panel : "",
        $(".dht-field-wrapper-addable-box").length ? tsFileNames.addable_box : "",
        $(".dht-field-wrapper-tabs").length ? tsFileNames.tabs : "",

        //options - toggles
        $(".dht-field-wrapper-toggle").length ? tsFileNames.toggle : "",

        //options - fields
        $(".dht-field-wrapper-input").length ? tsFileNames.input : "",
        $(".dht-field-wrapper-textarea").length ? tsFileNames.textarea : "",
        $(".dht-field-wrapper-dropdown").length ? tsFileNames.dropdown : "",
        $(".dht-field-wrapper-editor").length ? tsFileNames.wpeditor : "",
        $(".dht-field-wrapper-switch").length ? tsFileNames.switch : "",
        $(".dht-field-wrapper-multiinput").length ? tsFileNames.multiinput : "",
        $(".dht-field-wrapper-code-editor").length ? tsFileNames.ace_editor : "",
        $(".dht-field-wrapper-borders").length ? tsFileNames.borders : "",
        $(".dht-field-wrapper-colorpicker").length ? tsFileNames.colorpicker : "",
        $(".dht-field-wrapper-image-select").length ? tsFileNames.radio_image : "",
        $(".dht-field-wrapper-icons").length ? tsFileNames.icon : "",
        $(".dht-field-wrapper-datepicker .dht-datepicker").length ? tsFileNames.datepicker : "",
        $(".dht-field-wrapper-timepicker .dht-timepicker").length ? tsFileNames.timepicker : "",
        $(".dht-field-wrapper-datetimepicker .dht-datetimepicker").length ? tsFileNames.datetimepicker : "",
        $(".dht-field-wrapper-rangeslider").length ? tsFileNames.rangeslider : "",
        $(".dht-field-wrapper-multioptions").length ? tsFileNames.multi_options : "",
        $(".dht-field-wrapper-upload-image").length ? tsFileNames.upload_image : "",
        $(".dht-field-wrapper-upload-item").length ? tsFileNames.upload : "",
        $(".dht-field-wrapper-upload-gallery").length ? tsFileNames.upload_gallery : "",
        $(".dht-field-wrapper-typography").length ? tsFileNames.typography : "",
    ].filter((fileName) => fileName !== "");
}
