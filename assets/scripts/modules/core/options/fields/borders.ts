import { errorLoadingModule } from "@helpers/general";

(function($: JQueryStatic): void {
    "use strict";

    class Borders {
        //borders reference
        private readonly $_borders;

        constructor($borders: JQuery<HTMLElement>) {
            //borders reference
            this.$_borders = $borders;

            //init borders
            this._initBorders().then(() => {
            }).catch(error => {
                console.error(error);
            });

            //init live editing
            this._liveEditing().then(() => {
            }).catch(error => {
                console.error(error);
            });
        }

        /**
         * init borders
         *
         * @return void
         */
        private async _initBorders(): Promise<void> {
            //initialize colorpicker
            try {
                const { dhtInitColorpicker } = await import("@helpers/options/colorpicker-utilities");

                //call colorpicker functionality
                this.$_borders.find(".dht-colorpicker").each(function() {
                    dhtInitColorpicker($(this));
                });
            } catch (error) {
                errorLoadingModule(error as string);
            }
        }

        /**
         * live editing
         * Ability to change other areas via changing the field
         * with the provided CSS selectors
         *
         * @return Promise<void>
         */
        private async _liveEditing(): Promise<void> {
            const $thisClass = this;
            //no live editor attribute
            if (!(this.$_borders.attr("data-live-selectors") ?? "").length) return;

            try {
                const { dhtNotKeyedSelectorsHelper } = await import("@helpers/options/live-editing");
                const { dhtOnChangeColorpicker } = await import("@helpers/options/colorpicker-utilities");

                const isBorderRadius = this.$_borders.hasClass("dht-field-wrapper-border-radius") ?? false;
                const borderInputs = [
                    ".dht-border-top", ".dht-border-right", ".dht-border-bottom", ".dht-border-left",
                ];

                dhtNotKeyedSelectorsHelper(this.$_borders, (target: string, selectors: string) => {
                    if (target === "style") {

                        onChangeBorderInputs(selectors);

                        //these options are available only for the borders field
                        if (!isBorderRadius) {
                            //border styles could be disabled
                            if (this.$_borders.find(".dht-border-style").length) {
                                this.$_borders.on("change", ".dht-border-style", function() {
                                    triggerBorderInputsChange();
                                });
                            }
                            //apply styles on colorPicker change value
                            const $borderColorpicker = this.$_borders.find(".dht-colorpicker") ?? "";
                            if ($borderColorpicker.length !== 0) {
                                dhtOnChangeColorpicker($borderColorpicker, (color) => {
                                    $(selectors).css({ "border-color": color });
                                });
                            }
                        }
                    }

                    //border size - px, em... (border sizes could be disabled)
                    if (this.$_borders.find(".dht-border-size").length) {
                        this.$_borders.on("change", ".dht-border-size", function() {
                            triggerBorderInputsChange();
                        });
                    }
                });

                //helper function for border inputs on change event
                function onChangeBorderInputs(selectors: string) {
                    // Bind input change handler
                    borderInputs.forEach($inputClass => {
                        $thisClass.$_borders.on("input change", $inputClass, function() {
                            // Get the value of the current input field
                            const currentValue = String($(this).val());
                            //get unit value
                            const $sizeStyleElement = $thisClass.$_borders.find(".dht-border-size");
                            const size = $sizeStyleElement.length > 0 ? (String($sizeStyleElement.val()) || "px") : "px";

                            // Initialize an array with the current value (i.e., the one that triggered the change event)
                            const borderInputsValues = borderInputs.map(input => {
                                if (input === $inputClass) {
                                    // If this is the current input, use the value captured in the event
                                    return currentValue.length === 0 ? 0 : currentValue + size;
                                } else {
                                    const value = String($thisClass.$_borders.find(input).val());
                                    // Otherwise, use the value of the other border inputs
                                    return value.length === 0 ? 0 : value + size;
                                }
                            });

                            // Join the border values to form the border-width CSS value (top, right, bottom, left)
                            const borderValues = borderInputsValues.join(" ");

                            if (isBorderRadius) {
                                $(selectors).css({ "border-radius": borderValues });
                            } else {
                                //get border style value
                                const $borderStyleElement = $thisClass.$_borders.find(".dht-border-style");
                                const bStyle = $borderStyleElement.length > 0 ? (String($borderStyleElement.val()) || "solid") : "solid";

                                $(selectors).css({ "border-width": borderValues, "border-style": bStyle });
                            }
                        });
                    });
                }

                //helper function for border inputs to be triggered
                function triggerBorderInputsChange() {
                    borderInputs.forEach(inputClass => {
                        $thisClass.$_borders.find(inputClass).trigger("change");
                    });
                }
            } catch (error) {
                errorLoadingModule(error as string);
            }
        }
    }

    //init each borders option
    function init() {
        $(".dht-field-wrapper-borders").each(function() {
            new Borders($(this));
        });
    }

    // Initialize on page load
    $(function() {
        init();
    });

    // Initialize after AJAX content is loaded
    $(document).on("dht_bordersAjaxComplete", function() {
        init();
    });
})(jQuery);

