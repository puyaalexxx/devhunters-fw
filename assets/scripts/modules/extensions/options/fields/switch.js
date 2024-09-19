"use strict";
(function ($) {
    "use strict";
    class Switch {
        constructor($switch) {
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
        _initSwitch() {
            //class reference
            const $this = this;
            $this.$_switch.off("click", ".dht-switch");
            $this.$_switch.on("click", ".dht-switch", function () {
                const $switch = $(this);
                const $switchInput = $switch.children("input");
                if ($switch.hasClass("dht-slider-on")) {
                    $switch.removeClass("dht-slider-on").addClass("dht-slider-off");
                    //get off value
                    let value = $switch.children(".dht-slider").children(".dht-slider-no").attr("data-value");
                    $switchInput.val(value);
                }
                else {
                    $switch.removeClass("dht-slider-off").addClass("dht-slider-on");
                    //get on value
                    let value = $switch.children(".dht-slider").children(".dht-slider-yes").attr("data-value");
                    $switchInput.val(value);
                }
            });
        }
    }
    //init each switch button option
    function init() {
        $(".dht-field-wrapper .dht-field-child-switch").each(function () {
            new Switch($(this));
        });
    }
    // Initialize on page load
    $(function () {
        init();
    });
    // Initialize after AJAX content is loaded
    $(document).on("dht_switchtAjaxComplete", function () {
        init();
    });
})(jQuery);
