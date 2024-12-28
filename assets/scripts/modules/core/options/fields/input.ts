import { errorLoadingModule } from "@helpers/general";
import { dhtApplyChangesForNotKeyedSelectors } from "@helpers/options/live-editing";

(function($: JQueryStatic): void {
    "use strict";

    class Input {
        //input reference
        private readonly $_input;

        constructor($input: JQuery<HTMLElement>) {
            //input reference
            this.$_input = $input;

            //init live editing
            this._liveEditing().then(() => {
            }).catch(error => {
                console.error(error);
            });
        }

        /**
         * live editing
         * Ability to change other areas via changing the field
         * with the provided CSS selectors
         *
         * @return Promise<void>
         */
        private async _liveEditing(): Promise<void> {
            //no live editor attribute
            if (!(this.$_input.attr("data-live-selectors") ?? "").length) return;

            try {
                const {
                    dhtApplyChangesForNotKeyedSelectors, dhtRestoreElementDefaultValues,
                } = await import("@helpers/options/live-editing");

                dhtApplyChangesForNotKeyedSelectors(
                    this.$_input,
                    // Live change handler
                    (target: string, selectors: string) => {
                        this.$_input.on("input change", ".dht-input", function() {
                            applyChangesHelper(target, selectors, String($(this).val()));
                        });
                    },
                    //restore to defaults
                    (target: string, selectors: string) => {
                        const defaultValue = String(this.$_input.find(".dht-input").val());

                        dhtRestoreElementDefaultValues(this.$_input, () => {
                            applyChangesHelper(target, selectors, defaultValue);
                        });
                    },
                );

                //helper function to apply the content changes
                function applyChangesHelper(target: string, selectors: string, value: string) {
                    if (target === "content") {
                        $(selectors).text(value);
                    }
                }
            } catch (error) {
                errorLoadingModule(error as string);
            }
        }
    }

    //init each input option
    function init() {
        $(".dht-field-wrapper-input").each(function() {
            new Input($(this));
        });
    }

    // Initialize on page load
    $(function() {
        init();
    });

    // Initialize after AJAX content is loaded
    $(document).on("dht_inputAjaxComplete", function() {
        init();
    });
})(jQuery);
