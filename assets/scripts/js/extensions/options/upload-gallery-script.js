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
/*!****************************************************************!*\
  !*** ./assets/scripts/ts/extensions/options/upload-gallery.ts ***!
  \****************************************************************/
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var jquery__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! jquery */ "jquery");
/* harmony import */ var jquery__WEBPACK_IMPORTED_MODULE_0___default = /*#__PURE__*/__webpack_require__.n(jquery__WEBPACK_IMPORTED_MODULE_0__);

(function ($) {
    "use strict";
    var $dht_field_wrapper = $(".dht-field-wrapper");
    $dht_field_wrapper.on("click", ".dht-field-child-upload .dht-upload-gallery-button", function () {
        var $this = jquery__WEBPACK_IMPORTED_MODULE_0___default()(this);
        var $hidden_input = $this.siblings(".dht-upload-gallery-hidden");
        var $media_text = $this.attr("data-media-text");
        //open WP media popup
        var custom_uploader = wp.media({
            title: $media_text,
            button: {
                text: $media_text,
            },
            library: { type: "image" },
            multiple: true,
        });
        //do manipulations after inserting the images
        custom_uploader.on("select", function () {
            var $gallery_div = $this.siblings(".dht-gallery-group");
            $gallery_div.empty();
            var attachments = custom_uploader.state().get("selection").toJSON();
            var image_ids = [];
            var gallery = [];
            for (var i = 0; i < attachments.length; i++) {
                image_ids.push(attachments[i].id);
                gallery.push({ id: attachments[i].id, url: attachments[i].url });
            }
            //add attachment ids to the hidden input
            $hidden_input.val(image_ids.join(","));
            //insert selected images - create a gallery view
            gallery.forEach(function (image) {
                $gallery_div.append('<span class="dht-img-remove">' +
                    '<span class="dht-img-remove-icon"></span>' +
                    '<img data-id="' +
                    image.id +
                    '" src="' +
                    image.url +
                    '" alt="" width="100" height="100" />' +
                    "</span>");
            });
        });
        custom_uploader.open();
        //open the WP media popup with a preselected attachment ids if exist
        var $hidden_input_val = $hidden_input.val();
        if ($hidden_input_val.length > 0) {
            //get hidden input ids
            var gallery_ids = $hidden_input_val.split(",");
            //set images as selected in the media popup
            var selection_1 = custom_uploader.state().get("selection");
            gallery_ids.forEach(function (id) {
                var attachment = wp.media.attachment(id);
                attachment.fetch();
                selection_1.add(attachment ? [attachment] : []);
            });
        }
    });
    //remove image from gallery and from the hidden input
    $dht_field_wrapper.on("click", ".dht-field-child-upload .dht-gallery-group .dht-img-remove-icon", function () {
        //get the removed image id
        var $hidden_input = $(this).parents(".dht-gallery-group").siblings(".dht-upload-gallery-hidden");
        var image_id = $(this).siblings("img").attr("data-id");
        //get input hidden ids
        var saved_ids = $hidden_input.val();
        if (typeof saved_ids === "string") {
            saved_ids = saved_ids.split(",");
            //remove id from saved ids array and add the new array to the hidden input
            if (saved_ids.indexOf(image_id) > -1) {
                saved_ids.splice(saved_ids.indexOf(image_id), 1);
                //$hidden_input
                $hidden_input.val(saved_ids.join(","));
            }
        }
        //remove the image container
        $(this).parent(".dht-img-remove").remove();
    });
})((jquery__WEBPACK_IMPORTED_MODULE_0___default()));

})();

/******/ })()
;
//# sourceMappingURL=upload-gallery-script.js.map