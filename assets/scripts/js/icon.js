"use strict";(self.webpackChunkdevhunters_fw=self.webpackChunkdevhunters_fw||[]).push([[8752],{3687:(e,i,n)=>{n.r(i);var t=n(1669);!function(e){var i=function(){function i(e){this.$_icon=e,this._onPopupOpen(),this._callAjaxWithSelectedIcon(),this._addSelectedIconOnPreviewArea(),this._removeSelectedIcon(),this._searchIcon()}return i.prototype._onPopupOpen=function(){var i=this;this.$_icon.off("click",".dht-thickbox").on("click",".dht-thickbox",(function(){var n=e(this),t=n.siblings(".dht-modal-icons").find(".dht-icons-type-group");t.children(".dht-search-for-icon").val("");var o=n.siblings(".dht-icon-select-value").val(),c="dashicons",s="";if(o.length>0){var r=JSON.parse(o);c=r["icon-type"],s=r["icon-class"]}t.children(".dht-icons-type").val(c),i._getIconsViaAjax(c,t,s)}))},i.prototype._callAjaxWithSelectedIcon=function(){var i=this;e(document).off("change",".dht-icons-preview-group .dht-icons-type").on("change",".dht-icons-preview-group .dht-icons-type",(function(){var n=e(this),t=n.val();0!==t.length&&(n.parent(".dht-icons-type-group").siblings(".dht-icons-preview").empty(),i._getIconsViaAjax(t,n.parent(".dht-icons-type-group"),""))}))},i.prototype._addSelectedIconOnPreviewArea=function(){e(document).off("click","#TB_window .dht-icons-preview i").on("click","#TB_window .dht-icons-preview i",(function(){var i=e(this),n=i.attr("class"),t=i.attr("data-code"),o=i.parents(".dht-icons-preview-group").children(".dht-icons-type-group").children(".dht-icons-type"),c=i.parents(".dht-icons-preview-group").attr("data-popup-id"),s=e("#"+c);s.siblings(".dht-icon-select-preview").children("i").removeAttr("class").addClass(n).parent().addClass("dht-icon-select-preview-show"),s.siblings(".dht-icon-select-value").val(JSON.stringify({"icon-type":o.val(),"icon-class":n,"icon-code":t})),s.siblings(".dht-btn-remove").addClass("dht-btn-show"),e("#TB_closeWindowButton").trigger("click")}))},i.prototype._removeSelectedIcon=function(){this.$_icon.off("click",".dht-btn-remove").on("click",".dht-btn-remove",(function(){var i=e(this);return i.siblings(".dht-icon-select-preview").children("i").removeAttr("class").parent().removeClass("dht-icon-select-preview-show"),i.siblings(".dht-icon-select-value").val(""),i.removeClass("dht-btn-show"),!1}))},i.prototype._searchIcon=function(){e(document).off("keyup",".dht-icons-preview-group .dht-search-for-icon").on("keyup",".dht-icons-preview-group .dht-search-for-icon",(function(){var i=e(this),n=i.parents(".dht-icons-preview-group"),t=i.val().toLowerCase();n.children(".dht-icons-preview").children("i").each((function(){var i=e(this);-1===i.attr("class").toLowerCase().indexOf(t)?i.hide():i.show()}))}))},i.prototype._getIconsViaAjax=function(i,n,t){n.children(".dht-icons-type").prop("disabled",!0),e.ajax({url:dht_framework_ajax_info.ajax_url,type:"POST",dataType:"json",data:{action:"getOptionIcons",data:{icon_type:i,icon:t}},beforeSend:function(){n.siblings(".spinner").css("visibility","visible"),n.siblings(".dht-icons-preview").empty()},success:function(e){e.success?n.siblings(".dht-icons-preview").append(e.data):console.error("Ajax Response",e)},error:function(e){console.error("AJAX error:",e)},complete:function(){n.siblings(".spinner").css("visibility","hidden"),n.children(".dht-icons-type").prop("disabled",!1)}})},i}();function n(){e(".dht-field-wrapper .dht-field-child-icons").each((function(){new i(e(this))}))}e((function(){n()})),e(document).on("dht_iconAjaxComplete",(function(){n()}))}(n.n(t)())}}]);
//# sourceMappingURL=icon.js.map