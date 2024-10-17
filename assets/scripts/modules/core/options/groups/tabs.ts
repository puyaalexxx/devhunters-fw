(function($: JQueryStatic): void {
    "use strict";

    class Tabs {
        //tabs reference
        private $_tabs;

        constructor($tabs: JQuery<HTMLElement>) {
            //tabs reference
            this.$_tabs = $tabs;

            //init tabs
            this._initTabs();
        }

        /**
         * init tabs
         *
         * @return void
         */
        private _initTabs(): void {
            this.$_tabs.find(".dht-tab-links a").on("click", function(e) {
                e.preventDefault(); // Prevent default anchor behavior

                const $this = $(this);
                const $parent = $this.parents(".dht-field-tabs");

                // Get the target tab ID from the href attribute
                let tabId = $this.attr("href")!;

                // Hide all tab contents and remove 'active' class from all tabs
                $parent.children(".dht-tab-content").removeClass("active");
                $parent.children(".dht-tab-links").children("li").removeClass("active");

                // Show the target tab content and add 'active' class to the clicked tab
                $(tabId).addClass("active");
                $this.parent().addClass("active");
            });
        }
    }

    //init each tabs group
    function init() {
        $(".dht-field-wrapper .dht-field-child-tabs").each(function() {
            new Tabs($(this));
        });
    }

    // Initialize on page load
    $(function() {
        init();
    });

    // Initialize after AJAX content is loaded
    $(document).on("dht_tabsAjaxComplete", function() {
        init();
    });
})(jQuery);
