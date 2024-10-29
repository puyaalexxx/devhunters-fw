//import "./colorpicker";

(function($: JQueryStatic): void {
    "use strict";

    class Borders {
        //borders reference
        private $_borders;

        constructor($borders: JQuery<HTMLElement>) {
            //borders reference
            this.$_borders = $borders;

            //init borders
            this._initBorders()
                .then(() => {
                })
                .catch(error => {
                    console.error(error);
                });
        }

        /**
         * init borders
         *
         * @return void
         */
        private async _initBorders(): Promise<void> {
            //initialize colorpicker
            try {
                const { dhtInitColorpicker } = await import("@helpers/options/colorpicker-utilities");

                //call colorpicker functionality
                this.$_borders.find(".dht-colorpicker").each(function() {
                    dhtInitColorpicker($(this));
                });
            } catch (error) {
                console.error("Error loading module:", error);
            }
        }
    }

    //init each borders option
    function init() {
        $(".dht-field-wrapper-borders").each(function() {
            new Borders($(this));
        });
    }

    // Initialize on page load
    $(function() {
        init();
    });

    // Initialize after AJAX content is loaded
    $(document).on("dht_bordersAjaxComplete", function() {
        init();
    });
})(jQuery);

