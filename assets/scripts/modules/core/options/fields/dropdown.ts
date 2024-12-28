import { errorLoadingModule } from "@helpers/general";

(function($: JQueryStatic): void {
    "use strict";

    class Dropdown {
        //dropdown reference
        private readonly $_dropdown;

        constructor($dropdown: JQuery<HTMLElement>) {
            //dropdown reference
            this.$_dropdown = $dropdown;

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
            if (!(this.$_dropdown.attr("data-live-selectors") ?? "").length) return;

            try {
                const {
                    dhtApplyChangesForKeyedSelectors, dhtRestoreElementDefaultValues,
                } = await import("@helpers/options/live-editing");

                dhtApplyChangesForKeyedSelectors(
                    this.$_dropdown,
                    // Live change handler
                    (key: string, target: string, selectors: string) => {
                        this.$_dropdown.on("change", ".dht-dropdown", function() {
                            applyChangesHelper(target, selectors, key, String($(this).val()));
                        });
                    },
                    //restore to defaults
                    (key: string, target: string, selectors: string) => {
                        //on closing the modal (restore to defaults)
                        const defaultValue = String(this.$_dropdown.find(".dht-dropdown").val());
                        dhtRestoreElementDefaultValues(this.$_dropdown, () => {
                            applyChangesHelper(target, selectors, key, defaultValue);
                        });
                    },
                );

                //helper function to apply the style changes
                function applyChangesHelper(target: string, selectors: string, key: string, value: string) {
                    if (target === "style") {
                        $(selectors).css({ [key]: value });
                    } else if (target === "display") {
                        if (key == value) {
                            $(selectors).show();
                        } else {
                            $(selectors).hide();
                        }
                    }
                }
            } catch (error) {
                errorLoadingModule(error as string);
            }
        }
    }

    //init each dropdown option
    function init() {
        $(".dht-field-wrapper-dropdown").each(function() {
            new Dropdown($(this));
        });
    }

    // Initialize on page load
    $(function() {
        init();
    });

    // Initialize after AJAX content is loaded
    $(document).on("dht_dropdownAjaxComplete", function() {
        init();
    });
})(jQuery);
