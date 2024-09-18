/**
 * Helper function to get the current page existent modules by its classes
 *
 * @return object
 */
function getPageModules() {

    //ts file names
    const tsFileNames = {
        // Modules - folder
        fw: "fw", //key name : ts file name

        // Extensions/sidebars - folder
        create_sidebars: "create-sidebars", //key name : ts file name

        // Extensions/options - folder
        dashboard_page_template: "dashboard-page-template", //key name : ts file name

        // Extensions/options/containers - folder
        sidemenu: "sidemenu", //key name : ts file name
        tabsmenu: "tabsmenu", //key name : ts file name

        // Extensions/options/groups - folder
        tabs: "tabs", //key name : ts file name
        accordion: "accordion", //key name : ts file name
        addable_box: "addable-box", //key name : ts file name

        // Extensions/options/toggles - folder
        toggle: "toggle", //key name : ts file name

        // Extensions/options/fields - folder
        switch: "switch", //key name : ts file name
        multiinput: "multiinput", //key name : ts file name
        ace_editor: "ace-editor", //key name : ts file name
        colorpicker: "colorpicker", //key name : ts file name
        datepicker: "datepicker", //key name : ts file name
        timepicker: "timepicker", //key name : ts file name
        datetimepicker: "datetimepicker", //key name : ts file name
        rangeslider: "rangeslider", //key name : ts file name
        radio_image: "radio-image", //key name : ts file name
        multi_options: "multi-options", //key name : ts file name
        upload_image: "upload-image", //key name : ts file name
        upload: "upload", //key name : ts file name
        upload_gallery: "upload-gallery", //key name : ts file name
        icon: "icon", //key name : ts file name
        typography: "typography", //key name : ts file name
    };


    // get existent page modules
    return [
        $("#widgets-right").length ? tsFileNames.create_sidebars : "",
        $(".dht-wrapper").length ? tsFileNames.dashboard_page_template : "",
        $("#dht-cosidebar").length ? tsFileNames.sidemenu : "", //change to class at the end
        $(".dht-tabsmenu-container").length ? tsFileNames.tabsmenu : "",
        $(".dht-field-child-wrapper.dht-field-child-tabs").length ? tsFileNames.tabs : "",
        $(".dht-field-child-wrapper.dht-field-child-accordion").length ? tsFileNames.accordion : "",
        $(".dht-field-child-wrapper.dht-field-child-addable-box").length ? tsFileNames.addable_box : "",
        $(".dht-field-child-wrapper.dht-field-child-toggle").length ? tsFileNames.toggle : "",
        $(".dht-field-child-wrapper.dht-field-child-switch").length ? tsFileNames.switch : "",
        $(".dht-field-child-wrapper.dht-field-child-multiinput").length ? tsFileNames.multiinput : "",
        $(".dht-field-child-wrapper.dht-field-child-code-editor").length ? tsFileNames.ace_editor : "",
        // $(".dht-field-child-wrapper.dht-field-child-borders").length ? tsFileNames.borders : "",
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
    ];

    /* return {
         [tsFileNames.create_sidebars]: $("#widgets-right").length,
         [tsFileNames.dashboard_page_template]: $(".dht-wrapper").length,
         [tsFileNames.sidemenu]: $("#dht-cosidebar").length, //change to class at the end
         [tsFileNames.tabsmenu]: $(".dht-tabsmenu-container").length,
         [tsFileNames.tabs]: $(".dht-field-child-wrapper.dht-field-child-tabs").length,
         [tsFileNames.accordion]: $(".dht-field-child-wrapper.dht-field-child-accordion").length,
         [tsFileNames.addable_box]: $(".dht-field-child-wrapper.dht-field-child-addable-box").length,
         [tsFileNames.toggle]: $(".dht-field-child-wrapper.dht-field-child-toggle").length,
         //[tsFileNames.switch]: $(".dht-field-child-wrapper.dht-field-child-switch").length,
         //[tsFileNames.multiinput]: $(".dht-field-child-wrapper.dht-field-child-multiinput").length,
         //[tsFileNames.ace_editor]: $(".dht-field-child-wrapper.dht-field-child-code-editor").length,
         //[tsFileNames.borders]: $(".dht-field-child-wrapper.dht-field-child-borders").length,
         //[tsFileNames.colorpicker]: colorpicker,
         [tsFileNames.radio_image]: $(".dht-field-child-wrapper.dht-field-child-image-select").length,
         //[tsFileNames.icon]: $(".dht-field-child-wrapper.dht-field-child-icons").length,
         //[tsFileNames.datepicker]: $(".dht-field-child-wrapper.dht-field-child-datepicker .dht-datepicker").length,
         //[tsFileNames.timepicker]: $(".dht-field-child-wrapper.dht-field-child-timepicker .dht-timepicker").length,
         //[tsFileNames.datetimepicker]: $(".dht-field-child-wrapper.dht-field-child-datetimepicker .dht-datetimepicker").length,
         [tsFileNames.rangeslider]: "",
         //[tsFileNames.multi_options]: $(".dht-field-child-wrapper.dht-field-child-multioptions").length,
         /// [tsFileNames.upload_image]: $(".dht-field-child-wrapper.dht-field-child-upload-image").length,
         // [tsFileNames.upload]: $(".dht-field-child-wrapper.dht-field-child-upload-item").length,
         // [tsFileNames.upload_gallery]: $(".dht-field-child-wrapper.dht-field-child-upload-gallery").length,
         // [tsFileNames.typography]: $(".dht-field-child-wrapper.dht-field-child-typography").length,
     };
 */

}

export default getTsEntries;
//module.exports = getTsEntries;