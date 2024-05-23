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
/*!**************************************************************!*\
  !*** ./assets/scripts/ts/extensions/options/upload-image.ts ***!
  \**************************************************************/
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var jquery__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! jquery */ "jquery");
/* harmony import */ var jquery__WEBPACK_IMPORTED_MODULE_0___default = /*#__PURE__*/__webpack_require__.n(jquery__WEBPACK_IMPORTED_MODULE_0__);

(function ($) {
    "use strict";
    var UploadImage = /** @class */ (function () {
        function UploadImage($uploadImage) {
            //upload image reference
            this.$_uploadImage = $uploadImage;
            //upload image on click
            this._uploadImage();
            //remove image when input is cleared
            this._removeImageOnInput();
        }
        /**
         * upload image
         *
         * @return void
         */
        UploadImage.prototype._uploadImage = function () {
            //this class reference
            var $thisClass = this;
            this.$_uploadImage.on("click", ".dht-upload-image-button", function () {
                var $this = $(this);
                var $hidden_input = $(".dht-upload-hidden");
                var $media_text = $this.attr("data-media-text");
                //open WP media popup
                var custom_uploader = wp.media({
                    title: $media_text,
                    button: {
                        text: $media_text,
                    },
                    library: { type: "image" },
                    multiple: false,
                });
                custom_uploader.on("select", function () {
                    var $image_input = $this.siblings(".dht-upload");
                    //remove image preview before proceeding
                    $image_input.siblings("img").remove();
                    var attachment = custom_uploader.state().get("selection").first().toJSON();
                    //add image URL
                    $image_input.val(attachment.url);
                    $image_input.attr("value", attachment.url);
                    //add attachment ids to the hidden input
                    $hidden_input.val(attachment.id);
                    //display a preview image with the selected image url
                    $image_input.before('<img src="' + attachment.url + '" width="100" height="100"  alt=""/>');
                });
                custom_uploader.open();
                //open the WP media popup with a preselected attachment id if exist
                $thisClass._preSelectImages($hidden_input, custom_uploader);
            });
        };
        /**
         * remove image when input is cleared
         *
         * @return void
         */
        UploadImage.prototype._removeImageOnInput = function () {
            this.$_uploadImage.on("input", ".dht-upload", function () {
                var $this = $(this);
                // Check if the input field is empty and remove the image id and URL
                if ($this.val() === "") {
                    $this.siblings("img").remove();
                    $this.siblings(".dht-upload-hidden").val("");
                    $this.attr("value", "");
                }
                //change image when adding a new link
                if ($this.val().length > 0) {
                    $this.siblings("img").remove();
                    $this.before('<img src="' + $this.val() + '" width="100" height="100"  alt=""/>');
                    $this.attr("value", $this.val());
                }
            });
        };
        /**
         * preselect selected image in Media popup
         *
         * @param $hidden_input : JQuery<HTMLElement>
         * @param custom_uploader : any
         *
         * @return void
         */
        UploadImage.prototype._preSelectImages = function ($hidden_input, custom_uploader) {
            var $hidden_input_val = +$hidden_input.val();
            if ($hidden_input_val > 0) {
                custom_uploader.state().get("selection").add(wp.media.attachment($hidden_input.val()));
            }
        };
        return UploadImage;
    }());
    //init each upload image button option
    $(".dht-field-child-upload-image").each(function () {
        new UploadImage($(this));
    });
})((jquery__WEBPACK_IMPORTED_MODULE_0___default()));

})();

/******/ })()
;
//# sourceMappingURL=upload-image-script.js.map