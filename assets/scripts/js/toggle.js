"use strict";(self.webpackChunkdevhunters_fw=self.webpackChunkdevhunters_fw||[]).push([[6085],{8160:(t,e,i)=>{i.r(e);var n=i(1669);!function(t){var e=function(){function e(t){this.$_toggle=t,this._initToggle()}return e.prototype._initToggle=function(){var e=this;this.$_toggle.off("click",".dht-toggle").on("click",".dht-toggle",(function(){var i=t(this),n=i.children("input");if(i.hasClass("dht-slider-on")){i.removeClass("dht-slider-on").addClass("dht-slider-off");var l=i.children(".dht-slider").children(".dht-slider-no").attr("data-value");n.val(l)}else i.removeClass("dht-slider-off").addClass("dht-slider-on"),l=i.children(".dht-slider").children(".dht-slider-yes").attr("data-value"),n.val(l);e._showHideOptions(i)}))},e.prototype._showHideOptions=function(e){var i=e.children("input").attr("value");e.siblings(".dht-toggle-content").each((function(){var e=t(this);e.removeClass("dht-toggle-show"),e.attr("data-toggle-value")===i&&e.addClass("dht-toggle-show")}))},e}();function i(){t(".dht-field-wrapper .dht-field-child-toggle").each((function(){new e(t(this))}))}t((function(){i()})),t(document).on("dht_toggleAjaxComplete",(function(){i()}))}(i.n(n)())}}]);
//# sourceMappingURL=toggle.js.map