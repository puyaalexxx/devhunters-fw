import jQuery from "jquery";

(function ($: JQueryStatic): void {
    "use strict";

    class DateTimePicker {
        //datetimepicker reference
        private $_datetimepicker;
        private readonly _format;
        private readonly _time_format;

        constructor($datepicker: JQuery<HTMLElement>) {
            //datetimepicker reference
            this.$_datetimepicker = $datepicker;

            this._format = $(this).attr("data-date-format");
            this._time_format = $(this).attr("data-time-format");

            //init datetimepicker
            this._initDateTimePicker();
        }

        /**
         * init datetimepicker
         *
         * @return void
         */
        private _initDateTimePicker(): void {
            this.$_datetimepicker.datetimepicker({
                dateFormat: this._format,
                timeFormat: this._time_format,
                //interval: 15,
                /* minTime: '10:00am',
                maxTime: '6:00pm',
                startTime: '10:00am',*/
                //dynamic: false,
                //dropdown: true,
                // scrollbar: true,
                beforeShow: function (input: Element, instance: any): {} {
                    // Add a custom className to the datepicker element
                    $(instance.dpDiv).addClass("dht-datepicker-ui");

                    // Move the datepicker to a specific container
                    setTimeout(function () {
                        $("#ui-datepicker-div.dht-datepicker-ui").insertAfter($(input));
                    }, 10); // Delay to ensure the datepicker is created before moving it
                    // Return the DatepickerOptions object
                    return {};
                },
            });
        }
    }

    //init each datetimepicker option
    function init() {
        $(".dht-field-child-datetimepicker .dht-datetimepicker").each(function () {
            new DateTimePicker($(this));
        });
    }

    // Initialize on page load
    $(function () {
        init();
    });

    // Initialize after AJAX content is loaded
    $(document).on("dht_dateTimePickerAjaxComplete", function () {
        init();
    });
})(jQuery);
