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
         * @return Promise<void>
         */
        private async _liveEditing(): Promise<void> {
            //no live editor attribute
            if (!(this.$_textarea.attr("data-live-selectors") ?? "").length) return;

            try {
                const {
                    dhtApplyChangesForNotKeyedSelectors, dhtRestoreElementDefaultValues,
                } = await import("@helpers/options/live-editing");

                dhtApplyChangesForNotKeyedSelectors(
                    this.$_textarea,
                    // Live change handler
                    (target: string, selectors: string) => {
                        this.$_textarea.on("input change", ".dht-textarea", function() {
                            applyChangesHelper(target, selectors, String($(this).val()));
                        });
                    },
                    //restore to defaults
                    (target: string, selectors: string) => {
                        const defaultValue = String(this.$_textarea.find(".dht-textarea").val());

                        dhtRestoreElementDefaultValues(this.$_textarea, () => {
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
