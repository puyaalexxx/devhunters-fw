"use strict";
(function ($) {
    "use strict";
    class DateTimePicker {
        constructor($datepicker) {
            //datetimepicker reference
            this.$_datetimepicker = $datepicker;
            //init datetimepicker
            this._initDateTimePicker();
        }
        /**
         * init datetimepicker
         *
         * @return void
         */
        _initDateTimePicker() {
            this.$_datetimepicker.datetimepicker({
                dateFormat: this.$_datetimepicker.attr("data-date-format"),
                timeFormat: this.$_datetimepicker.attr("data-time-format"),
                //interval: 15,
                /* minTime: '10:00am',
                maxTime: '6:00pm',
                startTime: '10:00am',*/
                //dynamic: false,
                //dropdown: true,
                // scrollbar: true,
                beforeShow: function (input, instance) {
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
        $(".dht-field-wrapper .dht-field-child-datetimepicker .dht-datetimepicker").each(function () {
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
