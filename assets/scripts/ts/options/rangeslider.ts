import jQuery from "jquery";

(function ($: JQueryStatic): void {
    "use strict";

    jQuery(".dht-field-child-rangeslider").each(function () {
        const $this = jQuery(this).find(".dht-slider-slider");

        const is_range = $this.attr("data-range");
        const min = $this.attr("data-min")!;
        const max = $this.attr("data-max")!;
        let values = $this.attr("data-values")!;

        if (is_range === "yes") {
            const $input1 = $this
                .siblings(".dht-slider-group")
                .children(".dht-range-slider-1");
            const $input2 = $this
                .siblings(".dht-slider-group")
                .children(".dht-range-slider-2");

            const range_values: number[] =
                values.length > 0 ? values.split(",").map(Number) : [];

            $this.slider({
                range: true,
                min: +min,
                max: +max,
                values: range_values,
                slide: function (event, ui) {
                    if (ui.values !== undefined) {
                        $input1.val(ui.values[0]!);
                        $input2.val(ui.values[1]!);
                    }
                },
            });

            $input1.val($this.slider("values", 0));
            $input2.val($this.slider("values", 1));
        } else {
            const $input = $this.siblings(".dht-slider");

            $this.slider({
                range: "min",
                value: +values,
                min: +min,
                max: +max,
                slide: function (event, ui) {
                    $input.val(ui.value!);
                },
            });

            $input.val($this.slider("value"));
        }
    });
})(jQuery);
