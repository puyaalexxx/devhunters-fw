"use strict";
(function ($) {
    "use strict";
    class AddableBox {
        constructor($addable_box) {
            //tabs reference
            this.$_addable_box = $addable_box;
            //init accordion
            this._initAddableBox();
        }
        /**
         * init addable box
         *
         * @return void
         */
        _initAddableBox() {
            //add new box item to the addable box
            this._addBoxItem();
            //remove box item
            this._removeBoxItem();
            //open/close box items on click
            this._openCloseBoxItem();
            //change box item title when the input title is changed
            this._changeBoxTitleOnKeyUp();
            //make box items sortable
            this._enableSortableBoxes();
        }
        /**
         * add new box item to the addable box
         *
         * @return void
         */
        _addBoxItem() {
            //this class reference
            const $thisClass = this;
            this.$_addable_box.on("click", ".dht-addable-box-repeater .dht-add-box-item", function (e) {
                e.preventDefault();
                const $add_button = $(this);
                //parent items
                const $box_items = $add_button.siblings(".dht-addable-box-items");
                if ($thisClass._maxBoxItems($box_items))
                    return;
                //disable add box item button
                $add_button.addClass("dht-btn-disabled");
                //clone the box item
                const $prev_box_item = $box_items.children(":last");
                let $box_item = $prev_box_item.clone().attr("data-box-item-number", +$prev_box_item.attr("data-box-item-number") + 1);
                //box item content reference
                const $box_content_area = $box_item.children(".dht-addable-box-content");
                //if box item opened, close it
                const box_item_title = $box_item.children(".dht-addable-box-title");
                box_item_title.removeClass("dht-addable-box-active").children(".dht-addable-box-arrow").removeClass("dht-addable-box-icon-change");
                $box_content_area.empty().hide();
                //clear box title values
                const $box_title_text = box_item_title.children(".dht-addable-box-title-text");
                $box_title_text.text($box_title_text.attr("data-default-title"));
                //add box items and load their options
                $thisClass._ajaxLoadOptions($box_items, $add_button, $box_item, $box_content_area, box_item_title);
            });
        }
        /**
         * remove box item
         *
         * @return void
         */
        _removeBoxItem() {
            this.$_addable_box.on("click", ".dht-addable-box-repeater .dht-btn-remove-box-item", function (e) {
                e.preventDefault();
                const $this = $(this);
                const $box_item = $this.parents(".dht-addable-box-item");
                const $main_parent = $box_item.parents(".dht-addable-box-repeater");
                if ($main_parent.children(".dht-addable-box-items").children(".dht-addable-box-item").length === 1) {
                    confirm($main_parent.children(".dht-box-remove-text").text());
                    return;
                }
                $box_item.remove();
                return false;
            });
        }
        /**
         * open/close box items on click
         *
         * @return void
         */
        _openCloseBoxItem() {
            //this class reference
            const $thisClass = this;
            this.$_addable_box.on("click", ".dht-addable-box .dht-addable-box-title", function (e) {
                e.preventDefault();
                const $current_box_title = $(this);
                if ($current_box_title.hasClass("dht-addable-box-active"))
                    return;
                const $current_box_item = $current_box_title.parent(".dht-addable-box-item");
                $thisClass._boxItemsManipulations($current_box_item, $current_box_title);
            });
        }
        /**
         * change box item title when the input title is changed
         *
         * @return void
         */
        _changeBoxTitleOnKeyUp() {
            this.$_addable_box.on("keyup", ".dht-addable-box-repeater .dht-addable-box-item .dht-box-title", function (e) {
                const value = $(this).val();
                $(this).parents(".dht-addable-box-content").siblings(".dht-addable-box-title").children(".dht-addable-box-title-text").text(value);
            });
        }
        /**
         * make box items sortable
         *
         * @return void
         */
        _enableSortableBoxes() {
            if (this.$_addable_box.hasClass("dht-field-child-addable-box-sortable")) {
                this.$_addable_box.children(".dht-addable-box-repeater").children(".dht-addable-box-items").sortable({
                    containment: "parent",
                    forcePlaceholderSize: true,
                    handle: ".dht-addable-box-title", // Selector for the handle element
                    placeholder: "sortable-placeholder", // Optional: Adds a placeholder during sorting
                });
            }
        }
        /**
         * ajax function to add box items and load their options
         *
         * @return void
         */
        _ajaxLoadOptions($box_items, $add_button, $box_item, $box_content_area, box_item_title) {
            //this class reference
            const $thisClass = this;
            //load box options inside
            $.ajax({
                // @ts-ignore
                url: dht_framework_ajax_info.ajax_url,
                type: "POST",
                dataType: "json",
                data: {
                    action: "getBoxOptions", // The name of your AJAX action
                    data: {
                        group: $add_button.siblings(".dht-box-item-options").val(),
                        box_number: $box_item.attr("data-box-item-number"),
                    },
                },
                beforeSend: function () {
                    //show loading spinner
                    $add_button.siblings(".spinner").css("visibility", "visible");
                },
                success: function (response) {
                    if (response.success) {
                        //add the cloned box
                        $box_items.append($box_item);
                        //append HTML content of the options to the box
                        $box_content_area.append(response.data);
                        // Initialize options so they could work as expected
                        setTimeout(function () {
                            $thisClass._reinitializeOptions($box_content_area);
                        }, 100);
                        $thisClass._boxItemsManipulations($box_item, box_item_title);
                    }
                    else {
                        console.error("Ajax Response", response);
                    }
                },
                error: function (error) {
                    console.error("AJAX error:", error);
                },
                complete: function () {
                    //hide loading spinner
                    $add_button.siblings(".spinner").css("visibility", "hidden");
                    //enable add box item button back
                    $add_button.removeClass("dht-btn-disabled");
                },
            });
        }
        /**
         * limit adding more box items than set
         *
         * @return void
         */
        _maxBoxItems($box_items) {
            //max box items number
            if (+$box_items.attr("data-max-box-items") >= $box_items.length) {
                confirm($box_items.siblings(".dht-max-box-items").text());
                return true;
            }
            return false;
        }
        /**
         * open close the box item
         *
         * @return void
         */
        _boxItemsManipulations($box_item, $current_box_title) {
            //get other box items title references
            const $box_items = $box_item.siblings(".dht-addable-box-item");
            const $box_title = $box_items.children(".dht-addable-box-title");
            //remove active class from other box items
            $box_title.removeClass("dht-addable-box-active");
            $box_title.children(".dht-addable-box-arrow").removeClass("dht-addable-box-icon-change");
            $box_items.children(".dht-addable-box-content").slideUp(400);
            //add active class and change the icon
            $current_box_title.toggleClass("dht-addable-box-active");
            $current_box_title.next().slideToggle();
            $current_box_title.children(".dht-addable-box-arrow").toggleClass("dht-addable-box-icon-change");
        }
        /**
         * reinitialize options loaded via ajax
         *
         * @return void
         */
        _reinitializeOptions($content) {
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
            }
            this._reinitializeWPEditor($content);
        }
        /**
         * reinitialize options loaded via ajax
         *
         * @return void
         */
        _reinitializeWPEditor($content) {
            //reinitialize the wp editor option
            $content.find("textarea.wp-editor-area").each(function () {
                if (typeof wp === "undefined" || typeof wp.editor === "undefined")
                    return;
                //get editor if
                const id = $(this).attr("id");
                if (typeof wp.editor !== "undefined" && typeof id !== "undefined") {
                    wp.editor.remove(id);
                    wp.editor.initialize(id, {
                        tinymce: {
                            wpautop: true,
                            plugins: "charmap colorpicker compat3x directionality fullscreen hr image lists media paste tabfocus textcolor wordpress wpautoresize wpdialogs wpeditimage wpemoji wpgallery wplink wptextpattern wpview",
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
    }
    //init each accordion group
    $(".dht-field-wrapper .dht-field-child-addable-box").each(function () {
        new AddableBox($(this));
    });
})(jQuery);
