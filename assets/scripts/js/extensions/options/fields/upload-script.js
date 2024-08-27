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
  !*** ./assets/scripts/ts/extensions/options/fields/upload.ts ***!
  \***************************************************************/
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var jquery__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! jquery */ "jquery");
/* harmony import */ var jquery__WEBPACK_IMPORTED_MODULE_0___default = /*#__PURE__*/__webpack_require__.n(jquery__WEBPACK_IMPORTED_MODULE_0__);

(function ($) {
    "use strict";
    var Upload = /** @class */ (function () {
        function Upload($upload) {
            //upload reference
            this.$_upload = $upload;
            //upload item on click
            this._uploadItem();
            //remove item when input is cleared
            this._removeItemOnInput();
        }
        /**
         * upload item
         *
         * @return void
         */
        Upload.prototype._uploadItem = function () {
            //this class reference
            var $thisClass = this;
            this.$_upload.off("click", ".dht-upload-item-button").on("click", ".dht-upload-item-button", function () {
                var $this = $(this);
                var $hidden_input = $this.siblings(".dht-upload-item-hidden");
                var $media_text = $this.attr("data-media-text");
                var $media_type = $this.attr("data-media-type");
                //open WP media popup
                var custom_uploader = wp.media({
                    title: $media_text,
                    button: {
                        text: $media_text,
                    },
                    library: { type: $media_type },
                    multiple: false,
                });
                custom_uploader.off("select").on("select", function () {
                    var attachment = custom_uploader.state().get("selection").first().toJSON();
                    $this.siblings(".dht-upload-item").attr("value", attachment.url);
                    $this.siblings(".dht-upload-item").val(attachment.url);
                    //add attachment id to the hidden input
                    $hidden_input.val(attachment.id);
                });
                custom_uploader.open();
                //open the WP media popup with a preselected attachment id if exist
                $thisClass._preSelectItems($hidden_input, custom_uploader);
            });
        };
        /**
         * remove item when input is cleared
         *
         * @return void
         */
        Upload.prototype._removeItemOnInput = function () {
            this.$_upload.off("input", ".dht-upload-item").on("input", ".dht-upload-item", function () {
                var $this = $(this);
                // Check if the input field is empty and remove the item
                if ($this.val() === "") {
                    $this.siblings(".dht-upload-item-hidden").val("");
                    $this.attr("value", "");
                }
                //change input value when adding a new link
                if ($this.val().length > 0) {
                    $this.attr("value", $this.val());
                }
            });
        };
        /**
         * preselect selected item in Media popup
         *
         * @param $hidden_input : JQuery<HTMLElement>
         * @param custom_uploader : any
         *
         * @return void
         */
        Upload.prototype._preSelectItems = function ($hidden_input, custom_uploader) {
            var $hidden_input_val = +$hidden_input.val();
            if ($hidden_input_val > 0) {
                custom_uploader.state().get("selection").add(wp.media.attachment($hidden_input.val()));
            }
        };
        return Upload;
    }());
    //init each upload button option
    function init() {
        $(".dht-field-child-upload-item").each(function () {
            new Upload($(this));
        });
    }
    // Initialize on page load
    $(function () {
        init();
    });
    // Initialize after AJAX content is loaded
    $(document).on("dht_uploadAjaxComplete", function () {
        init();
    });
})((jquery__WEBPACK_IMPORTED_MODULE_0___default()));

})();

/******/ })()
;
//# sourceMappingURL=upload-script.js.map