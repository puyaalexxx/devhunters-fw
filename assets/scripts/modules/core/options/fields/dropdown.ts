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
                const { dhtKeyedSelectorsHelper } = await import("@helpers/options/live-editing");

                dhtKeyedSelectorsHelper(this.$_dropdown, (key: string, target: string, selectors: string) => {
                    this.$_dropdown.on("change", ".dht-dropdown", function() {
                        const value = String($(this).val());

                        if (target === "style") {
                            $(selectors).css({ [key]: value });
                        } else if (target === "display") {
                            if (key == value) {
                                $(selectors).show();
                            } else {
                                $(selectors).hide();
                            }
                        }
                    });
                });
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
