(function($: JQueryStatic): void {
    "use strict";

    class Toggle {
        //toggle reference
        private $_toggle;

        constructor($toggle: JQuery<HTMLElement>) {
            //toggle reference
            this.$_toggle = $toggle;

            //init toggle button
            this._initToggle();
        }

        /**
         * init toggle button
         *
         * @return void
         */
        private _initToggle(): void {
            const $thisClass = this;

            this.$_toggle.off("click", ".dht-toggle").on("click", ".dht-toggle", function() {
                const $toggle = $(this);
                const $toggleInput = $toggle.children("input");

                if ($toggle.hasClass("dht-slider-on")) {
                    $toggle.removeClass("dht-slider-on").addClass("dht-slider-off");
                    //get off value
                    let value = $toggle.children(".dht-slider").children(".dht-slider-no").attr("data-value")!;

                    $toggleInput.val(value);
                } else {
                    $toggle.removeClass("dht-slider-off").addClass("dht-slider-on");
                    //get on value
                    let value = $toggle.children(".dht-slider").children(".dht-slider-yes").attr("data-value")!;

                    $toggleInput.val(value);
                }

                $thisClass._showHideOptions($toggle);
            });
        }

        /**
         * show/hide options
         *
         * @return void
         */
        private _showHideOptions($toggle: JQuery<HTMLElement>): void {
            const input_value = $toggle.children("input").attr("value")!;

            $toggle.siblings(".dht-toggle-content").each(function() {
                const $this = $(this);

                $this.removeClass("dht-toggle-show");

                if ($this.attr("data-toggle-value") === input_value) {
                    $this.addClass("dht-toggle-show");
                }
            });
        }
    }

    //init each toggle button option
    function init() {
        $(".dht-field-wrapper .dht-field-child-toggle").each(function() {
            new Toggle($(this));
        });
    }

    // Initialize on page load
    $(function() {
        init();
    });

    // Initialize after AJAX content is loaded
    $(document).on("dht_toggleAjaxComplete", function() {
        init();
    });
})(jQuery);
