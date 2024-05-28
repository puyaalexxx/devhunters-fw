import jQuery from "jquery";

(function ($: JQueryStatic): void {
    "use strict";

    class TimePicker {
        //timePicker reference
        private $_timePicker;
        private readonly $_format;

        constructor($timePicker: JQuery<HTMLElement>) {
            //timePicker reference
            this.$_timePicker = $timePicker;

            this.$_format = this.$_timePicker.attr("data-format");

            //init timePicker
            this._initTimePicker();
        }

        /**
         * init timePicker
         *
         * @return void
         */
        private _initTimePicker(): void {
            this.$_timePicker.timepicker({
                timeFormat: this.$_format,
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
        }
    }

    //init each timePicker option
    $(".dht-field-child-timepicker .dht-timepicker").each(function () {
        new TimePicker($(this));
    });
})(jQuery);
