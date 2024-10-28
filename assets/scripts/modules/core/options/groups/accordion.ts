(function($: JQueryStatic): void {
    "use strict";

    class Accordion {
        //accordion reference
        private $_accordion;

        constructor($accordion: JQuery<HTMLElement>) {
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
        private _initAccordion(): void {
            this.$_accordion
                .children(".dht-accordion")
                .find(".dht-accordion-title")
                .on("click", function(e) {
                    e.preventDefault();

                    const $this = $(this);

                    if ($this.hasClass("dht-accordion-active")) return;

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
    function init() {
        $(".dht-field-wrapper-accordion .dht-field-child-accordion").each(function() {
            new Accordion($(this));
        });
    }

    // Initialize on page load
    $(function() {
        init();
    });

    // Initialize after AJAX content is loaded
    $(document).on("dht_accordionAjaxComplete", function() {
        init();
    });
})(jQuery);
