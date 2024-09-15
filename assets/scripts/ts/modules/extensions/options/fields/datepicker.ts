import jQuery from "jquery";

(function($: JQueryStatic): void {
    "use strict";

    class DatePicker {
        //datepicker reference
        private $_datepicker;

        constructor($datepicker: JQuery<HTMLElement>) {
            //datepicker reference
            this.$_datepicker = $datepicker;

            //init datepicker
            this._initDatePicker();
        }

        /**
         * init datepicker
         *
         * @return void
         */
        private _initDatePicker(): void {
            this.$_datepicker.datepicker({
                dateFormat: this.$_datepicker.attr("data-format"),
                beforeShow: function(input: Element, instance: any): {} {
                    // Add a custom className to the datepicker element
                    $(instance.dpDiv).addClass("dht-datepicker-ui");

                    // Move the datepicker to a specific container
                    setTimeout(function() {
                        $("#ui-datepicker-div.dht-datepicker-ui").insertAfter($(input));
                    }, 10); // Delay to ensure the datepicker is created before moving it
                    return {};
                },
            });
        }
    }

    //init each datepicker option
    function init() {
        $(".dht-field-wrapper .dht-field-child-datepicker .dht-datepicker").each(function() {
            new DatePicker($(this));
        });
    }

    // Initialize on page load
    $(function() {
        init();
    });

    // Initialize after AJAX content is loaded
    $(document).on("dht_datePickerAjaxComplete", function() {
        init();
    });
})(jQuery);
