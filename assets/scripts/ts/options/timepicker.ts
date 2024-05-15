import jQuery from "jquery";

(function ($: JQueryStatic): void {
    "use strict";

    $(".dht-field-child-timepicker .dht-timepicker").each(function () {
        const format = $(this).attr("data-format");

        $(this).timepicker({
            timeFormat: format,
            interval: 15,
            /* minTime: '10:00am',
            maxTime: '6:00pm',
            startTime: '10:00am',*/
            dynamic: false,
            dropdown: true,
            scrollbar: true,
            // @ts-ignore
            //the timepicker types package does not provide this method with parameters like datepicker
            beforeShow: function (input: Element, instance: any): void {
                // Add a custom className to the datepicker element
                $(instance.dpDiv).addClass("dht-datepicker-ui");
            },
        });
    });
})(jQuery);
