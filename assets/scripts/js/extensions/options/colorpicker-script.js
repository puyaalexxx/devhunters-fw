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
/*!*************************************************************!*\
  !*** ./assets/scripts/ts/extensions/options/colorpicker.ts ***!
  \*************************************************************/
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var jquery__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! jquery */ "jquery");
/* harmony import */ var jquery__WEBPACK_IMPORTED_MODULE_0___default = /*#__PURE__*/__webpack_require__.n(jquery__WEBPACK_IMPORTED_MODULE_0__);

(function ($) {
    "use strict";
    var ColorPicker = /** @class */ (function () {
        function ColorPicker($colorpicker) {
            this._wpColorPickerArgs = {};
            //colorpicker reference
            this.$_colorpicker = $colorpicker;
            //get default palette of colors
            this._palette = $colorpicker.attr("data-palette");
            //get default button reference
            this.$_default_btn = $colorpicker.parents(".dht-field-child-wrapper").find(".dht-default-color-btn");
            //set the default colorpicker args
            this._setDefaultColorPickerArgs();
            //reset the color picker color to its default value
            this._resetColoPickerValue();
        }
        /**
         * set the default colorpicker args
         *
         * @return void
         */
        ColorPicker.prototype._setDefaultColorPickerArgs = function () {
            if (this._palette.length !== 0) {
                this._wpColorPickerArgs = {
                    palettes: JSON.parse(this._palette),
                };
            }
            this.$_colorpicker.wpColorPicker(this._wpColorPickerArgs);
        };
        /**
         * reset the color picker color to its default value
         *
         * @return void
         */
        ColorPicker.prototype._resetColoPickerValue = function () {
            var _this = this;
            //default button to reset the color picker color to its default value
            this.$_default_btn.insertAfter(this.$_colorpicker.parent("label"));
            //reset the color picker color to its default value
            this.$_default_btn.on("click", function () {
                var $this = $(_this);
                //get option default color value
                var defaultColor = _this.$_default_btn.attr("data-default-value");
                _this.$_colorpicker.wpColorPicker("color", defaultColor);
            });
        };
        return ColorPicker;
    }());
    //init each colorpicker option
    $(".dht-field-child-wrapper .dht-colorpicker").each(function () {
        new ColorPicker($(this));
    });
})((jquery__WEBPACK_IMPORTED_MODULE_0___default()));

})();

/******/ })()
;
//# sourceMappingURL=colorpicker-script.js.map