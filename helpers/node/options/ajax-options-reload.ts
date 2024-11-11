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
        if ($content.find(".dht-field-wrapper-toggle").length) {
            $(document).trigger("dht_toggleAjaxComplete");
        }
        //if colorpicker exists in the current content, reload its js code
        if ($content.find(".dht-field-wrapper-colorpicker").length) {
            $(document).trigger("dht_colorPickerAjaxComplete");
        }
        //if borders exists in the current content, reload its js code
        if ($content.find(".dht-field-wrapper-dimension").length) {
            $(document).trigger("dht_dimensionAjaxComplete");
        }
        //if Ace editor exists in the current content, reload its js code
        if ($content.find(".dht-field-wrapper-code-editor").length) {
            $(document).trigger("dht_aceEditorAjaxComplete");
        }
        //if datepicker exists in the current content, reload its js code
        if ($content.find(".dht-field-wrapper-datepicker").length) {
            $(document).trigger("dht_datePickerAjaxComplete");
        }
        //if datetimepicker exists in the current content, reload its js code
        if ($content.find(".dht-field-wrapper-datetimepicker").length) {
            $(document).trigger("dht_dateTimePickerAjaxComplete");
        }
        //if timepicker exists in the current content, reload its js code
        if ($content.find(".dht-field-wrapper-timepicker").length) {
            $(document).trigger("dht_timePickerAjaxComplete");
        }
        //if rangeslider exists in the current content, reload its js code
        if ($content.find(".dht-field-wrapper-rangeslider").length) {
            $(document).trigger("dht_rangeSliderAjaxComplete");
        }
        //if multioptions exists in the current content, reload its js code
        if ($content.find(".dht-field-wrapper-multioptions").length) {
            $(document).trigger("dht_multiOptionsAjaxComplete");
        }
        //if upload exists in the current content, reload its js code
        if ($content.find(".dht-field-wrapper-upload-item").length) {
            $(document).trigger("dht_uploadAjaxComplete");
        }
        //if upload image exists in the current content, reload its js code
        if ($content.find(".dht-field-wrapper-upload-image").length) {
            $(document).trigger("dht_uploadImageAjaxComplete");
        }
        //if upload gallery exists in the current content, reload its js code
        if ($content.find(".dht-field-wrapper-upload-gallery").length) {
            $(document).trigger("dht_uploadGalleryAjaxComplete");
        }
        //if typography exists in the current content, reload its js code
        if ($content.find(".dht-field-wrapper-typography").length) {
            $(document).trigger("dht_typographyAjaxComplete");
        }
        //if switch exists in the current content, reload its js code
        if ($content.find(".dht-field-wrapper-switch").length) {
            $(document).trigger("dht_switchtAjaxComplete");
        }
        //if radio image exists in the current content, reload its js code
        if ($content.find(".dht-field-wrapper-image-select").length) {
            $(document).trigger("dht_radioImageAjaxComplete");
        }
        //if multiinput exists in the current content, reload its js code
        if ($content.find(".dht-field-wrapper-multiinput").length) {
            $(document).trigger("dht_multiInputAjaxComplete");
        }
        //if icon exists in the current content, reload its js code
        if ($content.find(".dht-field-wrapper-icons").length) {
            $(document).trigger("dht_iconAjaxComplete");
        }
        //if inputs exists in the current content, reload its js code
        const $inputs = $content.find(".dht-field-wrapper-input");
        if ($inputs.length && $inputs.filter("[data-live-selectors]").length > 0) {
            $(document).trigger("dht_inputAjaxComplete");
        }
        //if dropdowns exists in the current content, reload its js code
        const $dropdowns = $content.find(".dht-field-wrapper-dropdown");
        if ($dropdowns.length && $dropdowns.filter("[data-live-selectors]").length > 0) {
            $(document).trigger("dht_dropdownAjaxComplete");
        }
        //if textareas exists in the current content, reload its js code
        const $textareas = $content.find(".dht-field-wrapper-textarea");
        if ($textareas.length && $textareas.filter("[data-live-selectors]").length > 0) {
            $(document).trigger("dht_textareaAjaxComplete");
        }
        //if wpeditors exists in the current content, reload its js code
        const $wpEditors = $content.find(".dht-field-wrapper-editor");
        if ($wpEditors.length && $wpEditors.filter("[data-live-selectors]").length > 0) {
            $(document).trigger("dht_wpEditorAjaxComplete");
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
            if ($content.find(".dht-field-wrapper-accordion").length) {
                $(document).trigger("dht_accordionAjaxComplete");
            }
            //if panel group exists in the current content, reload its js code
            if ($content.find(".dht-field-wrapper-panel").length) {
                $(document).trigger("dht_panelAjaxComplete");
            }
            //if addable box group exists in the current content, reload its js code
            if ($content.find(".dht-field-wrapper-addable-box").length) {
                $(document).trigger("dht_addableBoxAjaxComplete");
            }
            //if tabs group exists in the current content, reload its js code
            if ($content.find(".dht-field-wrapper-tabs").length) {
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

