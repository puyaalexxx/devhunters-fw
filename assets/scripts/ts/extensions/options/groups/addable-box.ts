import jQuery from "jquery";

(function ($: JQueryStatic): void {
    "use strict";

    class AddableBox {
        //addable box reference
        private $_addable_box;

        constructor($addable_box: JQuery<HTMLElement>) {
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
        private _initAddableBox(): void {
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
        private _addBoxItem() {
            //this class reference
            const $thisClass = this;

            this.$_addable_box.on("click", ".dht-addable-box-repeater .dht-add-box-item", function (e) {
                e.preventDefault();

                const $add_button = $(this);

                //parent items
                const $box_items = $add_button.siblings(".dht-addable-box-items");

                if ($thisClass._maxBoxItems($box_items)) return;

                //disable add box item button
                $add_button.addClass("dht-btn-disabled");

                //clone the box item
                const $prev_box_item = $box_items.children(":last");
                let $box_item = $prev_box_item.clone().attr("data-box-item-number", +$prev_box_item.attr("data-box-item-number")! + 1);

                //box item content reference
                const $box_content_area = $box_item.children(".dht-addable-box-content");

                //if box item opened, close it
                const box_item_title = $box_item.children(".dht-addable-box-title");
                box_item_title.removeClass("dht-addable-box-active").children(".dht-addable-box-arrow").removeClass("dht-addable-box-icon-change");
                $box_content_area.empty().hide();

                //clear box title values
                const $box_title_text = box_item_title.children(".dht-addable-box-title-text");
                $box_title_text.text($box_title_text.attr("data-default-title")!);

                //add box items and load their options
                $thisClass._ajaxLoadOptions($box_items, $add_button, $box_item, $box_content_area, box_item_title);
            });
        }

        /**
         * remove box item
         *
         * @return void
         */
        private _removeBoxItem() {
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
        private _openCloseBoxItem() {
            //this class reference
            const $thisClass = this;

            this.$_addable_box.on("click", ".dht-addable-box .dht-addable-box-title", function (e) {
                e.preventDefault();

                const $current_box_title = $(this);

                if ($current_box_title.hasClass("dht-addable-box-active")) return;

                const $current_box_item = $current_box_title.parent(".dht-addable-box-item");

                $thisClass._boxItemsManipulations($current_box_item, $current_box_title);
            });
        }

        /**
         * change box item title when the input title is changed
         *
         * @return void
         */
        private _changeBoxTitleOnKeyUp() {
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
        private _enableSortableBoxes() {
            $(".dht-field-child-addable-box.dht-field-child-addable-box-sortable .dht-addable-box-repeater .dht-addable-box-items").sortable();
        }

        /**
         * ajax function to add box items and load their options
         *
         * @return void
         */
        private _ajaxLoadOptions(
            $box_items: JQuery<HTMLElement>,
            $add_button: JQuery<HTMLElement>,
            $box_item: JQuery<HTMLElement>,
            $box_content_area: JQuery<HTMLElement>,
            box_item_title: JQuery<HTMLElement>
        ) {
            //this class reference
            const $thisClass = this;

            //load box options inside
            $.ajax({
                // @ts-ignore
                url: dht_addable_box_option_ajax.ajax_url,
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

                        console.log(response);

                        // Initialize options so they could work as expected
                        setTimeout(function () {
                            $thisClass._reinitializeOptions($box_content_area);
                        }, 100);

                        $thisClass._boxItemsManipulations($box_item, box_item_title);
                    } else {
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
        private _maxBoxItems($box_items: JQuery<HTMLElement>) {
            //max box items number
            if (+$box_items.attr("data-max-box-items")! >= $box_items.length) {
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
        private _boxItemsManipulations($box_item: JQuery<HTMLElement>, $current_box_title: JQuery<HTMLElement>) {
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
        private _reinitializeOptions($content: JQuery<HTMLElement>) {
            // Trigger custom ajax events based on the presence of specific elements
            {
                //if colorpicker exists in the current content, reload its js code
                if ($content.find(".dht-field-child-colorpicker") || $content.find(".dht-field-child-borders")) {
                    $(document).trigger("dht_colorPickerAjaxComplete");
                }
                //if Ace editor exists in the current content, reload its js code
                if ($content.find(".dht-field-child-code-editor")) {
                    $(document).trigger("dht_aceEditorAjaxComplete");
                }
                //if datepicker exists in the current content, reload its js code
                if ($content.find(".dht-field-child-datepicker")) {
                    $(document).trigger("dht_datePickerAjaxComplete");
                }
                //if datetimepicker exists in the current content, reload its js code
                if ($content.find(".dht-field-child-datetimepicker")) {
                    $(document).trigger("dht_dateTimePickerAjaxComplete");
                }
                //if timepicker exists in the current content, reload its js code
                if ($content.find(".dht-field-child-timepicker")) {
                    $(document).trigger("dht_timePickerAjaxComplete");
                }
                //if rangeslider exists in the current content, reload its js code
                if ($content.find(".dht-field-child-rangeslider")) {
                    $(document).trigger("dht_rangeSliderAjaxComplete");
                }
                //if multioptions exists in the current content, reload its js code
                if ($content.find(".dht-field-child-multioptions")) {
                    $(document).trigger("dht_multiOptionsAjaxComplete");
                }
                //if upload exists in the current content, reload its js code
                if ($content.find(".dht-field-child-upload-item")) {
                    $(document).trigger("dht_uploadAjaxComplete");
                }
                //if upload image exists in the current content, reload its js code
                if ($content.find(".dht-field-child-upload-image")) {
                    $(document).trigger("dht_uploadImageAjaxComplete");
                }
                //if upload gallery exists in the current content, reload its js code
                if ($content.find(".dht-field-child-upload-gallery")) {
                    $(document).trigger("dht_uploadGalleryAjaxComplete");
                }
                //if typography exists in the current content, reload its js code
                if ($content.find(".dht-field-child-typography")) {
                    $(document).trigger("dht_typographyAjaxComplete");
                }
            }

            //reinitialize the wp editor option
            $content.find("textarea.wp-editor-area").each(function () {
                if (typeof wp === "undefined" || typeof wp.editor === "undefined") return;

                //get editor if
                const id = $(this).attr("id");

                /*if (typeof tinymce !== "undefined") {
                    // Remove existing editors
                    tinymce.execCommand("mceRemoveEditor", true, id);

                    // Reinitialize TinyMCE editor
                    tinymce.execCommand("mceAddEditor", true, id);

                    //add editor skin
                    tinymce.tinymce = {
                        skin: "wp_theme",
                    };

                    // Initialize Quicktags
                    if (typeof quicktags === "function") {
                        quicktags({ id: id });
                    }
                }*/
            });
        }
    }

    //init each accordion group
    $(".dht-field-wrapper .dht-field-child-addable-box").each(function () {
        new AddableBox($(this));
    });
})(jQuery);
