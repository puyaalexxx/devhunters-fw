"use strict";(self.webpackChunkdevhunters_fw=self.webpackChunkdevhunters_fw||[]).push([[2292],{1491:(t,o,n)=>{n.r(o);var e=n(1669);!function(t){var o=function(){function o(t){this._selected_google_font_name="",this.$_typography=t;var o=this;this.$_preview_area=this.$_typography.children(".dht-field-child-typography-preview"),this.$_fonts_dropdown=this.$_typography.find(".dht-typography"),this.$_font_weight_dropdown=this.$_typography.find(".dht-typography-weight"),this.$_font_style_dropdown=this.$_typography.find(".dht-typography-style"),this.$_font_subsets_dropdown=this.$_typography.find(".dht-typography-subsets"),this.$_text_transform_dropdown=this.$_typography.find(".dht-typography-transform"),this.$_text_decoration_dropdown=this.$_typography.find(".dht-typography-decoration"),this._font_prefix=this.$_fonts_dropdown.attr("data-font-prefix"),this.$_font_type_hidden_input=this.$_fonts_dropdown.siblings(".dht-typography-font-type-hidden"),this.$_font_path_hidden_input=this.$_fonts_dropdown.siblings(".dht-typography-path-hidden"),this._setHeaderFontFromSavedValues(o),this._fontDropdown(o),this._fontWeightsDropdown(o),this._fontStylesDropdown(o),this._fontSubsetsDropdown(o),this._textTransformDropdown(o),this._textDecorationDropdown(o)}return o.prototype._fontDropdown=function(o){this.$_fonts_dropdown.select2({allowClear:!0}),this.$_fonts_dropdown.off("change.mychange"),this.$_fonts_dropdown.on("change.mychange",(function(){var n=t(this),e=String(n.find("option:selected").attr("data-font-type")),a=String(n.val()).replace(new RegExp("^".concat(o._font_prefix,"-")),"");o.$_preview_area.css("font-family",a),"google"===e?o._googleFontsManipulations(o,n,a):"divi"===e?o._diviFontsManipulations(o,n,a):o._standardFontsManipulations(o,n)}))},o.prototype._googleFontsManipulations=function(t,o,n){t.$_font_type_hidden_input.attr("value","google"),t.$_font_path_hidden_input.attr("value",""),t._selected_google_font_name=n;var e=String(o.find("option:selected").attr("data-font-subsets"));t._buildFontLink(n);var a=o.find("option:selected").attr("data-font-weights");t._populateFontWeightDropdown(t,o,a),t._populateFontSubsetsDropdown(t,e),t.$_font_weight_dropdown.trigger("change.mychange")},o.prototype._diviFontsManipulations=function(t,o,n){t.$_font_type_hidden_input.attr("value","divi");var e=String(o.find("option:selected").attr("data-font-path"));t.$_font_path_hidden_input.attr("value",e),t._setStyleTagCSS(t,n,e),t.$_font_subsets_dropdown.empty().trigger("change.mychange");var a=o.find("option:selected").attr("data-font-weights");t._populateFontWeightDropdown(t,o,a)},o.prototype._standardFontsManipulations=function(t,o){t.$_font_type_hidden_input.attr("value","standard"),t.$_font_path_hidden_input.attr("value",""),t.$_font_subsets_dropdown.empty().trigger("change.mychange");var n=t.$_font_weight_dropdown.attr("data-standard-font-weights");t._populateFontWeightDropdown(t,o,n)},o.prototype._fontWeightsDropdown=function(o){this.$_font_weight_dropdown.select2({allowClear:!0}),this.$_font_weight_dropdown.off("change.mychange").on("change.mychange",(function(){var n=String(t(this).val());if(0!==n.length){var e="https://fonts.googleapis.com/css?family="+o._selected_google_font_name.replace(/\s+/g,"+")+":"+n;t('<link href="'+e+'" rel="stylesheet">').appendTo("head")}o.$_preview_area.css("font-weight",n)}))},o.prototype._fontSubsetsDropdown=function(t){this.$_font_subsets_dropdown.select2({allowClear:!0})},o.prototype._fontStylesDropdown=function(o){this.$_font_style_dropdown.select2({allowClear:!0}),this.$_font_style_dropdown.off("change.mychange").on("change.mychange",(function(){var n=String(t(this).val());o.$_preview_area.css("font-style",n)}))},o.prototype._textTransformDropdown=function(o){this.$_text_transform_dropdown.select2({allowClear:!0}),this.$_text_transform_dropdown.off("change.mychange").on("change.mychange",(function(){var n=String(t(this).val());o.$_preview_area.css("font-variant",""),o.$_preview_area.css("text-transform",""),"small-caps"===n?o.$_preview_area.css("font-variant",n):o.$_preview_area.css("text-transform",n)}))},o.prototype._textDecorationDropdown=function(o){this.$_text_decoration_dropdown.select2({allowClear:!0}),this.$_text_decoration_dropdown.off("change.mychange").on("change.mychange",(function(){var n=String(t(this).val());o.$_preview_area.css("text-decoration",n)}))},o.prototype._populateFontWeightDropdown=function(o,n,e){o.$_font_weight_dropdown.empty(),e.length>0&&(o.$_font_weight_dropdown.append("<option></option>"),t.each(JSON.parse(e),(function(t,n){o.$_font_weight_dropdown.append('<option value="'+t+'">'+n+"</option>")})))},o.prototype._populateFontSubsetsDropdown=function(o,n){o.$_font_subsets_dropdown.empty(),n.length>0&&(o.$_font_subsets_dropdown.append("<option></option>"),t.each(JSON.parse(n),(function(t,n){o.$_font_subsets_dropdown.append('<option value="'+n+'">'+n+"</option>")})))},o.prototype._setHeaderFontFromSavedValues=function(t){var o=this.$_fonts_dropdown.attr("data-saved-values");if(o.length>0){var n=JSON.parse(o);"google"===n.font_type&&t._buildFontLink(n.font,n.weight)}},o.prototype._setStyleTagCSS=function(t,o,n){t.$_typography.find("#dht-custom-style").children("style").empty().append("@font-face {font-family: "+o+";src: url("+n+") format('truetype');}")},o.prototype._buildFontLink=function(o,n){void 0===n&&(n="");var e="";n.length>0?(e="https://fonts.googleapis.com/css?family="+o.replace(/\s+/g,"+")+":"+n,t('<link href="'+e+'" rel="stylesheet">').appendTo("head")):e="https://fonts.googleapis.com/css?family="+o.replace(/\s+/g,"+"),t('<link href="'+e+'" rel="stylesheet">').appendTo("head")},o}();function n(){t(".dht-field-wrapper .dht-field-child-typography").each((function(){new o(t(this))}))}t((function(){n()})),t(document).on("dht_typographyAjaxComplete",(function(){n()}))}(n.n(e)())}}]);
//# sourceMappingURL=typography.js.map