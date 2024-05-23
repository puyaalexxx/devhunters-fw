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
  !*** ./assets/scripts/ts/extensions/options/rangeslider.ts ***!
  \*************************************************************/
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var jquery__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! jquery */ "jquery");
/* harmony import */ var jquery__WEBPACK_IMPORTED_MODULE_0___default = /*#__PURE__*/__webpack_require__.n(jquery__WEBPACK_IMPORTED_MODULE_0__);

(function ($) {
    "use strict";
    var RangeSlider = /** @class */ (function () {
        function RangeSlider($rangeSlider) {
            //datepicker reference
            this.$_rangeSlider = $rangeSlider;
            this.$_sliderInput = this.$_rangeSlider.find(".dht-slider-slider");
            this.$_isRange = this.$_sliderInput.attr("data-range");
            this.$_min = +this.$_sliderInput.attr("data-min");
            this.$_max = +this.$_sliderInput.attr("data-max");
            this.$_sliderValues = this.$_sliderInput.attr("data-values");
            if (this.$_isRange === "yes") {
                this._initRangeSlider();
            }
            else {
                this._initSlider();
            }
        }
        /**
         * init range slider
         *
         * @return void
         */
        RangeSlider.prototype._initRangeSlider = function () {
            var $input1 = this.$_sliderInput.siblings(".dht-slider-group").children(".dht-range-slider-1");
            var $input2 = this.$_sliderInput.siblings(".dht-slider-group").children(".dht-range-slider-2");
            var range_values = this.$_sliderValues.length > 0 ? this.$_sliderValues.split(",").map(Number) : [];
            this.$_sliderInput.slider({
                range: true,
                min: this.$_min,
                max: this.$_max,
                values: range_values,
                slide: function (event, ui) {
                    if (ui.values !== undefined) {
                        $input1.val(ui.values[0]);
                        $input2.val(ui.values[1]);
                    }
                },
            });
            $input1.val(this.$_sliderInput.slider("values", 0));
            $input2.val(this.$_sliderInput.slider("values", 1));
        };
        /**
         * init slider
         *
         * @return void
         */
        RangeSlider.prototype._initSlider = function () {
            var $input = this.$_sliderInput.siblings(".dht-slider");
            this.$_sliderInput.slider({
                range: "min",
                value: +this.$_sliderValues,
                min: this.$_min,
                max: this.$_max,
                slide: function (event, ui) {
                    $input.val(ui.value);
                },
            });
            $input.val(this.$_sliderInput.slider("value"));
        };
        return RangeSlider;
    }());
    //init each range slider option
    $(".dht-field-child-rangeslider").each(function () {
        new RangeSlider($(this));
    });
})((jquery__WEBPACK_IMPORTED_MODULE_0___default()));

})();

/******/ })()
;
//# sourceMappingURL=rangeslider-script.js.map