import jQuery from "jquery";

(function ($: JQueryStatic): void {
    "use strict";

    class DatePicker {
        //datepicker reference
        private $_datepicker;

        private readonly _format;

        constructor($datepicker: JQuery<HTMLElement>) {
            //datepicker reference
            this.$_datepicker = $datepicker;

            //date format
            this._format = $(this).attr("data-format");

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
                dateFormat: this._format,
                beforeShow: function (input: Element, instance: any): {} {
                    // Add a custom className to the datepicker element
                    $(instance.dpDiv).addClass("dht-datepicker-ui");
                    // Return the DatepickerOptions object
                    return {};
                },
            });
        }
    }

    //init each datepicker option
    function init() {
        $(".dht-field-child-datepicker .dht-datepicker").each(function () {
            new DatePicker($(this));
        });
    }

    // Initialize on page load
    $(function () {
        init();
    });

    // Initialize after AJAX content is loaded
    $(document).on("dht_datePickerAjaxComplete", function () {
        init();
    });
})(jQuery);
