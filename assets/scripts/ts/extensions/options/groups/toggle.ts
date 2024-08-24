import jQuery from "jquery";

(function ($: JQueryStatic): void {
    "use strict";

    class Toggle {
        //toggle reference
        private $_toggle;
        private $_toggleInput;

        constructor($toggle: JQuery<HTMLElement>) {
            //toggle reference
            this.$_toggle = $toggle;

            this.$_toggleInput = this.$_toggle.children("input");

            //init toggle button
            this._initToggle();
        }

        /**
         * init toggle button
         *
         * @return void
         */
        private _initToggle(): void {
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

            this._showHideOptions();
        }

        /**
         * show/hide options
         *
         * @return void
         */
        private _showHideOptions(): void {
            const input_value = this.$_toggle.children("input").attr("value");

            this.$_toggle.siblings(".dht-toggle-content").each(function () {
                $(this).removeClass("dht-toggle-show");

                if ($(this).attr("data-toggle-value") === input_value) {
                    $(this).addClass("dht-toggle-show");
                }
            });
        }
    }

    //init each switch button option
    $(".dht-field-child-toggle .dht-toggle").on("click", function () {
        new Toggle($(this));
    });
})(jQuery);
