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
/*!************************************************************!*\
  !*** ./assets/scripts/ts/extensions/options/typography.ts ***!
  \************************************************************/
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var jquery__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! jquery */ "jquery");
/* harmony import */ var jquery__WEBPACK_IMPORTED_MODULE_0___default = /*#__PURE__*/__webpack_require__.n(jquery__WEBPACK_IMPORTED_MODULE_0__);

(function ($) {
    "use strict";
    var Typography = /** @class */ (function () {
        function Typography($typography) {
            //store selected google font name
            this._selected_google_font_name = "";
            //typography reference
            this.$_typography = $typography;
            //this class reference
            var $thisClass = this;
            //preview area div
            this.$_preview_area = this.$_typography.children(".dht-field-child-typography-preview");
            //fonts dropdown
            this.$_fonts_dropdown = this.$_typography.find(".dht-typography");
            //font weights dropdown
            this.$_font_weight_dropdown = this.$_typography.find(".dht-typography-weight");
            //font styles dropdown
            this.$_font_style_dropdown = this.$_typography.find(".dht-typography-style");
            //font subsets
            this.$_font_subsets_dropdown = this.$_typography.find(".dht-typography-subsets");
            //text transform
            this.$_text_transform_dropdown = this.$_typography.find(".dht-typography-transform");
            //text decoration
            this.$_text_decoration_dropdown = this.$_typography.find(".dht-typography-decoration");
            //font prefix
            this._font_prefix = this.$_fonts_dropdown.attr("data-font-prefix");
            //font type hidden input
            this.$_font_type_hidden_input = this.$_fonts_dropdown.siblings(".dht-typography-font-type-hidden");
            //font path hidden input
            this.$_font_path_hidden_input = this.$_fonts_dropdown.siblings(".dht-typography-path-hidden");
            //set saved values
            this._setHeaderFontFromSavedValues($thisClass);
            //font family dropdown
            this._fontDropdown($thisClass);
            //font weights dropdown
            this._fontWeightsDropdown($thisClass);
            //font styles dropdown
            this._fontStylesDropdown($thisClass);
            //font subsets dropdown
            this._fontSubsetsDropdown($thisClass);
            //text transform dropdown
            this._textTransformDropdown($thisClass);
            //text decoration dropdown
            this._textDecorationDropdown($thisClass);
        }
        /**
         * init fonts dropdown
         *
         * @param $thisClass : this
         *
         * @return void
         */
        Typography.prototype._fontDropdown = function ($thisClass) {
            this.$_fonts_dropdown.select2({
                allowClear: true,
            });
            this.$_fonts_dropdown.on("change", function () {
                var $selected_font = $(this);
                //get font type (google, standard, divi)
                var font_type = String($selected_font.find("option:selected").attr("data-font-type"));
                //get the selected font family
                var font_family = String($selected_font.val()).replace(new RegExp("^".concat($thisClass._font_prefix, "-")), "");
                //apply font to preview area
                $thisClass.$_preview_area.css("font-family", font_family);
                //if Google font
                if (font_type === "google") {
                    $thisClass._googleFontsManipulations($thisClass, $selected_font, font_family);
                }
                else if (font_type === "divi") {
                    $thisClass._diviFontsManipulations($thisClass, $selected_font, font_family);
                }
                else {
                    $thisClass._standardFontsManipulations($thisClass, $selected_font);
                }
            });
        };
        /**
         * Google fonts manipulations
         *
         * @param $thisClass : this
         * @param $selected_font : JQuery<HTMLElement>
         * @param font_family : string
         *
         * @return void
         */
        Typography.prototype._googleFontsManipulations = function ($thisClass, $selected_font, font_family) {
            //set font type input value
            $thisClass.$_font_type_hidden_input.attr("value", "google");
            //set font path input value
            $thisClass.$_font_path_hidden_input.attr("value", "");
            //variable used in other dropdowns
            $thisClass._selected_google_font_name = font_family;
            //get the selected Google font - font subsets
            var font_subsets = String($selected_font.find("option:selected").attr("data-font-subsets"));
            //include the font link for preview
            $thisClass._buildFontLink(font_family);
            //add Google font - font weights to the font weights dropdown
            var font_weights = $selected_font.find("option:selected").attr("data-font-weights");
            $thisClass._populateFontWeightDropdown($thisClass, $selected_font, font_weights);
            //add Google font - font subsets to the font subsets dropdown
            $thisClass._populateFontSubsetsDropdown($thisClass, font_subsets);
            // Trigger change event to update Select2
            $thisClass.$_font_weight_dropdown.trigger("change");
        };
        /**
         * Divi fonts manipulations
         *
         * @param $thisClass : this
         * @param $selected_font : JQuery<HTMLElement>
         * @param font_family : string
         *
         * @return void
         */
        Typography.prototype._diviFontsManipulations = function ($thisClass, $selected_font, font_family) {
            //set font type input value
            $thisClass.$_font_type_hidden_input.attr("value", "divi");
            //get font path
            var font_path = String($selected_font.find("option:selected").attr("data-font-path"));
            //set font path input value
            $thisClass.$_font_path_hidden_input.attr("value", font_path);
            //preview css code (font face)
            $thisClass._setStyleTagCSS($thisClass, font_family, font_path);
            //no subsets present for standard fonts
            $thisClass.$_font_subsets_dropdown.empty().trigger("change");
            //add Divi font - font weights to the font weights dropdown
            var font_weights = $selected_font.find("option:selected").attr("data-font-weights");
            $thisClass._populateFontWeightDropdown($thisClass, $selected_font, font_weights);
        };
        /**
         * standard fonts manipulations
         *
         * @param $thisClass : this
         * @param $selected_font : JQuery<HTMLElement>
         *
         * @return void
         */
        Typography.prototype._standardFontsManipulations = function ($thisClass, $selected_font) {
            //set font type input value
            $thisClass.$_font_type_hidden_input.attr("value", "standard");
            //set font path input value
            $thisClass.$_font_path_hidden_input.attr("value", "");
            //no subsets present for standard fonts
            $thisClass.$_font_subsets_dropdown.empty().trigger("change");
            //restore the standard font weights
            var font_weights = $thisClass.$_font_weight_dropdown.attr("data-standard-font-weights");
            $thisClass._populateFontWeightDropdown($thisClass, $selected_font, font_weights);
        };
        /**
         * font weights dropdown
         *
         * @param $thisClass : this
         *
         * @return void
         */
        Typography.prototype._fontWeightsDropdown = function ($thisClass) {
            this.$_font_weight_dropdown.select2({
                allowClear: true,
            });
            this.$_font_weight_dropdown.on("change", function () {
                var font_weight = String($(this).val());
                //include the font link for preview + font weight
                if (font_weight.length !== 0) {
                    var fontLink = "https://fonts.googleapis.com/css?family=" + $thisClass._selected_google_font_name.replace(/\s+/g, "+") + ":" + font_weight;
                    $('<link href="' + fontLink + '" rel="stylesheet">').appendTo("head");
                }
                $thisClass.$_preview_area.css("font-weight", font_weight);
            });
        };
        /**
         * font subsets dropdown
         *
         * @param $thisClass : this
         *
         * @return void
         */
        Typography.prototype._fontSubsetsDropdown = function ($thisClass) {
            this.$_font_subsets_dropdown.select2({
                allowClear: true,
            });
        };
        /**
         * font styles dropdown
         *
         * @param $thisClass : this
         *
         * @return void
         */
        Typography.prototype._fontStylesDropdown = function ($thisClass) {
            this.$_font_style_dropdown.select2({
                allowClear: true,
            });
            this.$_font_style_dropdown.on("change", function () {
                var font_style = String($(this).val());
                $thisClass.$_preview_area.css("font-style", font_style);
            });
        };
        /**
         * text transform dropdown
         *
         * @param $thisClass : this
         *
         * @return void
         */
        Typography.prototype._textTransformDropdown = function ($thisClass) {
            this.$_text_transform_dropdown.select2({
                allowClear: true,
            });
            this.$_text_transform_dropdown.on("change", function () {
                var text_transform = String($(this).val());
                //reset css
                $thisClass.$_preview_area.css("font-variant", "");
                $thisClass.$_preview_area.css("text-transform", "");
                if (text_transform === "small-caps") {
                    $thisClass.$_preview_area.css("font-variant", text_transform);
                }
                else {
                    $thisClass.$_preview_area.css("text-transform", text_transform);
                }
            });
        };
        /**
         * text decoration dropdown
         *
         * @param $thisClass : this
         *
         * @return void
         */
        Typography.prototype._textDecorationDropdown = function ($thisClass) {
            this.$_text_decoration_dropdown.select2({
                allowClear: true,
            });
            this.$_text_decoration_dropdown.on("change", function () {
                var text_decoration = String($(this).val());
                $thisClass.$_preview_area.css("text-decoration", text_decoration);
            });
        };
        /**
         * populate font weight dropdown
         *
         * @param $thisClass : this
         * @param $selected_font : JQuery<HTMLElement>
         * @param font_weights : string
         *
         * @return void
         */
        Typography.prototype._populateFontWeightDropdown = function ($thisClass, $selected_font, font_weights) {
            $thisClass.$_font_weight_dropdown.empty();
            if (font_weights.length > 0) {
                $thisClass.$_font_weight_dropdown.append("<option></option>");
                $.each(JSON.parse(font_weights), function (weight_value, weight_value_label) {
                    $thisClass.$_font_weight_dropdown.append('<option value="' + weight_value + '">' + weight_value_label + "</option>");
                });
            }
        };
        /**
         * populate font subsets dropdown
         *
         * @param $thisClass : this
         * @param font_subsets : JQuery<HTMLElement>
         *
         * @return void
         */
        Typography.prototype._populateFontSubsetsDropdown = function ($thisClass, font_subsets) {
            $thisClass.$_font_subsets_dropdown.empty();
            if (font_subsets.length > 0) {
                $thisClass.$_font_subsets_dropdown.append("<option></option>");
                $.each(JSON.parse(font_subsets), function (index, subset) {
                    $thisClass.$_font_subsets_dropdown.append('<option value="' + subset + '">' + subset + "</option>");
                });
            }
        };
        /**
         * set header font from saved values
         *
         * @param $thisClass : this
         *
         * @return void
         */
        Typography.prototype._setHeaderFontFromSavedValues = function ($thisClass) {
            var saved_values = this.$_fonts_dropdown.attr("data-saved-values");
            //set the font link in header with the saved values if a Google font
            if (saved_values.length > 0) {
                var saved_vals = JSON.parse(saved_values);
                if (saved_vals["font_type"] === "google") {
                    $thisClass._buildFontLink(saved_vals["font"], saved_vals["weight"]);
                }
            }
        };
        /**
         * set style tag CSS for the Divi fonts
         *
         * @param $thisClass : this
         * @param font_family : string
         * @param font_path : string
         *
         * @return void
         */
        Typography.prototype._setStyleTagCSS = function ($thisClass, font_family, font_path) {
            var $style_container = $thisClass.$_typography.find("#dht-custom-style").children("style");
            $style_container.empty().append("@font-face {font-family: " + font_family + ";src: url(" + font_path + ") format('truetype');}");
        };
        /**
         * build Google font link
         *
         * @param font_family : string
         * @param font_weight : string
         *
         * @return void
         */
        Typography.prototype._buildFontLink = function (font_family, font_weight) {
            if (font_weight === void 0) { font_weight = ""; }
            var fontLink = "";
            if (font_weight.length > 0) {
                fontLink = "https://fonts.googleapis.com/css?family=" + font_family.replace(/\s+/g, "+") + ":" + font_weight;
                $('<link href="' + fontLink + '" rel="stylesheet">').appendTo("head");
            }
            else {
                fontLink = "https://fonts.googleapis.com/css?family=" + font_family.replace(/\s+/g, "+");
            }
            $('<link href="' + fontLink + '" rel="stylesheet">').appendTo("head");
        };
        return Typography;
    }());
    //init each typography option
    $(".dht-field-child-typography").each(function () {
        new Typography($(this));
    });
})((jquery__WEBPACK_IMPORTED_MODULE_0___default()));

})();

/******/ })()
;
//# sourceMappingURL=typography-script.js.map