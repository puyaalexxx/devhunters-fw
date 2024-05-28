import jQuery from "jquery";

(function ($: JQueryStatic): void {
    "use strict";

    class MultiInput {
        //multiinput reference
        private $_multiinput;

        constructor($multiinput: JQuery<Document>) {
            //multiinput reference
            this.$_multiinput = $multiinput;

            //add inout
            this._addInput();

            //add inout
            this._removeInput();
        }

        /**
         * add input
         *
         * @return void
         */
        private _addInput(): void {
            this.$_multiinput.on("click", ".dht-multiinput-add", function () {
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
            this.$_multiinput.on("click", ".dht-multiinput-remove", function () {
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
    $(".dht-field-child-multiinput").each(function () {
        $(function (): void {
            new MultiInput($(this));
        });
    });
})(jQuery);
