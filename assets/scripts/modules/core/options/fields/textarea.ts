import { errorLoadingModule } from "@helpers/general";

(function($: JQueryStatic): void {
    "use strict";

    class Textarea {
        //textarea reference
        private readonly $_textarea;

        constructor($textarea: JQuery<HTMLElement>) {
            //textarea reference
            this.$_textarea = $textarea;

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
                const selectors: ILiveEditorSelectorTarget = dhtGetLiveEditingSelectors(this.$_textarea);

                if (Object.entries(selectors).length === 0) return;

                this.$_textarea.on("input", ".dht-textarea", function() {
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

    //init each textarea option
    function init() {
        $(".dht-field-wrapper-textarea").each(function() {
            new Textarea($(this));
        });
    }

    // Initialize on page load
    $(function() {
        init();
    });

    // Initialize after AJAX content is loaded
    $(document).on("dht_textareaAjaxComplete", function() {
        init();
    });
})(jQuery);
