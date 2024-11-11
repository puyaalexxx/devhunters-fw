import { errorLoadingModule } from "@helpers/general";

(function($: JQueryStatic): void {
    "use strict";

    class RangeSlider {
        //range slider reference
        private readonly $_rangeSlider;
        private $_sliderInput;
        private readonly $_isRange;
        private readonly $_min: number;
        private readonly $_max: number;
        private readonly $_sliderValues;
        private readonly $_liveSelectors;

        constructor($rangeSlider: JQuery<HTMLElement>) {
            //range slider reference
            this.$_rangeSlider = $rangeSlider;

            this.$_sliderInput = this.$_rangeSlider.find(".dht-slider-slider");
            this.$_isRange = this.$_sliderInput.attr("data-range");
            this.$_min = +this.$_sliderInput.attr("data-min")!;
            this.$_max = +this.$_sliderInput.attr("data-max")!;
            this.$_sliderValues = this.$_sliderInput.attr("data-values")!;
            this.$_liveSelectors = this.$_rangeSlider.attr("data-live-selectors") ?? "";

            if (this.$_isRange === "yes") {
                this._initRangeSlider();
            } else {
                this._initSlider();
            }
        }

        /**
         * init range slider
         *
         * @return void
         */
        private _initRangeSlider(): void {
            const $thisClass = this;
            const $input1 = this.$_sliderInput.siblings(".dht-slider-group").children(".dht-range-slider-1");
            const $input2 = this.$_sliderInput.siblings(".dht-slider-group").children(".dht-range-slider-2");

            const range_values: number[] = this.$_sliderValues.length > 0 ? this.$_sliderValues.split(",").map(Number) : [];

            this.$_sliderInput.slider({
                range: true,
                min: this.$_min,
                max: this.$_max,
                values: range_values,
                slide: function(_, ui) {
                    if (ui.values !== undefined) {
                        $input1.val(ui.values[0]!);
                        $input2.val(ui.values[1]!);

                        if ($thisClass.$_liveSelectors.length > 0) {
                            $thisClass._liveEditing([ui.values[0]!, ui.values[1]!]).then(() => {
                            }).catch(error => {
                                console.error(error);
                            });
                        }
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
        private _initSlider(): void {
            const $thisClass = this;
            const $input = this.$_sliderInput.siblings(".dht-slider");

            this.$_sliderInput.slider({
                range: "min",
                value: +this.$_sliderValues,
                min: this.$_min,
                max: this.$_max,
                slide: function(_, ui) {
                    $input.val(ui.value!);

                    if ($thisClass.$_liveSelectors.length > 0) {
                        $thisClass._liveEditing([ui.value!]).then(() => {
                        }).catch(error => {
                            console.error(error);
                        });
                    }
                },
            });

            $input.val(this.$_sliderInput.slider("value"));
        }

        /**
         * live editing
         * Ability to change other areas via changing the field
         * with the provided CSS selectors
         *
         * @param values RangeSlider values
         *
         * @return Promise<void>
         */
        private async _liveEditing(values: number[]): Promise<void> {
            try {
                const { dhtKeyedSelectorsHelper } = await import("@helpers/options/live-editing");

                dhtKeyedSelectorsHelper(this.$_rangeSlider, (key: string, target: string, selectors: string) => {
                    if (target === "style") {
                        if (this.$_isRange === "yes") {
                            const cssProperties = key.split(",");

                            //there should be always 2 CSS properties to apply the range values to them
                            if (cssProperties.length === 2) {
                                cssProperties.forEach((cssProperty, index) => {
                                    $(selectors).css({ [cssProperty.trim()]: values[index] + "px" });
                                });
                            }
                        } else {
                            $(selectors).css({ [key]: values[0] + "px" });
                        }
                    }
                });
            } catch (error) {
                errorLoadingModule(error as string);
            }
        }
    }

    //init each range slider option
    function init() {
        $(".dht-field-wrapper-rangeslider").each(function() {
            new RangeSlider($(this));
        });
    }

    // Initialize on page load
    $(function() {
        init();
    });

    // Initialize after AJAX content is loaded
    $(document).on("dht_rangeSliderAjaxComplete", function() {
        init();
    });
})(jQuery);
