import { errorLoadingModule } from "@helpers/general";

(function($: JQueryStatic): void {
    "use strict";

    class Dimension {
        //dimension reference
        private readonly $_dimension;
        //colorpicker reference
        private readonly $_colorpicker;
        //border style  reference
        private readonly $_border_style;
        //units reference
        private readonly $_units;

        constructor($dimension: JQuery<HTMLElement>) {
            //dimension reference
            this.$_dimension = $dimension;
            //colorpicker element
            this.$_colorpicker = this.$_dimension.find(".dht-colorpicker") ?? "";
            //border style element
            this.$_border_style = this.$_dimension.find(".dht-dimension-border-style") ?? "";
            //units element
            this.$_units = this.$_dimension.find(".dht-dimension-unit") ?? "";

            //init dimension field
            this._initDimension().then(() => {
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
         * init dimension field
         *
         * @return void
         */
        private async _initDimension(): Promise<void> {
            if (this.$_colorpicker.length === 0) return;

            //initialize colorpicker
            try {
                const { dhtInitColorpicker } = await import("@helpers/options/colorpicker-utilities");

                //call colorpicker functionality
                this.$_dimension.find(".dht-colorpicker").each(function() {
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
            if (!(this.$_dimension.attr("data-live-selectors") ?? "").length) return;

            try {
                const {
                    dhtApplyChangesForKeyedSelectors, dhtRestoreElementDefaultValues,
                } = await import("@helpers/options/live-editing");
                const { dhtOnChangeColorpicker } = await import("@helpers/options/colorpicker-utilities");

                const dimensionInputs = [
                    ".dht-dimension-input-size-1", ".dht-dimension-input-size-2", ".dht-dimension-input-size-3", ".dht-dimension-input-size-4",
                ];

                dhtApplyChangesForKeyedSelectors(
                    this.$_dimension,
                    // Live change handler
                    (key: string, target: string, selectors: string) => {
                        if (target === "style") {

                            if (key === "border") {
                                //dimension border styles could be disabled
                                if (this.$_border_style.length) {
                                    $(this.$_border_style).on("change", function() {
                                        triggerDimensionInputsChange();
                                    });
                                }
                            }

                            //apply styles on colorPicker change value
                            if (this.$_colorpicker.length !== 0) {
                                dhtOnChangeColorpicker(this.$_colorpicker, (_) => {
                                    triggerDimensionInputsChange();
                                });
                            }
                            //dimension size - px, em... (dimension sizes could be disabled)
                            if (this.$_units.length) {
                                $(this.$_units).on("change", function() {
                                    triggerDimensionInputsChange();
                                });
                            }

                            onChangeDimensionInputs(key, selectors);
                        }
                    },
                    //restore to defaults
                    (key: string, target: string, selectors: string) => {
                        if (target === "style") {
                            const colorStyle = getColorpickerValue();
                            const borderStyle = getBorderStylesDropdownValue();

                            //get joined inputs values
                            const dimensionValues = getDimensionInputsValues($(), getUnitsDropdownValue());

                            dhtRestoreElementDefaultValues(this.$_dimension, () => {
                                applyChangesHelper(selectors, key, dimensionValues, borderStyle, colorStyle);
                            });
                        }
                    },
                );

                //helper function to apply the style changes
                function applyChangesHelper(selectors: string, cssProperty: string, dimensionValues: string, borderStyle: string, colorStyle: string) {
                    if (cssProperty === "border") {
                        $(selectors).css({ "border-width": dimensionValues });
                        $(selectors).css({ "border-style": borderStyle });
                        $(selectors).css({ "border-color": colorStyle });
                    } else {
                        if (colorStyle.length > 0) {
                            $(selectors).css({ [cssProperty]: dimensionValues + " " + colorStyle });
                        } else {
                            $(selectors).css({ [cssProperty]: dimensionValues });
                        }
                    }
                }

                //helper function for dimension inputs on change event
                function onChangeDimensionInputs(cssProperty: string, selectors: string) {
                    // Bind input change handler
                    $thisClass.$_dimension.on("input change", ".dht-dimension", function(event) {
                        event.stopPropagation();

                        //get joined inputs values
                        const dimensionValues = getDimensionInputsValues($(this), getUnitsDropdownValue());

                        //apply the CSS styles
                        applyChangesHelper(selectors, cssProperty, dimensionValues, getBorderStylesDropdownValue(), getColorpickerValue());
                    });
                }

                //helper function for dimension inputs to be triggered
                function triggerDimensionInputsChange() {
                    $thisClass.$_dimension.find(".dht-dimension-input-size-1").trigger("change");
                }

                //get unit value
                function getUnitsDropdownValue(): string {
                    return $thisClass.$_units.length > 0 ? (String($thisClass.$_units.val()) || "px") : "px";
                }

                //get colorpicker input value
                function getColorpickerValue(): string {
                    return $thisClass.$_colorpicker.length > 0 ? (String($thisClass.$_colorpicker.val()) || "") : "";
                }

                //get border styles dropdown value
                function getBorderStylesDropdownValue(): string {
                    return $thisClass.$_border_style.length > 0 ? (String($thisClass.$_border_style.val()) || "solid") : "solid";
                }

                //get all dimension inputs values and join them
                function getDimensionInputsValues($currentInput: JQuery<HTMLElement>, unit: string): string {
                    // Initialize an array with the current value (i.e., the one that triggered the change event)
                    // Join the dimension values to form the CSS value (top, right, bottom, left)
                    return dimensionInputs.map(input => {
                        if ($currentInput.hasClass(input)) {
                            // Get the value of the current input field
                            const currentValue = String($currentInput.val() ?? "");

                            return currentValue.length === 0 ? 0 : currentValue + unit;
                        } else {
                            const inputElement = $thisClass.$_dimension.find(input);

                            //check if input exist as it could be disabled
                            if (inputElement.length > 0) {
                                const value = String(inputElement.val());
                                return value.length === 0 ? 0 : value + unit;
                            }
                        }
                    }).join(" ");
                }
            } catch (error) {
                errorLoadingModule(error as string);
            }
        }
    }

    //init each dimension option
    function init() {
        $(".dht-field-wrapper-dimension").each(function() {
            new Dimension($(this));
        });
    }

    // Initialize on page load
    $(function() {
        init();
    });

    // Initialize after AJAX content is loaded
    $(document).on("dht_dimensionAjaxComplete", function() {
        init();
    });
})(jQuery);

