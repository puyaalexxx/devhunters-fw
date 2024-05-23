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
/*!***************************************************************!*\
  !*** ./assets/scripts/ts/extensions/options/multi-options.ts ***!
  \***************************************************************/
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var jquery__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! jquery */ "jquery");
/* harmony import */ var jquery__WEBPACK_IMPORTED_MODULE_0___default = /*#__PURE__*/__webpack_require__.n(jquery__WEBPACK_IMPORTED_MODULE_0__);

(function ($) {
    "use strict";
    var MultiOptions = /** @class */ (function () {
        function MultiOptions($multioptions) {
            //multioptions reference
            this.$_multioptions = $multioptions;
            this.$_dropdown = this.$_multioptions.children(".dht-multioptions");
            this.$_input_text = this.$_dropdown.attr("data-input-text");
            this.$_selected_values = this.$_dropdown.attr("data-values");
            this.$_minimumInputLength = +this.$_dropdown.attr("data-minimumInputLength");
            //set selected values
            this._setSelectedValues();
            //if ajax is enabled
            this._useAjax();
            // Bind focus event to input field
            this._bindInputFocus();
        }
        /**
         * set selected values
         *
         * @return void
         */
        MultiOptions.prototype._setSelectedValues = function () {
            if (this.$_selected_values.length > 0) {
                var predefined_values = this.$_selected_values.split(",");
                this.$_dropdown.val(predefined_values);
            }
        };
        /**
         * Bind focus event to input field
         *
         * @return void
         */
        MultiOptions.prototype._bindInputFocus = function () {
            this.$_dropdown.on("focus", function () {
                // Reset the input field value
                $(this).val("");
            });
        };
        /**
         * ajax functionality
         *
         * @return void
         */
        MultiOptions.prototype._useAjax = function () {
            if (this.$_dropdown.attr("data-ajax-enabled") === "yes") {
                //get ajax action function to retrieve the dropdown values on search
                var ajax_action_1 = this.$_dropdown.attr("data-ajax-action");
                //if no ajax action provided, skip ajax
                if (ajax_action_1.length === 0) {
                    console.error("No ajax action function provided");
                    return false;
                }
                // Initialize Select2 with AJAX
                this.$_dropdown.select2({
                    minimumInputLength: this.$_minimumInputLength, // Set minimum input length to 1 to trigger AJAX after typing
                    placeholder: this.$_input_text, // Placeholder text
                    allowClear: true, // Allow clearing the selection
                    ajax: {
                        //@ts-ignore
                        url: dht_multioptions_ajax.ajax_url,
                        dataType: "json",
                        delay: 250,
                        type: "POST",
                        data: function (params) {
                            return {
                                action: ajax_action_1,
                                //text typed in the input field
                                term: params.term,
                            };
                        },
                        processResults: function (data) {
                            console.log(data);
                            return {
                                results: data,
                            };
                        },
                        cache: true,
                    },
                });
            }
            //simple multioptions drodpwon without ajax
            else {
                this.$_dropdown.select2({
                    placeholder: this.$_input_text, // Placeholder text
                    minimumInputLength: this.$_minimumInputLength,
                    allowClear: true, // Allow clearing the selection
                });
            }
            return true;
        };
        return MultiOptions;
    }());
    //init each multioptions option
    $(".dht-field-child-multioptions").each(function () {
        new MultiOptions($(this));
    });
})((jquery__WEBPACK_IMPORTED_MODULE_0___default()));

})();

/******/ })()
;
//# sourceMappingURL=multi-options-script.js.map