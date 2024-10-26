(function($: JQueryStatic): void {
    "use strict";

    class Textarea {
        //textarea reference
        private $_textarea;

        constructor($textarea: JQuery<HTMLElement>) {
            //textarea reference
            this.$_textarea = $textarea;

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
            const selectors = this.$_textarea.attr("data-live-selectors") ?? "";

            if (selectors.length === 0) return;

            this.$_textarea.on("input", ".dht-textarea", function() {
                const value = $(this).val();

                $(selectors).text(value);
            });
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
