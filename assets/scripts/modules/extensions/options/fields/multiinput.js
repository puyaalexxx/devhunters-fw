"use strict";
(function ($) {
    "use strict";
    class MultiInput {
        constructor($multiinput) {
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
        _addInput() {
            this.$_multiinput.off("click", ".dht-multiinput-add").on("click", ".dht-multiinput-add", function () {
                let $this = $(this);
                let limit = +$this.attr("data-limit");
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
        _removeInput() {
            this.$_multiinput.off("click", ".dht-multiinput-remove").on("click", ".dht-multiinput-remove", function () {
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
        $(".dht-field-wrapper .dht-field-child-multiinput").each(function () {
            new MultiInput($(this));
        });
    }
    // Initialize on page load
    $(function () {
        init();
    });
    // Initialize after AJAX content is loaded
    $(document).on("dht_multiInputAjaxComplete", function () {
        init();
    });
})(jQuery);
