"use strict";
(function ($) {
    "use strict";
    class Accordion {
        constructor($accordion) {
            //tabs reference
            this.$_accordion = $accordion;
            //init accordion
            this._initAccordion();
        }
        /**
         * init accordion
         *
         * @return void
         */
        _initAccordion() {
            this.$_accordion
                .children(".dht-accordion")
                .find(".dht-accordion-title")
                .on("click", function (e) {
                e.preventDefault();
                const $this = $(this);
                if ($this.hasClass("dht-accordion-active"))
                    return;
                const $parent = $this.parents(".dht-accordion");
                if (!$this.hasClass("dht-accordion-active")) {
                    $parent.find(".dht-accordion-content").slideUp(400);
                    $parent.find(".dht-accordion-title").removeClass("dht-accordion-active");
                    $parent.find(".dht-accordion-arrow").removeClass("dht-accordion-icon-change");
                }
                $this.toggleClass("dht-accordion-active");
                $this.next().slideToggle();
                $(".dht-accordion-arrow", $this).toggleClass("dht-accordion-icon-change");
            });
        }
    }
    //init each accordion group
    $(".dht-field-wrapper .dht-field-child-accordion").each(function () {
        new Accordion($(this));
    });
})(jQuery);
