"use strict";(self.webpackChunkdevhunters_fw=self.webpackChunkdevhunters_fw||[]).push([[5380],{9755:(t,e,i)=>{i.r(e);var n=i(1669);!function(t){var e=function(){function e(t){this.$_upload=t,this._uploadItem(),this._removeItemOnInput()}return e.prototype._uploadItem=function(){var e=this;this.$_upload.off("click",".dht-upload-item-button").on("click",".dht-upload-item-button",(function(){var i=t(this),n=i.siblings(".dht-upload-item-hidden"),a=i.attr("data-media-text"),o=i.attr("data-media-type"),l=wp.media({title:a,button:{text:a},library:{type:o},multiple:!1});l.off("select").on("select",(function(){var t=l.state().get("selection").first().toJSON();i.siblings(".dht-upload-item").attr("value",t.url),i.siblings(".dht-upload-item").val(t.url),n.val(t.id)})),l.open(),e._preSelectItems(n,l)}))},e.prototype._removeItemOnInput=function(){this.$_upload.off("input",".dht-upload-item").on("input",".dht-upload-item",(function(){var e=t(this);""===e.val()&&(e.siblings(".dht-upload-item-hidden").val(""),e.attr("value","")),e.val().length>0&&e.attr("value",e.val())}))},e.prototype._preSelectItems=function(t,e){+t.val()>0&&e.state().get("selection").add(wp.media.attachment(t.val()))},e}();function i(){t(".dht-field-wrapper .dht-field-child-upload-item").each((function(){new e(t(this))}))}t((function(){i()})),t(document).on("dht_uploadAjaxComplete",(function(){i()}))}(i.n(n)())}}]);
//# sourceMappingURL=upload.js.map