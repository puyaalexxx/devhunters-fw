"use strict";
(function ($) {
    "use strict";
    class RangeSlider {
        constructor($rangeSlider) {
            //range slider reference
            this.$_rangeSlider = $rangeSlider;
            this.$_sliderInput = this.$_rangeSlider.find(".dht-slider-slider");
            this.$_isRange = this.$_sliderInput.attr("data-range");
            this.$_min = +this.$_sliderInput.attr("data-min");
            this.$_max = +this.$_sliderInput.attr("data-max");
            this.$_sliderValues = this.$_sliderInput.attr("data-values");
            if (this.$_isRange === "yes") {
                this._initRangeSlider();
            }
            else {
                this._initSlider();
            }
        }
        /**
         * init range slider
         *
         * @return void
         */
        _initRangeSlider() {
            const $input1 = this.$_sliderInput.siblings(".dht-slider-group").children(".dht-range-slider-1");
            const $input2 = this.$_sliderInput.siblings(".dht-slider-group").children(".dht-range-slider-2");
            const range_values = this.$_sliderValues.length > 0 ? this.$_sliderValues.split(",").map(Number) : [];
            this.$_sliderInput.slider({
                range: true,
                min: this.$_min,
                max: this.$_max,
                values: range_values,
                slide: function (event, ui) {
                    if (ui.values !== undefined) {
                        $input1.val(ui.values[0]);
                        $input2.val(ui.values[1]);
                    }
                },
            });
            $input1.val(this.$_sliderInput.slider("values", 0));
            $input2.val(this.$_sliderInput.slider("values", 1));
        }
        /**
         * init slider
         *
         * @return void
         */
        _initSlider() {
            const $input = this.$_sliderInput.siblings(".dht-slider");
            this.$_sliderInput.slider({
                range: "min",
                value: +this.$_sliderValues,
                min: this.$_min,
                max: this.$_max,
                slide: function (event, ui) {
                    $input.val(ui.value);
                },
            });
            $input.val(this.$_sliderInput.slider("value"));
        }
    }
    //init each range slider option
    function init() {
        $(".dht-field-wrapper .dht-field-child-rangeslider").each(function () {
            new RangeSlider($(this));
        });
    }
    // Initialize on page load
    $(function () {
        init();
    });
    // Initialize after AJAX content is loaded
    $(document).on("dht_rangeSliderAjaxComplete", function () {
        init();
    });
})(jQuery);
