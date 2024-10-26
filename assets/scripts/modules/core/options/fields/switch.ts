(function($: JQueryStatic): void {
    "use strict";

    class Switch {
        //switch reference
        private $_switch;

        constructor($switch: JQuery<HTMLElement>) {
            //switch reference
            this.$_switch = $switch;

            //init switch button
            this._initSwitch();
        }

        /**
         * init switch button
         *
         * @return void
         */
        private _initSwitch(): void {
            //class reference
            const $thisClass = this;

            $thisClass.$_switch.off("click", ".dht-switch");
            $thisClass.$_switch.on("click", ".dht-switch", function() {
                const $switch = $(this);
                const $switchInput = $switch.children("input");

                if ($switch.hasClass("dht-slider-on")) {
                    $switch.removeClass("dht-slider-on").addClass("dht-slider-off");
                    //get off value
                    let value = $switch.children(".dht-slider").children(".dht-slider-no").attr("data-value")!;

                    $switchInput.val(value);

                    //init live editing
                    $thisClass._liveEditing("dht-slider-off");
                } else {
                    $switch.removeClass("dht-slider-off").addClass("dht-slider-on");
                    //get on value
                    let value = $switch.children(".dht-slider").children(".dht-slider-yes").attr("data-value")!;

                    $switchInput.val(value);

                    //init live editing
                    $thisClass._liveEditing("dht-slider-on");
                }
            });
        }

        /**
         * live editing
         * Ability to change other areas via changing the field
         * with the provided CSS selectors
         *
         * @param switchClass On/Off switch class
         *
         * @return void
         */
        private _liveEditing(switchClass: string): void {
            //get switch selectors
            const onSelectors = this.$_switch.find(".dht-slider-yes").attr("data-live-selectors") ?? "";
            const offSelectors = this.$_switch.find(".dht-slider-no").attr("data-live-selectors") ?? "";

            if (onSelectors.length === 0 || offSelectors.length === 0) return;

            if (switchClass === "dht-slider-on") {
                $(onSelectors).show();
                $(offSelectors).hide();
            } else if (switchClass === "dht-slider-off") {
                $(onSelectors).hide();
                $(offSelectors).show();
            }
        }
    }

    //init each switch button option
    function init() {
        $(".dht-field-wrapper-switch").each(function() {
            new Switch($(this));
        });
    }

    // Initialize on page load
    $(function() {
        init();
    });

    // Initialize after AJAX content is loaded
    $(document).on("dht_switchtAjaxComplete", function() {
        init();
    });
})(jQuery);
