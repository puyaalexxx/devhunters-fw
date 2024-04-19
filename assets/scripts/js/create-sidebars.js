/*
 * ATTENTION: The "eval" devtool has been used (maybe by default in mode: "development").
 * This devtool is neither made for production nor for readable output files.
 * It uses "eval()" calls to create a separate source file in the browser devtools.
 * If you are trying to read the output file, select a different devtool (https://webpack.js.org/configuration/devtool/)
 * or disable the default devtool with "devtool: false".
 * If you are looking for production-ready output files, see mode: "production" (https://webpack.js.org/configuration/mode/).
 */
/******/ (() => { // webpackBootstrap
/******/ 	"use strict";
/******/ 	var __webpack_modules__ = ({

/***/ "./assets/scripts/ts/create-sidebars.ts":
/*!**********************************************!*\
  !*** ./assets/scripts/ts/create-sidebars.ts ***!
  \**********************************************/
/***/ ((__unused_webpack_module, __webpack_exports__, __webpack_require__) => {

eval("__webpack_require__.r(__webpack_exports__);\n/* harmony import */ var jquery__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! jquery */ \"jquery\");\n/* harmony import */ var jquery__WEBPACK_IMPORTED_MODULE_0___default = /*#__PURE__*/__webpack_require__.n(jquery__WEBPACK_IMPORTED_MODULE_0__);\n\n//place the sidebar form below sidebars area\n(function ($) {\n    'use strict';\n    /**\n     * Class used to create and delete custom sidebars\n     */\n    var DhtWidgetAreas = /** @class */ (function () {\n        function DhtWidgetAreas() {\n            //where to attach widgets area form\n            this._widgetArea = $('#widgets-right');\n            //my form id\n            this._widgetTemplate = $('#dht-wrap');\n            // custom sidebars\n            this._customSidebar = this._widgetArea.find('.sidebar-dht-custom');\n            //delete area\n            this._deleteButton = $('.dht-wrap-delete');\n            this._addFormHtml();\n            this._addDelButton();\n            this._bindEvents();\n            this.deleteSidebarAjax();\n        }\n        /**\n         * Adding the widget area form below sidebars area\n         *\n         * @return void\n         */\n        DhtWidgetAreas.prototype._addFormHtml = function () {\n            this._widgetArea.after(this._widgetTemplate);\n            this._widgetTemplate.show();\n        };\n        /**\n         * Adding delete area to each added sidebar\n         *\n         * @return void\n         */\n        DhtWidgetAreas.prototype._addDelButton = function () {\n            var $this = this;\n            this._customSidebar.each(function () {\n                var deleteForm = $this._deleteButton.clone();\n                jquery__WEBPACK_IMPORTED_MODULE_0___default()(this).find('.widgets-sortables').append(deleteForm);\n                deleteForm.show();\n            });\n        };\n        /**\n         * Show confirm / cancel buttons and vice versa\n         *\n         * @return void\n         */\n        DhtWidgetAreas.prototype._bindEvents = function () {\n            //display confirm / cancel buttons\n            this._customSidebar.find('.dht-widget-area-delete').on('click', function () {\n                var parent = $(this).parents('.dht-wrap-delete');\n                parent.find('.dht-widget-area-delete-cancel, .dht-widget-area-delete-confirm').show();\n                $(this).hide();\n            });\n            //display delete button\n            this._customSidebar.find('.dht-widget-area-delete-cancel').on('click', function () {\n                var parent = $(this).parents('.dht-wrap-delete');\n                parent.find('.dht-widget-area-delete').show();\n                $(this).hide();\n                $(this).siblings('.dht-widget-area-delete-confirm').hide();\n            });\n        };\n        DhtWidgetAreas.prototype.deleteSidebarAjax = function () {\n            //delete sidebar on clicking confirm button\n            this._customSidebar.find('.dht-widget-area-delete-confirm').on('click', function () {\n                var sidebar_container = $(this).parents('.sidebar-dht-custom');\n                var spinner = sidebar_container.find('.sidebar-name .spinner');\n                //get sidebar id\n                var sidebar_id = sidebar_container.children('.widgets-sortables').attr('id');\n                $.ajax({\n                    //@ts-ignore\n                    url: dht_remove_sidebar_object.ajax_url,\n                    type: 'POST',\n                    data: {\n                        action: 'deleteWidgetArea', // The name of your AJAX action\n                        data: { 'sidebar_id': sidebar_id }\n                    },\n                    beforeSend: function () {\n                        //show loading spinner\n                        spinner.css(\"visibility\", \"visible\");\n                    },\n                    success: function (response) {\n                        // Refresh the current page\n                        if (response.success) {\n                            location.reload();\n                        }\n                        else {\n                            console.log('Ajax Response', response);\n                        }\n                    },\n                    error: function (error) {\n                        console.error('AJAX error:', error);\n                    }\n                });\n                return false;\n            });\n        };\n        return DhtWidgetAreas;\n    }());\n    $(function () {\n        new DhtWidgetAreas();\n    });\n})((jquery__WEBPACK_IMPORTED_MODULE_0___default()));\n\n\n//# sourceURL=webpack://devhunters-fw/./assets/scripts/ts/create-sidebars.ts?");

/***/ }),

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
/******/ 	
/******/ 	// startup
/******/ 	// Load entry module and return exports
/******/ 	// This entry module can't be inlined because the eval devtool is used.
/******/ 	var __webpack_exports__ = __webpack_require__("./assets/scripts/ts/create-sidebars.ts");
/******/ 	
/******/ })()
;