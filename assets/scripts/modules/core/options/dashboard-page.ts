(function($: JQueryStatic): void {
    "use strict";

    class WrapperArea {
        private $_tooltip;

        constructor() {
            this.$_tooltip = $(".dht-wrapper .dht-info-help");

            //init tooltips
            //this._initTooltips();
        }

        /**
         * init tooltips
         *
         * @return void
         */
        private _initTooltips(): void {
            this.$_tooltip.each(function() {
                let $tooltip = $(this);

                $tooltip.on("mouseenter", function() {
                    let $this = $(this);

                    $this.css("position", "relative");
                    $this.html(
                        $this.html() + "<div class='dht-tooltips'><p class='" + $this.attr("data-position") + "'>" + $this.attr("data-tooltips") + "</p></div>",
                    );
                });

                $tooltip.on("mouseleave", function() {
                    let $this = $(this);

                    $this.removeAttr("style");
                    $this.html($this.html().replace(/<div[^]*?<\/div>/, ""));
                });
            });
        }
    }

    //init main wrapper functionality
    function init() {
        new WrapperArea();
    }

    // Initialize on page load
    $(function() {
        init();
    });

    // Initialize after AJAX content is loaded
    $(document).on("dht_mainWrapperAjaxComplete", function() {
        init();
    });
})(jQuery);
