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
  !*** ./assets/scripts/ts/extensions/options/options/icon.ts ***!
  \**************************************************************/
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var jquery__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! jquery */ "jquery");
/* harmony import */ var jquery__WEBPACK_IMPORTED_MODULE_0___default = /*#__PURE__*/__webpack_require__.n(jquery__WEBPACK_IMPORTED_MODULE_0__);

(function ($) {
    "use strict";
    var Icon = /** @class */ (function () {
        function Icon() {
            //call ajax with default icons loaded (in our case - dashicons)
            this._onPopupOpen();
            // call ajax with icon type selected
            this._callAjaxWithSelectedIcon();
            //add selected icon on preview area
            this._addSelectedIconOnPreviewArea();
            //remove selected icon
            this._removeSelectedIcon();
            //search icons
            this._searchIcon();
        }
        /**
         * when opening the popup call ajax with default icons loaded (in our case - dashicons) or the saved one
         *
         * @return void
         */
        Icon.prototype._onPopupOpen = function () {
            //this class reference
            var $thisClass = this;
            $(".dht-field-wrapper").on("click", ".dht-field-child-icons .dht-thickbox", function () {
                var $this = $(this);
                // icon group area from popup
                var $dht_icons_type_group = $this.siblings(".dht-modal-icons").find(".dht-icons-type-group");
                //clear search input
                $dht_icons_type_group.children(".dht-search-for-icon").val("");
                //get selected icon from input
                var selected_input_val = $this.siblings(".dht-icon-select-value").val();
                //get saved icon values
                var icon_type = "dashicons";
                var icon = "";
                if (selected_input_val.length > 0) {
                    var selected_input_values = JSON.parse(selected_input_val);
                    icon_type = selected_input_values["icon-type"];
                    // @ts-ignore
                    icon = selected_input_values["icon-class"];
                }
                //set icons dropdown with the saved icon type
                $dht_icons_type_group.children(".dht-icons-type").val(icon_type);
                //call ajax
                $thisClass._getIconsViaAjax(icon_type, $dht_icons_type_group, icon);
            });
        };
        /**
         * call ajax with icon type selected
         *
         * @return void
         */
        Icon.prototype._callAjaxWithSelectedIcon = function () {
            //this class reference
            var $thisClass = this;
            $(document).on("change", ".dht-icons-preview-group .dht-icons-type", function () {
                var $this = $(this);
                var icon_type = $this.val();
                if (icon_type.length === 0)
                    return;
                //in case the dropdown is changed quickly - reset it
                $this.parent(".dht-icons-type-group").siblings(".dht-icons-preview").empty();
                $thisClass._getIconsViaAjax(icon_type, $this.parent(".dht-icons-type-group"), "");
            });
        };
        /**
         * add selected icon on preview area
         *
         * @return void
         */
        Icon.prototype._addSelectedIconOnPreviewArea = function () {
            $(document).on("click", "#TB_window .dht-icons-preview i", function () {
                var $this = $(this);
                var icon_class = $this.attr("class");
                var icon_code = $this.attr("data-code");
                var $icons_dropdown = $this.parents(".dht-icons-preview-group").children(".dht-icons-type-group").children(".dht-icons-type");
                //get the popup id
                var popup_id = $this.parents(".dht-icons-preview-group").attr("data-popup-id");
                //add selected icon on preview area and display it
                var popup = $("#" + popup_id);
                popup
                    .siblings(".dht-icon-select-preview")
                    .children("i")
                    .removeAttr("class")
                    .addClass(icon_class)
                    .parent()
                    .addClass("dht-icon-select-preview-show");
                //add selected icon to the hidden input to save it
                popup.siblings(".dht-icon-select-value").val(JSON.stringify({
                    "icon-type": $icons_dropdown.val(),
                    "icon-class": icon_class,
                    "icon-code": icon_code,
                }));
                //show remove button
                popup.siblings(".dht-btn-remove").addClass("dht-btn-show");
                //close popup
                $("#TB_closeWindowButton").trigger("click");
            });
        };
        /**
         * remove selected icon
         *
         * @return void
         */
        Icon.prototype._removeSelectedIcon = function () {
            $(".dht-field-wrapper").on("click", ".dht-field-child-icons .dht-btn-remove", function () {
                var $this = $(this);
                $this.siblings(".dht-icon-select-preview").children("i").removeAttr("class").parent().removeClass("dht-icon-select-preview-show");
                $this.siblings(".dht-icon-select-value").val("");
                $this.removeClass("dht-btn-show");
                return false;
            });
        };
        /**
         * search icon in popup
         *
         * @return void
         */
        Icon.prototype._searchIcon = function () {
            $(document).on("keyup", ".dht-icons-preview-group .dht-search-for-icon", function () {
                var $this = $(this);
                var $popup = $this.parents(".dht-icons-preview-group");
                var searchText = $this.val().toLowerCase();
                // Filter list of icons based on search text
                $popup
                    .children(".dht-icons-preview")
                    .children("i")
                    .each(function () {
                    var $this = $(this);
                    var icon_class = $this.attr("class").toLowerCase();
                    if (icon_class.indexOf(searchText) === -1) {
                        $this.hide();
                    }
                    else {
                        $this.show();
                    }
                });
            });
        };
        Icon.prototype._getIconsViaAjax = function (icon_type, $dht_icons_type_group, icon) {
            //disable icons dropdown to prevent choose several times until ajax is finished
            $dht_icons_type_group.children(".dht-icons-type").prop("disabled", true);
            $.ajax({
                // @ts-ignore
                url: dht_icon_option_ajax.ajax_url,
                type: "POST",
                dataType: "json",
                data: {
                    action: "getOptionIcons", // The name of your AJAX action
                    data: { icon_type: icon_type, icon: icon },
                },
                beforeSend: function () {
                    //show loading spinner
                    $dht_icons_type_group.siblings(".spinner").css("visibility", "visible");
                    // clear popup
                    $dht_icons_type_group.siblings(".dht-icons-preview").empty();
                },
                success: function (response) {
                    if (response.success) {
                        $dht_icons_type_group.siblings(".dht-icons-preview").append(response.data);
                    }
                    else {
                        console.error("Ajax Response", response);
                    }
                },
                error: function (error) {
                    console.error("AJAX error:", error);
                },
                complete: function () {
                    //hide loading spinner
                    $dht_icons_type_group.siblings(".spinner").css("visibility", "hidden");
                    // Re-enable the dropdown after the request is complete
                    $dht_icons_type_group.children(".dht-icons-type").prop("disabled", false);
                },
            });
        };
        return Icon;
    }());
    //init icon option
    $(function () {
        new Icon();
    });
})((jquery__WEBPACK_IMPORTED_MODULE_0___default()));

})();

/******/ })()
;
//# sourceMappingURL=icon-script.js.map