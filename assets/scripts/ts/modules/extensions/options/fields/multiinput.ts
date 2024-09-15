import jQuery from "jquery";

(function($: JQueryStatic): void {
    "use strict";

    class MultiInput {
        //multiinput reference
        private $_multiinput;

        constructor($multiinput: JQuery<HTMLElement>) {
            //multiinput reference
            this.$_multiinput = $multiinput;

            //add input
            this._addInput();

            //add input
            this._removeInput();
        }

        /**
         * add input
         *
         * @return void
         */
        private _addInput(): void {
            this.$_multiinput.off("click", ".dht-multiinput-add").on("click", ".dht-multiinput-add", function() {
                let $this = $(this);
                let limit: number = +$this.attr("data-limit")!;

                if ($this.parents(".dht-field-child-multiinput").children(".dht-multiinput-child-wrapper").length >= limit) {
                    confirm($(this).attr("data-add-text"));

                    return false;
                }
                let $field = $this.prev(".dht-multiinput-child-wrapper").clone();

                $field.children("input").val("");

                $field.insertBefore($this);
            });
        }

        /**
         * remove input
         *
         * @return void
         */
        private _removeInput(): void {
            this.$_multiinput.off("click", ".dht-multiinput-remove").on("click", ".dht-multiinput-remove", function() {
                let $this = $(this);

                if ($this.parents(".dht-field-child-wrapper").children(".dht-multiinput-child-wrapper").length === 1) {
                    confirm($(this).attr("data-remove-text"));

                    return;
                }

                $this.parent(".dht-multiinput-child-wrapper").remove();
            });
        }
    }

    //init each multiinput option
    function init() {
        $(".dht-field-wrapper .dht-field-child-multiinput").each(function() {
            new MultiInput($(this));
        });
    }

    // Initialize on page load
    $(function() {
        init();
    });

    // Initialize after AJAX content is loaded
    $(document).on("dht_multiInputAjaxComplete", function() {
        init();
    });
})(jQuery);
