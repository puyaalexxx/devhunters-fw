import{_ as $}from"./addable-box.js";import{e as v}from"./general.js";(function(d){class c{constructor(e){this.$_rangeSlider=e,this.$_sliderInput=this.$_rangeSlider.find(".dht-slider-slider"),this.$_isRange=this.$_sliderInput.attr("data-range"),this.$_min=+this.$_sliderInput.attr("data-min"),this.$_max=+this.$_sliderInput.attr("data-max"),this.$_sliderValues=this.$_sliderInput.attr("data-values"),this.$_liveSelectors=this.$_rangeSlider.attr("data-live-selectors")??"",this.$_isRange==="yes"?this._initRangeSlider():this._initSlider()}_initRangeSlider(){const e=this,n=this.$_sliderInput.siblings(".dht-slider-group").children(".dht-range-slider-1"),i=this.$_sliderInput.siblings(".dht-slider-group").children(".dht-range-slider-2"),h=this.$_sliderValues.length>0?this.$_sliderValues.split(",").map(Number):[];this.$_sliderInput.slider({range:!0,min:this.$_min,max:this.$_max,values:h,slide:function(u,r){r.values!==void 0&&(n.val(r.values[0]),i.val(r.values[1]),e.$_liveSelectors.length>0&&e._liveEditing([r.values[0],r.values[1]]).then(()=>{}).catch(t=>{console.error(t)}))}}),n.val(this.$_sliderInput.slider("values",0)),i.val(this.$_sliderInput.slider("values",1))}_initSlider(){const e=this,n=this.$_sliderInput.siblings(".dht-slider");this.$_sliderInput.slider({range:"min",value:+this.$_sliderValues,min:this.$_min,max:this.$_max,slide:function(i,h){n.val(h.value),e.$_liveSelectors.length>0&&e._liveEditing([h.value]).then(()=>{}).catch(u=>{console.error(u)})}}),n.val(this.$_sliderInput.slider("value"))}async _liveEditing(e){const n=this;try{let i=function(t,s,l,a){if(t==="style")if(n.$_isRange==="yes"){const o=l.split(",");o.length===2&&o.forEach((g,p)=>{d(s).css({[g.trim()]:a[p]+"px"})})}else d(s).css({[l]:a[0]+"px"})};const{dhtApplyChangesForKeyedSelectors:h,dhtRestoreElementDefaultValues:u,dhtGetDefaultValue:r}=await $(async()=>{const{dhtApplyChangesForKeyedSelectors:t,dhtRestoreElementDefaultValues:s,dhtGetDefaultValue:l}=await import("./live-editing.js");return{dhtApplyChangesForKeyedSelectors:t,dhtRestoreElementDefaultValues:s,dhtGetDefaultValue:l}},[]);h(this.$_rangeSlider,(t,s,l)=>{i(s,l,t,e)},(t,s,l)=>{u(this.$_rangeSlider,()=>{const a=r(this.$_rangeSlider),o=this.$_isRange==="yes"?a?a.split(","):[0]:a?[a]:[0];i(s,l,t,o.map(Number))})})}catch(i){v(i)}}}function _(){d(".dht-field-wrapper-rangeslider").each(function(){new c(d(this))})}d(function(){_()}),d(document).on("dht_rangeSliderAjaxComplete",function(){_()})})(jQuery);
