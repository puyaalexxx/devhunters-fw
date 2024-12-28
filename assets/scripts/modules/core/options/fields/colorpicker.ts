import { errorLoadingModule } from "@helpers/general";
import { dhtOnChangeColorpicker } from "@helpers/options/colorpicker-utilities";

(function($: JQueryStatic): void {
    "use strict";

    class ColorPicker {
        //colorpicker reference
        private readonly $_colorpicker;

        constructor($colorpicker: JQuery<HTMLElement>) {
            //borders reference
            this.$_colorpicker = $colorpicker;

            //init colorpickers
            this._initColorpicker().then(() => {
            }).catch(error => {
                console.error(error);
            });
        }

        /**
         * init colorpickers
         *
         * @return void
         */
        private async _initColorpicker(): Promise<void> {
            const $thisClass = this;

            try {
                const { dhtInitColorpicker } = await import("@helpers/options/colorpicker-utilities");

                //call colorpicker functionality
                this.$_colorpicker.find(".dht-colorpicker").each(function() {
                    dhtInitColorpicker($(this));

                    //init live editing
                    $thisClass._liveEditing($(this)).then(() => {
                    }).catch(error => {
                        console.error(error);
                    });
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
         * @param $thisColorpicker ColorPicker element
         *
         * @return Promise<void>
         */
        private async _liveEditing($thisColorpicker: JQuery<HTMLElement>): Promise<void> {
            //no live editor attribute
            if (!(this.$_colorpicker.attr("data-live-selectors") ?? "").length) return;

            try {
                const {
                    dhtApplyChangesForKeyedSelectors, dhtRestoreElementDefaultValues, dhtGetDefaultValue,
                } = await import("@helpers/options/live-editing");
                const { dhtOnChangeColorpicker } = await import("@helpers/options/colorpicker-utilities");

                dhtApplyChangesForKeyedSelectors(
                    this.$_colorpicker,
                    // Live change handler
                    (key: string, target: string, selectors: string) => {
                        if (target === "style") {
                            dhtOnChangeColorpicker($thisColorpicker, (color) => {
                                applyChangesHelper(key, selectors, color);
                            });
                        }
                    },
                    //restore to defaults
                    (key: string, target: string, selectors: string) => {
                        if (target === "style") {
                            dhtRestoreElementDefaultValues(this.$_colorpicker, () => {
                                applyChangesHelper(key, selectors, dhtGetDefaultValue(this.$_colorpicker));
                            });
                        }
                    },
                );

                //helper function to apply the style changes
                function applyChangesHelper(key: string, selectors: string, color: string) {
                    $(selectors).css({ [key]: color });
                }
            } catch (error) {
                errorLoadingModule(error as string);
            }
        }
    }

    //init each colorpicker option
    function init() {
        $(".dht-field-wrapper-colorpicker").each(function() {
            new ColorPicker($(this));
        });
    }

    // Initialize on page load
    $(function() {
        init();
    });

    // Initialize after AJAX content is loaded
    $(document).on("dht_colorPickerAjaxComplete", function() {
        init();
    });
})(jQuery);