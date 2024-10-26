(function($: JQueryStatic): void {
    "use strict";

    class Input {
        //input reference
        private $_input;

        constructor($input: JQuery<HTMLElement>) {
            //input reference
            this.$_input = $input;

            //init live editing
            this._liveEditing();
        }

        /**
         * live editing
         * Ability to change other areas via changing the field
         * with the provided CSS selectors
         *
         * @return void
         */
        private _liveEditing(): void {
            const selectors = this.$_input.attr("data-live-selectors") ?? "";

            if (selectors.length === 0) return;

            this.$_input.on("input", ".dht-input", function() {
                const value = $(this).val();

                $(selectors).text(value);
            });
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
