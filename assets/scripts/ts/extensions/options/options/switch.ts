import jQuery from "jquery";

(function ($: JQueryStatic): void {
    "use strict";

    class Switch {
        //switch reference
        private $_switch;
        private $_switchInput;

        constructor($switch: JQuery<HTMLElement>) {
            //switch reference
            this.$_switch = $switch;

            this.$_switchInput = this.$_switch.children("input");

            //init switch button
            this._initSwitch();
        }

        /**
         * init switch button
         *
         * @return void
         */
        private _initSwitch(): void {
            if (this.$_switch.hasClass("dht-slider-on")) {
                this.$_switch.removeClass("dht-slider-on").addClass("dht-slider-off");
                //get off value
                let value = this.$_switch.children(".dht-slider").children(".dht-slider-no").attr("data-value")!;

                this.$_switchInput.val(value);
            } else {
                this.$_switch.removeClass("dht-slider-off").addClass("dht-slider-on");
                //get on value
                let value = this.$_switch.children(".dht-slider").children(".dht-slider-yes").attr("data-value")!;

                this.$_switchInput.val(value);
            }
        }
    }

    //init each switch button option
    $(".dht-field-wrapper").on("click", ".dht-field-child-switch .dht-switch", function () {
        new Switch($(this));
    });
})(jQuery);
