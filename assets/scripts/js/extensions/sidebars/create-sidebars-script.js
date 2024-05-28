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
/*!******************************************************************!*\
  !*** ./assets/scripts/ts/extensions/sidebars/create-sidebars.ts ***!
  \******************************************************************/
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var jquery__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! jquery */ "jquery");
/* harmony import */ var jquery__WEBPACK_IMPORTED_MODULE_0___default = /*#__PURE__*/__webpack_require__.n(jquery__WEBPACK_IMPORTED_MODULE_0__);

(function ($) {
    "use strict";
    /**
     * Class used to create and delete custom sidebars
     */
    var DhtWidgetAreas = /** @class */ (function () {
        function DhtWidgetAreas() {
            //where to attach widgets area form
            this._widgetArea = $("#widgets-right");
            //my form id
            this._widgetTemplate = $("#dht-wrap");
            // custom sidebars
            this._customSidebar = this._widgetArea.find(".sidebar-dht-custom");
            //delete area
            this._deleteButton = $(".dht-wrap-delete");
            this._addFormHtml();
            this._addDelButton();
            this._bindEvents();
            this.deleteSidebarAjax();
        }
        /**
         * Adding the widget area form below sidebars area
         *
         * @return void
         */
        DhtWidgetAreas.prototype._addFormHtml = function () {
            this._widgetArea.after(this._widgetTemplate);
            this._widgetTemplate.show();
        };
        /**
         * Adding delete area to each added sidebar
         *
         * @return void
         */
        DhtWidgetAreas.prototype._addDelButton = function () {
            var $this = this;
            this._customSidebar.each(function () {
                var deleteForm = $this._deleteButton.clone();
                jquery__WEBPACK_IMPORTED_MODULE_0___default()(this).find(".widgets-sortables").append(deleteForm);
                deleteForm.show();
            });
        };
        /**
         * Show confirm / cancel buttons and vice versa
         *
         * @return void
         */
        DhtWidgetAreas.prototype._bindEvents = function () {
            //display confirm / cancel buttons
            this._customSidebar.find(".dht-widget-area-delete").on("click", function () {
                var parent = $(this).parents(".dht-wrap-delete");
                parent.find(".dht-widget-area-delete-cancel, .dht-widget-area-delete-confirm").show();
                $(this).hide();
            });
            //display delete button
            this._customSidebar.find(".dht-widget-area-delete-cancel").on("click", function () {
                var parent = $(this).parents(".dht-wrap-delete");
                parent.find(".dht-widget-area-delete").show();
                $(this).hide();
                $(this).siblings(".dht-widget-area-delete-confirm").hide();
            });
        };
        DhtWidgetAreas.prototype.deleteSidebarAjax = function () {
            //delete sidebar on clicking confirm button
            this._customSidebar.find(".dht-widget-area-delete-confirm").on("click", function () {
                var sidebar_container = $(this).parents(".sidebar-dht-custom");
                var spinner = sidebar_container.find(".sidebar-name .spinner");
                //get sidebar id
                var sidebar_id = sidebar_container.children(".widgets-sortables").attr("id");
                $.ajax({
                    //@ts-ignore
                    url: dht_remove_sidebar_object.ajax_url,
                    type: "POST",
                    data: {
                        action: "deleteWidgetArea", // The name of your AJAX action
                        data: { sidebar_id: sidebar_id },
                    },
                    beforeSend: function () {
                        //show loading spinner
                        spinner.css("visibility", "visible");
                    },
                    success: function (response) {
                        // Refresh the current page
                        if (response.success) {
                            location.reload();
                        }
                        else {
                            console.log("Ajax Response", response);
                        }
                    },
                    error: function (error) {
                        console.error("AJAX error:", error);
                    },
                });
                return false;
            });
        };
        return DhtWidgetAreas;
    }());
    $(function () {
        new DhtWidgetAreas();
    });
})((jquery__WEBPACK_IMPORTED_MODULE_0___default()));

})();

/******/ })()
;
//# sourceMappingURL=create-sidebars-script.js.map