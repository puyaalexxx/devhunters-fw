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
/*!*********************************************************************!*\
  !*** ./assets/scripts/ts/extensions/options/containers/sidemenu.ts ***!
  \*********************************************************************/
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var jquery__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! jquery */ "jquery");
/* harmony import */ var jquery__WEBPACK_IMPORTED_MODULE_0___default = /*#__PURE__*/__webpack_require__.n(jquery__WEBPACK_IMPORTED_MODULE_0__);

(function ($) {
    "use strict";
    var SideMenu = /** @class */ (function () {
        function SideMenu() {
            //init sidemenu
            this._initSideMenu();
        }
        /**
         * init sidemenu
         *
         * @return void
         */
        SideMenu.prototype._initSideMenu = function () {
            this._dropownMenuHover();
            this._addRemoveActiveClass();
            this._addDropdownMenuDiv();
            this._enableTabsFunctionality();
        };
        /**
         * show hide dropdown menu on hover
         *
         * @return void
         */
        SideMenu.prototype._dropownMenuHover = function () {
            $("#dht-cosidebar .dht-cosidebar-header > ul > li").on({
                mouseenter: function () {
                    if (!$(".dht-cosidebar-sub-menu:visible", this).length) {
                        $(".dht-cosidebar-dropdown-menu", this).show();
                        $(this).addClass("hover");
                    }
                },
                mouseleave: function () {
                    $(".dht-cosidebar-dropdown-menu", this).hide();
                    $(this).removeClass("hover");
                },
            });
        };
        /**
         * add remove menu item active class
         *
         * @return void
         */
        SideMenu.prototype._addRemoveActiveClass = function () {
            $("[dropdown] >li").hover(function () {
                $("ul", this).show();
                $(this).addClass("dht-cosidebar-active");
            }, function () {
                $("ul", this).hide();
                $(this).removeClass("dht-cosidebar-active");
            });
        };
        /**
         * add dropdown menu div that is shown on hover
         *
         * @return void
         */
        SideMenu.prototype._addDropdownMenuDiv = function () {
            $("#dht-cosidebar .dht-cosidebar-header >ul >li").each(function () {
                if ($(".dht-cosidebar-sub-menu", this).length) {
                    var html = $(".dht-cosidebar-sub-menu", this).html();
                    $(this).append('<ul dropdown class="dht-cosidebar-dropdown-menu">' + html + "</ul>");
                }
            });
        };
        /**
         * make the side menu as tabs
         *
         * @return void
         */
        SideMenu.prototype._enableTabsFunctionality = function () {
            //made the menus work like tabs
            $("#dht-cosidebar.dht-cosidebar-tabs .dht-cosidebar-header ul li > a, " +
                "#dht-cosidebar.dht-cosidebar-tabs .dht-cosidebar-header ul li .dht-cosidebar-sub-menu a").on("click", function (e) {
                e.preventDefault(); // Prevent default anchor behavior
                var $this = $(this);
                var $parent = $this.parents("#dht-cosidebar");
                var $header_area = $this.parents(".dht-cosidebar-header");
                // Get the target tab ID from the href attribute
                var tabId = $this.attr("href");
                // Hide all tab contents and remove 'dht-cosidebar-active' class from all tabs
                $header_area.children("ul").find("li").removeClass("dht-cosidebar-active");
                $parent.children(".dht-cosidebar-body").children(".dht-cosidebar-content").removeClass("dht-cosidebar-active");
                // content area made active
                $(tabId).addClass("dht-cosidebar-active");
                //make the li tag active
                $this.parent().addClass("dht-cosidebar-active");
                //if it is a parent menu item, or it is a sub menu item
                if ($this.siblings(".dht-cosidebar-sub-menu").length > 0 || $this.parents(".dht-cosidebar-sub-menu").length > 0) {
                    //if it is a parent menu item only
                    if ($this.siblings(".dht-cosidebar-sub-menu").length > 0) {
                        // get first submenu item id
                        var firstSubmenuTabId = $this.siblings(".dht-cosidebar-sub-menu").children("li:first").children("a").attr("href");
                        // first submenu item content area made active
                        $(firstSubmenuTabId).addClass("dht-cosidebar-active");
                    }
                    //first item from submenu
                    $this.siblings(".dht-cosidebar-sub-menu").children("li:first").addClass("dht-cosidebar-active");
                    //make the parent li tag active from the submenu link
                    $this.parents("li").addClass("dht-cosidebar-active");
                }
                //if a dropdown item from the hover was clicked
                if ($this.parents(".dht-cosidebar-dropdown-menu").length > 0) {
                    //get clicked li tag number
                    var li_number = $this.parent().index();
                    //if link clicked from the hover dropdown, we need to make the dht-cosidebar-sub-menu active instead
                    $this
                        .parents(".dht-cosidebar-dropdown-menu")
                        .siblings(".dht-cosidebar-sub-menu")
                        .children("li:eq(" + li_number + ")")
                        .addClass("dht-cosidebar-active");
                    //make the parent li tag active from the submenu link
                    $this.parents("li").addClass("dht-cosidebar-active");
                    $this.parents(".dht-cosidebar-dropdown-menu").hide();
                }
            });
        };
        return SideMenu;
    }());
    $(function () {
        //init sidemenu
        new SideMenu();
    });
})((jquery__WEBPACK_IMPORTED_MODULE_0___default()));

})();

/******/ })()
;
//# sourceMappingURL=sidemenu-js.js.map