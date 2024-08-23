import jQuery from "jquery";

(function ($: JQueryStatic): void {
    "use strict";

    class MultiInput {
        constructor() {
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
            $(".dht-field-wrapper").on("click", ".dht-field-child-multiinput .dht-multiinput-add", function () {
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
            $(".dht-field-wrapper").on("click", ".dht-field-child-multiinput .dht-multiinput-remove", function () {
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
    $(function (): void {
        new MultiInput();
    });
})(jQuery);
