import jQuery from "jquery";

(function ($: JQueryStatic): void {
    "use strict";

    $(".dht-field-child-datetimepicker .dht-datetimepicker").each(function () {
        const date_format = $(this).attr("data-date-format");
        const time_format = $(this).attr("data-time-format");

        $(this).datetimepicker({
            dateFormat: date_format,
            timeFormat: time_format,
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
                // Return the DatepickerOptions object
                return {};
            },
        });
    });
})(jQuery);
