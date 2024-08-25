/******/ (() => { // webpackBootstrap
/******/ 	"use strict";
/******/ 	var __webpack_modules__ = ({

/***/ "jquery":
/*!*************************!*\
  !*** external "jQuery" ***!
  \*************************/
/***/ ((module) => {

module.exports = jQuery;

/***/ })

/******/ 	});
/************************************************************************/
/******/ 	// The module cache
/******/ 	var __webpack_module_cache__ = {};
/******/ 	
/******/ 	// The require function
/******/ 	function __webpack_require__(moduleId) {
/******/ 		// Check if module is in cache
/******/ 		var cachedModule = __webpack_module_cache__[moduleId];
/******/ 		if (cachedModule !== undefined) {
/******/ 			return cachedModule.exports;
/******/ 		}
/******/ 		// Create a new module (and put it into the cache)
/******/ 		var module = __webpack_module_cache__[moduleId] = {
/******/ 			// no module.id needed
/******/ 			// no module.loaded needed
/******/ 			exports: {}
/******/ 		};
/******/ 	
/******/ 		// Execute the module function
/******/ 		__webpack_modules__[moduleId](module, module.exports, __webpack_require__);
/******/ 	
/******/ 		// Return the exports of the module
/******/ 		return module.exports;
/******/ 	}
/******/ 	
/************************************************************************/
/******/ 	/* webpack/runtime/compat get default export */
/******/ 	(() => {
/******/ 		// getDefaultExport function for compatibility with non-harmony modules
/******/ 		__webpack_require__.n = (module) => {
/******/ 			var getter = module && module.__esModule ?
/******/ 				() => (module['default']) :
/******/ 				() => (module);
/******/ 			__webpack_require__.d(getter, { a: getter });
/******/ 			return getter;
/******/ 		};
/******/ 	})();
/******/ 	
/******/ 	/* webpack/runtime/define property getters */
/******/ 	(() => {
/******/ 		// define getter functions for harmony exports
/******/ 		__webpack_require__.d = (exports, definition) => {
/******/ 			for(var key in definition) {
/******/ 				if(__webpack_require__.o(definition, key) && !__webpack_require__.o(exports, key)) {
/******/ 					Object.defineProperty(exports, key, { enumerable: true, get: definition[key] });
/******/ 				}
/******/ 			}
/******/ 		};
/******/ 	})();
/******/ 	
/******/ 	/* webpack/runtime/hasOwnProperty shorthand */
/******/ 	(() => {
/******/ 		__webpack_require__.o = (obj, prop) => (Object.prototype.hasOwnProperty.call(obj, prop))
/******/ 	})();
/******/ 	
/******/ 	/* webpack/runtime/make namespace object */
/******/ 	(() => {
/******/ 		// define __esModule on exports
/******/ 		__webpack_require__.r = (exports) => {
/******/ 			if(typeof Symbol !== 'undefined' && Symbol.toStringTag) {
/******/ 				Object.defineProperty(exports, Symbol.toStringTag, { value: 'Module' });
/******/ 			}
/******/ 			Object.defineProperty(exports, '__esModule', { value: true });
/******/ 		};
/******/ 	})();
/******/ 	
/************************************************************************/
var __webpack_exports__ = {};
// This entry need to be wrapped in an IIFE because it need to be isolated against other modules in the chunk.
(() => {
/*!********************************************************************!*\
  !*** ./assets/scripts/ts/extensions/options/groups/addable-box.ts ***!
  \********************************************************************/
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var jquery__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! jquery */ "jquery");
/* harmony import */ var jquery__WEBPACK_IMPORTED_MODULE_0___default = /*#__PURE__*/__webpack_require__.n(jquery__WEBPACK_IMPORTED_MODULE_0__);

(function ($) {
    "use strict";
    var AddableBox = /** @class */ (function () {
        function AddableBox($addable_box) {
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
        AddableBox.prototype._initAddableBox = function () {
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
        };
        /**
         * add new box item to the addable box
         *
         * @return void
         */
        AddableBox.prototype._addBoxItem = function () {
            //this class reference
            var $thisClass = this;
            this.$_addable_box.on("click", ".dht-addable-box-repeater .dht-add-box-item", function (e) {
                e.preventDefault();
                var $add_button = $(this);
                //parent items
                var $box_items = $add_button.siblings(".dht-addable-box-items");
                if ($thisClass._maxBoxItems($box_items))
                    return;
                //disable add box item button
                $add_button.addClass("dht-btn-disabled");
                //clone the box item
                var $prev_box_item = $box_items.children(":last");
                var $box_item = $prev_box_item.clone().attr("data-box-item-number", +$prev_box_item.attr("data-box-item-number") + 1);
                //box item content reference
                var $box_content_area = $box_item.children(".dht-addable-box-content");
                //if box item opened, close it
                var box_item_title = $box_item.children(".dht-addable-box-title");
                box_item_title.removeClass("dht-addable-box-active").children(".dht-addable-box-arrow").removeClass("dht-addable-box-icon-change");
                $box_content_area.empty().hide();
                //clear box title values
                var $box_title_text = box_item_title.children(".dht-addable-box-title-text");
                $box_title_text.text($box_title_text.attr("data-default-title"));
                //add box items and load their options
                $thisClass._ajaxLoadOptions($box_items, $add_button, $box_item, $box_content_area, box_item_title);
            });
        };
        /**
         * remove box item
         *
         * @return void
         */
        AddableBox.prototype._removeBoxItem = function () {
            this.$_addable_box.on("click", ".dht-addable-box-repeater .dht-btn-remove-box-item", function (e) {
                e.preventDefault();
                var $this = $(this);
                var $box_item = $this.parents(".dht-addable-box-item");
                var $main_parent = $box_item.parents(".dht-addable-box-repeater");
                if ($main_parent.children(".dht-addable-box-items").children(".dht-addable-box-item").length === 1) {
                    confirm($main_parent.children(".dht-box-remove-text").text());
                    return;
                }
                $box_item.remove();
                return false;
            });
        };
        /**
         * open/close box items on click
         *
         * @return void
         */
        AddableBox.prototype._openCloseBoxItem = function () {
            //this class reference
            var $thisClass = this;
            this.$_addable_box.on("click", ".dht-addable-box .dht-addable-box-title", function (e) {
                e.preventDefault();
                var $current_box_title = $(this);
                if ($current_box_title.hasClass("dht-addable-box-active"))
                    return;
                var $current_box_item = $current_box_title.parent(".dht-addable-box-item");
                $thisClass._boxItemsManipulations($current_box_item, $current_box_title);
            });
        };
        /**
         * change box item title when the input title is changed
         *
         * @return void
         */
        AddableBox.prototype._changeBoxTitleOnKeyUp = function () {
            this.$_addable_box.on("keyup", ".dht-addable-box-repeater .dht-addable-box-item .dht-box-title", function (e) {
                var value = $(this).val();
                $(this).parents(".dht-addable-box-content").siblings(".dht-addable-box-title").children(".dht-addable-box-title-text").text(value);
            });
        };
        /**
         * make box items sortable
         *
         * @return void
         */
        AddableBox.prototype._enableSortableBoxes = function () {
            if (this.$_addable_box.hasClass("dht-field-child-addable-box-sortable")) {
                this.$_addable_box.children(".dht-addable-box-repeater").children(".dht-addable-box-items").sortable();
            }
        };
        /**
         * ajax function to add box items and load their options
         *
         * @return void
         */
        AddableBox.prototype._ajaxLoadOptions = function ($box_items, $add_button, $box_item, $box_content_area, box_item_title) {
            //this class reference
            var $thisClass = this;
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
        };
        /**
         * limit adding more box items than set
         *
         * @return void
         */
        AddableBox.prototype._maxBoxItems = function ($box_items) {
            //max box items number
            if (+$box_items.attr("data-max-box-items") >= $box_items.length) {
                confirm($box_items.siblings(".dht-max-box-items").text());
                return true;
            }
            return false;
        };
        /**
         * open close the box item
         *
         * @return void
         */
        AddableBox.prototype._boxItemsManipulations = function ($box_item, $current_box_title) {
            //get other box items title references
            var $box_items = $box_item.siblings(".dht-addable-box-item");
            var $box_title = $box_items.children(".dht-addable-box-title");
            //remove active class from other box items
            $box_title.removeClass("dht-addable-box-active");
            $box_title.children(".dht-addable-box-arrow").removeClass("dht-addable-box-icon-change");
            $box_items.children(".dht-addable-box-content").slideUp(400);
            //add active class and change the icon
            $current_box_title.toggleClass("dht-addable-box-active");
            $current_box_title.next().slideToggle();
            $current_box_title.children(".dht-addable-box-arrow").toggleClass("dht-addable-box-icon-change");
        };
        /**
         * reinitialize options loaded via ajax
         *
         * @return void
         */
        AddableBox.prototype._reinitializeOptions = function ($content) {
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
            this._reinitializeWPEditor($content);
        };
        /**
         * reinitialize options loaded via ajax
         *
         * @return void
         */
        AddableBox.prototype._reinitializeWPEditor = function ($content) {
            //reinitialize the wp editor option
            $content.find("textarea.wp-editor-area").each(function () {
                if (typeof wp === "undefined" || typeof wp.editor === "undefined")
                    return;
                //get editor if
                var id = $(this).attr("id");
                if (typeof wp.editor !== "undefined" && typeof id !== "undefined") {
                    wp.editor.remove(id);
                    wp.editor.initialize(id, {
                        tinymce: {
                            wpautop: true,
                            plugins: "charmap colorpicker compat3x directionality fullscreen hr image lists media paste tabfocus textcolor wordpress wpautoresize wpdialogs wpeditimage wpemoji wpgallery wplink wptextpattern wpview",
                            toolbar1: "formatselect bold italic bullist numlist blockquote alignleft aligncenter alignright link wp_more fullscreen wp_adv",
                            toolbar2: "strikethrough hr forecolor pastetext removeformat charmap outdent indent undo redo wp_help",
                        },
                        quicktags: {
                            id: id,
                            buttons: "strong,em,link,block,del,ins,img,ul,ol,li,code,more,close",
                        },
                        mediaButtons: true,
                    });
                    /* This method did not work fully
                    
                    // Remove existing editors
                    //tinymce.execCommand("mceRemoveEditor", true, id);

                    // Reinitialize TinyMCE editor
                    tinymce.execCommand("mceAddEditor", true, id);

                    // Initialize Quicktags
                    if (typeof quicktags === "function") {
                        quicktags({ id: id });
                    }

                    //get active tab
                    const parent_editor = $("#" + id).parents(".wp-editor-wrap");
                    if (parent_editor.hasClass("html-active")) {
                        //tinymce.execCommand("mceToggleEditor", true, id);

                        parent_editor.removeClass("html-active").addClass("tmce-active");
                        parent_editor.find(".switch-tmce").click();
                    }*/
                }
            });
        };
        return AddableBox;
    }());
    //init each accordion group
    $(".dht-field-wrapper .dht-field-child-addable-box").each(function () {
        new AddableBox($(this));
    });
})((jquery__WEBPACK_IMPORTED_MODULE_0___default()));

})();

/******/ })()
;
//# sourceMappingURL=addable-box-script.js.map