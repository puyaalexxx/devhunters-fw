import { errorLoadingModule } from "@helpers/general";

(function($: JQueryStatic): void {
    "use strict";

    class Switch {
        //switch reference
        private readonly $_switch;

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
                    $thisClass._liveEditing(value).then(() => {
                    }).catch(error => {
                        console.error(error);
                    });
                } else {
                    $switch.removeClass("dht-slider-off").addClass("dht-slider-on");
                    //get on value
                    let value = $switch.children(".dht-slider").children(".dht-slider-yes").attr("data-value")!;

                    $switchInput.val(value);

                    //init live editing
                    $thisClass._liveEditing(value).then(() => {
                    }).catch(error => {
                        console.error(error);
                    });
                }
            });
        }

        /**
         * live editing
         * Ability to change other areas via changing the field
         * with the provided CSS selectors
         *
         * @param displaySwitchValue On/Off switch value
         *
         * @return Promise<void>
         */
        private async _liveEditing(displaySwitchValue: string): Promise<void> {
            //no live editor attribute
            if (!(this.$_switch.attr("data-live-selectors") ?? "").length) return;

            try {
                const {
                    dhtApplyChangesForKeyedSelectors, dhtRestoreElementDefaultValues, dhtGetDefaultValue,
                } = await import("@helpers/options/live-editing");

                dhtApplyChangesForKeyedSelectors(
                    this.$_switch,
                    // Live change handler
                    (key: string, target: string, selectors: string) => {
                        if (target === "display") {
                            applyChangesHelper(selectors, key, displaySwitchValue);
                        }
                    },
                    //restore to defaults
                    (key: string, target: string, selectors: string) => {
                        if (target === "display") {
                            dhtRestoreElementDefaultValues(this.$_switch, () => {
                                applyChangesHelper(selectors, key, dhtGetDefaultValue(this.$_switch));
                            });
                        }
                    },
                );

                //helper function to apply the style changes
                function applyChangesHelper(selectors: string, key: string, value: string) {
                    if (key === value) {
                        $(selectors).show();
                    } else {
                        $(selectors).hide();
                    }
                }
            } catch (error) {
                errorLoadingModule(error as string);
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
