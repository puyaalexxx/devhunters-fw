import jQuery from "jquery";

(function ($: JQueryStatic): void {
    "use strict";

    class Toggle {
        //toggle reference
        private $_toggle;
        private $_toggleInput;

        constructor($toggle: JQuery<HTMLElement>) {
            //switch reference
            this.$_toggle = $toggle;

            this.$_toggleInput = this.$_toggle.children("input");

            //init switch button
            this._initSwitch();
        }

        /**
         * init switch button
         *
         * @return void
         */
        private _initSwitch(): void {
            if (this.$_toggle.hasClass("dht-slider-on")) {
                this.$_toggle.removeClass("dht-slider-on").addClass("dht-slider-off");
                //get off value
                let value = this.$_toggle.children(".dht-slider").children(".dht-slider-no").attr("data-value")!;

                this.$_toggleInput.val(value);
            } else {
                this.$_toggle.removeClass("dht-slider-off").addClass("dht-slider-on");
                //get on value
                let value = this.$_toggle.children(".dht-slider").children(".dht-slider-yes").attr("data-value")!;

                this.$_toggleInput.val(value);
            }
        }
    }

    //init each switch button option
    $(".dht-field-child-toggle .dht-toggle").on("click", function () {
        new Toggle($(this));
    });
})(jQuery);
