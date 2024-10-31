import { errorLoadingModule } from "@helpers/general";
import { dhtApplyLiveChanges } from "@helpers/options/live-editing";

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
         * @return void
         */
        private async _liveEditing(): Promise<void> {
            try {
                const {
                    dhtGetLiveEditingSelectors,
                    dhtApplyLiveChanges,
                } = await import("@helpers/options/live-editing");

                //get option selectors
                const selectors: ILiveEditorSelectorTarget = dhtGetLiveEditingSelectors(this.$_input);

                if (Object.entries(selectors).length === 0) return;

                this.$_input.on("input", ".dht-input", function() {
                    const value = String($(this).val());

                    dhtApplyLiveChanges(selectors, (selector) => {
                        if (selectors.target === "content") {
                            $(selector).text(value);
                        } else {
                            $(selector).css(selectors.target, value);
                        }
                    });
                });
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
