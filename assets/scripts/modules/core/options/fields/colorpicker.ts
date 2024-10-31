import { errorLoadingModule } from "@helpers/general";

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
            try {
                const { dhtInitColorpicker } = await import("@helpers/options/colorpicker-utilities");

                //call colorpicker functionality
                this.$_colorpicker.find(".dht-colorpicker").each(function() {
                    dhtInitColorpicker($(this));
                });
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