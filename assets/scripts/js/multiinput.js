"use strict";(self.webpackChunkdevhunters_fw=self.webpackChunkdevhunters_fw||[]).push([[7266],{3837:(t,i,n)=>{n.r(i);var e=n(1669);!function(t){var i=function(){function i(t){this.$_multiinput=t,this._addInput(),this._removeInput()}return i.prototype._addInput=function(){this.$_multiinput.off("click",".dht-multiinput-add").on("click",".dht-multiinput-add",(function(){var i=t(this),n=+i.attr("data-limit");if(i.parents(".dht-field-child-multiinput").children(".dht-multiinput-child-wrapper").length>=n)return confirm(t(this).attr("data-add-text")),!1;var e=i.prev(".dht-multiinput-child-wrapper").clone();e.children("input").val(""),e.insertBefore(i)}))},i.prototype._removeInput=function(){this.$_multiinput.off("click",".dht-multiinput-remove").on("click",".dht-multiinput-remove",(function(){var i=t(this);1!==i.parents(".dht-field-child-wrapper").children(".dht-multiinput-child-wrapper").length?i.parent(".dht-multiinput-child-wrapper").remove():confirm(t(this).attr("data-remove-text"))}))},i}();function n(){t(".dht-field-wrapper .dht-field-child-multiinput").each((function(){new i(t(this))}))}t((function(){n()})),t(document).on("dht_multiInputAjaxComplete",(function(){n()}))}(n.n(e)())}}]);
//# sourceMappingURL=multiinput.js.map