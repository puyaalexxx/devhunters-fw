import jQuery from "jquery";

(function ($: JQueryStatic): void {
    "use strict";

    $(".dht-field-child-datepicker .dht-datepicker").each(function () {
        const format = $(this).attr("data-format");

        $(this).datepicker({
            dateFormat: format,
            beforeShow: function (input: Element, instance: any): {} {
                // Add a custom className to the datepicker element
                $(instance.dpDiv).addClass("dht-datepicker-ui");
                // Return the DatepickerOptions object
                return {};
            },
        });
    });
})(jQuery);
