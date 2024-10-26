(function($: JQueryStatic): void {
    "use strict";

    class Toggle {
        //toggle reference
        private $_toggle: JQuery<HTMLElement>;

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

            let values = [];
            this.$_toggle.off("click", ".dht-toggle").on("click", ".dht-toggle", function() {
                const $toggle = $(this);
                const $toggleInput = $toggle.children("input");

                if ($toggle.hasClass("dht-slider-on")) {
                    $toggle.removeClass("dht-slider-on").addClass("dht-slider-off");
                    //get off value
                    let value = $toggle.children(".dht-slider").children(".dht-slider-no").attr("data-value")!;

                    $toggleInput.val(value);

                    //init live editing
                    $thisClass._liveEditing("dht-slider-off");
                } else {
                    $toggle.removeClass("dht-slider-off").addClass("dht-slider-on");
                    //get on value
                    let value = $toggle.children(".dht-slider").children(".dht-slider-yes").attr("data-value")!;

                    $toggleInput.val(value);

                    //init live editing
                    $thisClass._liveEditing("dht-slider-on");
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

        /**
         * live editing
         * Ability to change other areas via changing the field
         * with the provided CSS selectors
         *
         * @param toggleClass On/Off toggle class
         *
         * @return void
         */
        private _liveEditing(toggleClass: string): void {
            //get toggle selectors
            const onSelectors = this.$_toggle.find(".dht-slider-yes").attr("data-live-selectors") ?? "";
            const offSelectors = this.$_toggle.find(".dht-slider-no").attr("data-live-selectors") ?? "";

            if (onSelectors.length === 0 || offSelectors.length === 0) return;

            if (toggleClass === "dht-slider-on") {
                $(onSelectors).show();
                $(offSelectors).hide();
            } else if (toggleClass === "dht-slider-off") {
                $(onSelectors).hide();
                $(offSelectors).show();
            }
        }
    }

    //init each toggle button option
    function init() {
        $(".dht-field-wrapper-toggle").each(function() {
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
