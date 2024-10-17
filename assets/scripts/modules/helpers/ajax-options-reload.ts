"use strict";

/**
 * reinitialize options loaded via ajax
 *
 * @return void
 */
export function dhtReinitializeOptions($content: JQuery<HTMLElement>) {
    // Trigger custom ajax events based on the presence of specific elements
    {
        //if toggle option exists in the current content, reload its js code
        if ($content.find(".dht-field-child-toggle").length) {
            $(document).trigger("dht_toggleAjaxComplete");
        }
        //if colorpicker exists in the current content, reload its js code
        if ($content.find(".dht-field-child-colorpicker").length || $content.find(".dht-field-child-borders").length) {
            $(document).trigger("dht_colorPickerAjaxComplete");
        }
        //if Ace editor exists in the current content, reload its js code
        if ($content.find(".dht-field-child-code-editor").length) {
            $(document).trigger("dht_aceEditorAjaxComplete");
        }
        //if datepicker exists in the current content, reload its js code
        if ($content.find(".dht-field-child-datepicker").length) {
            $(document).trigger("dht_datePickerAjaxComplete");
        }
        //if datetimepicker exists in the current content, reload its js code
        if ($content.find(".dht-field-child-datetimepicker").length) {
            $(document).trigger("dht_dateTimePickerAjaxComplete");
        }
        //if timepicker exists in the current content, reload its js code
        if ($content.find(".dht-field-child-timepicker").length) {
            $(document).trigger("dht_timePickerAjaxComplete");
        }
        //if rangeslider exists in the current content, reload its js code
        if ($content.find(".dht-field-child-rangeslider").length) {
            $(document).trigger("dht_rangeSliderAjaxComplete");
        }
        //if multioptions exists in the current content, reload its js code
        if ($content.find(".dht-field-child-multioptions").length) {
            $(document).trigger("dht_multiOptionsAjaxComplete");
        }
        //if upload exists in the current content, reload its js code
        if ($content.find(".dht-field-child-upload-item").length) {
            $(document).trigger("dht_uploadAjaxComplete");
        }
        //if upload image exists in the current content, reload its js code
        if ($content.find(".dht-field-child-upload-image").length) {
            $(document).trigger("dht_uploadImageAjaxComplete");
        }
        //if upload gallery exists in the current content, reload its js code
        if ($content.find(".dht-field-child-upload-gallery").length) {
            $(document).trigger("dht_uploadGalleryAjaxComplete");
        }
        //if typography exists in the current content, reload its js code
        if ($content.find(".dht-field-child-typography").length) {
            $(document).trigger("dht_typographyAjaxComplete");
        }
        //if switch exists in the current content, reload its js code
        if ($content.find(".dht-field-child-switch").length) {
            $(document).trigger("dht_switchtAjaxComplete");
        }
        //if radio image exists in the current content, reload its js code
        if ($content.find(".dht-field-child-image-select").length) {
            $(document).trigger("dht_radioImageAjaxComplete");
        }
        //if multiinput exists in the current content, reload its js code
        if ($content.find(".dht-field-child-multiinput").length) {
            $(document).trigger("dht_multiInputAjaxComplete");
        }
        //if icon exists in the current content, reload its js code
        if ($content.find(".dht-field-child-icons").length) {
            $(document).trigger("dht_iconAjaxComplete");
        }

        /////////////// vb modal ///////////////
        if ($content.hasClass("dht-vb-modal-content-options")) {

            //if sidemenu container exists in the current content, reload its js code
            if ($content.find(".dht-cosidebar").length) {
                $(document).trigger("dht_sideMenuAjaxComplete");
            }
            //if tabsmenu container exists in the current content, reload its js code
            if ($content.find(".dht-tabsmenu-container").length) {
                $(document).trigger("dht_tabsMenuAjaxComplete");
            }

            //if accordion group exists in the current content, reload its js code
            if ($content.find(".dht-field-child-accordion").length) {
                $(document).trigger("dht_accordionAjaxComplete");
            }
            //if addable box group exists in the current content, reload its js code
            if ($content.find(".dht-field-child-addable-box").length) {
                $(document).trigger("dht_addableBoxAjaxComplete");
            }
            //if tabs group exists in the current content, reload its js code
            if ($content.find(".dht-field-child-tabs").length) {
                $(document).trigger("dht_tabsAjaxComplete");
            }
        }
    }

    dhtReinitializeWPEditor($content);
}

/**
 * reinitialize the wp editor option loaded via ajax
 *
 * @return void
 */
function dhtReinitializeWPEditor($content: JQuery<HTMLElement>) {
    //reinitialize the wp editor option
    $content.find("textarea.wp-editor-area").each(function() {
        if (typeof wp === "undefined" || typeof wp.editor === "undefined") return;

        //get editor if
        const id = $(this).attr("id")!;

        if (typeof wp.editor !== "undefined" && typeof id !== "undefined") {
            wp.editor.remove(id);
            wp.editor.initialize(id, {
                tinymce: {
                    wpautop: true,
                    plugins:
                        "charmap colorpicker compat3x directionality fullscreen hr image lists media paste tabfocus textcolor wordpress wpautoresize wpdialogs wpeditimage wpemoji wpgallery wplink wptextpattern wpview",
                    toolbar1: "formatselect bold italic bullist numlist blockquote alignleft aligncenter alignright link wp_more wp_adv",
                    toolbar2: "strikethrough hr forecolor pastetext removeformat charmap outdent indent undo redo wp_help",
                },
                quicktags: {
                    id: id,
                    buttons: "strong,em,link,block,del,ins,img,ul,ol,li,code,more,close",
                },
                mediaButtons: true,
            });
        }
    });
}

