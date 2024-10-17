(function($: JQueryStatic): void {
    "use strict";

    class Tabsmenu {
        constructor() {
            //init tabsmenu
            this._inittabsmenu();
        }

        /**
         * init tabsmenu
         *
         * @return void
         */
        private _inittabsmenu(): void {
            $(".dht-tabsmenu-container .dht-field-tabsmenu .dht-tabsmenu-links a").on("click", function(e) {
                e.preventDefault(); // Prevent default anchor behavior

                const $this = $(this);
                const $parent = $this.parents(".dht-field-tabsmenu");

                // Get the target tabsmenu ID from the href attribute
                let tabsmenuId = $this.attr("href")!;

                // Hide all tabsmenu contents and remove 'active' class from all tabsmenu
                $parent.children(".dht-tabsmenu-content").removeClass("active");
                $parent.children(".dht-tabsmenu-links").children("li").removeClass("active");

                // Show the target tabsmenu content and add 'active' class to the clicked tabsmenu
                $(tabsmenuId).addClass("active");
                $this.parent().addClass("active");
            });
        }
    }

    //init tabsmenu container
    function init() {
        $(function(): void {
            new Tabsmenu();
        });
    }

    // Initialize on page load
    $(function() {
        init();
    });

    // Initialize after AJAX content is loaded
    $(document).on("dht_tabsMenuAjaxComplete", function() {
        init();
    });
})(jQuery);
