import jQuery from "jquery";

(function ($: JQueryStatic): void {
    "use strict";

    $(".dht-field-child-switch .dht-switch").on("click", function () {
        let $this = $(this);
        let $input = $this.children("input");

        if ($this.hasClass("dht-slider-on")) {
            $this.removeClass("dht-slider-on").addClass("dht-slider-off");
            //get off value
            let value = $this.children(".dht-slider").children(".dht-slider-no").attr("data-value")!;

            $input.val(value);
        } else {
            $this.removeClass("dht-slider-off").addClass("dht-slider-on");
            //get on value
            let value = $this.children(".dht-slider").children(".dht-slider-yes").attr("data-value")!;

            $input.val(value);
        }
    });
})(jQuery);
