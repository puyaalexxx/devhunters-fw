(function(i){class u{constructor(t){this.$_multiinput=t,this._addInput(),this._removeInput()}_addInput(){this.$_multiinput.off("click",".dht-multiinput-add").on("click",".dht-multiinput-add",function(){let t=i(this),l=+t.attr("data-limit");if(t.parents(".dht-field-child-multiinput").children(".dht-multiinput-child-wrapper").length>=l)return confirm(i(this).attr("data-add-text")),!1;let e=t.prev(".dht-multiinput-child-wrapper").clone();e.children("input").val(""),e.insertBefore(t)})}_removeInput(){this.$_multiinput.off("click",".dht-multiinput-remove").on("click",".dht-multiinput-remove",function(){let t=i(this);if(t.parents(".dht-field-child-wrapper").children(".dht-multiinput-child-wrapper").length===1){confirm(i(this).attr("data-remove-text"));return}t.parent(".dht-multiinput-child-wrapper").remove()})}}function n(){i(".dht-field-wrapper-multiinput").each(function(){new u(i(this))})}i(function(){n()}),i(document).on("dht_multiInputAjaxComplete",function(){n()})})(jQuery);
