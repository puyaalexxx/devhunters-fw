(function($: JQueryStatic): void {
    "use strict";

    class Panel {
        //panel reference
        private $_panel;

        constructor($panel: JQuery<HTMLElement>) {
            //tabs reference
            this.$_panel = $panel;

            //init panel
            this._initPanel();
        }

        /**
         * init panel
         *
         * @return void
         */
        private _initPanel(): void {
            this.$_panel
                .children(".dht-panel")
                .find(".dht-panel-title")
                .on("click", function(e) {
                    e.preventDefault();

                    const $this = $(this);
                    
                    const $parent = $this.parents(".dht-panel");

                    if (!$this.hasClass("dht-panel-active")) {
                        $parent.find(".dht-panel-content").slideUp(400);
                        $parent.find(".dht-panel-title").removeClass("dht-panel-active");
                        $parent.find(".dht-panel-arrow").removeClass("dht-panel-icon-change");
                    }

                    $this.toggleClass("dht-panel-active");
                    $this.next().slideToggle();
                    $(".dht-panel-arrow", $this).toggleClass("dht-panel-icon-change");
                });
        }
    }

    //init each panel group
    function init() {
        $(".dht-field-wrapper-panel .dht-field-child-panel").each(function() {
            new Panel($(this));
        });
    }

    // Initialize on page load
    $(function() {
        init();
    });

    // Initialize after AJAX content is loaded
    $(document).on("dht_panelAjaxComplete", function() {
        init();
    });
})(jQuery);
