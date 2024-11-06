import { errorLoadingModule } from "@helpers/general";
import { dhtNotKeyedSelectorsHelper } from "@helpers/options/live-editing";

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
                const { dhtNotKeyedSelectorsHelper } = await import("@helpers/options/live-editing");

                dhtNotKeyedSelectorsHelper(this.$_input, (target: string, selectors: string) => {
                    this.$_input.on("input change", ".dht-input", function() {
                        const value = String($(this).val());

                        if (target === "content") {
                            $(selectors).text(value);
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
