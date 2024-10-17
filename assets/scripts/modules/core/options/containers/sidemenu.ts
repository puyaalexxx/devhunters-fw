(function($: JQueryStatic): void {
    "use strict";

    class SideMenu {
        constructor() {
            //init sidemenu
            this._initSideMenu();
        }

        /**
         * init sidemenu
         *
         * @return void
         */
        private _initSideMenu(): void {
            this._dropownMenuHover();

            this._addRemoveActiveClass();

            this._addDropdownMenuDiv();

            this._enableTabsFunctionality();
        }

        /**
         * show hide dropdown menu on hover
         *
         * @return void
         */
        private _dropownMenuHover(): void {
            $(".dht-cosidebar .dht-cosidebar-header > ul > li").on({
                mouseenter: function() {
                    if (!$(".dht-cosidebar-sub-menu:visible", this).length) {
                        $(".dht-cosidebar-dropdown-menu", this).show();
                        $(this).addClass("hover");
                    }
                },
                mouseleave: function() {
                    $(".dht-cosidebar-dropdown-menu", this).hide();
                    $(this).removeClass("hover");
                },
            });
        }

        /**
         * add remove menu item active class
         *
         * @return void
         */
        private _addRemoveActiveClass(): void {
            $("[dropdown] >li").hover(
                function() {
                    $("ul", this).show();
                    $(this).addClass("dht-cosidebar-active");
                },
                function() {
                    $("ul", this).hide();
                    $(this).removeClass("dht-cosidebar-active");
                },
            );
        }

        /**
         * add dropdown menu div that is shown on hover
         *
         * @return void
         */
        private _addDropdownMenuDiv(): void {
            $(".dht-cosidebar .dht-cosidebar-header >ul >li").each(function() {
                if ($(".dht-cosidebar-sub-menu", this).length) {
                    const html = $(".dht-cosidebar-sub-menu", this).html();
                    $(this).append("<ul dropdown class=\"dht-cosidebar-dropdown-menu\">" + html + "</ul>");
                }
            });
        }

        /**
         * make the side menu as tabs
         *
         * @return void
         */
        private _enableTabsFunctionality(): void {
            //made the menus work like tabs
            $(
                ".dht-cosidebar.dht-cosidebar-tabs .dht-cosidebar-header ul li > a, " +
                ".dht-cosidebar.dht-cosidebar-tabs .dht-cosidebar-header ul li .dht-cosidebar-sub-menu a",
            ).on("click", function(e) {
                e.preventDefault(); // Prevent default anchor behavior

                const $this = $(this);
                const $parent = $this.parents(".dht-cosidebar");
                const $header_area = $this.parents(".dht-cosidebar-header");

                // Get the target tab ID from the href attribute
                let tabId = $this.attr("href")!;

                // Hide all tab contents and remove 'dht-cosidebar-active' class from all tabs
                $header_area.children("ul").find("li").removeClass("dht-cosidebar-active");
                $parent.children(".dht-cosidebar-body").children(".dht-cosidebar-content").removeClass("dht-cosidebar-active");

                // content area made active
                $(tabId).addClass("dht-cosidebar-active");
                //make the li tag active
                $this.parent().addClass("dht-cosidebar-active");

                //if it is a parent menu item, or it is a sub menu item
                if ($this.siblings(".dht-cosidebar-sub-menu").length > 0 || $this.parents(".dht-cosidebar-sub-menu").length > 0) {
                    //if it is a parent menu item only
                    if ($this.siblings(".dht-cosidebar-sub-menu").length > 0) {
                        // get first submenu item id
                        const firstSubmenuTabId = $this.siblings(".dht-cosidebar-sub-menu").children("li:first").children("a").attr("href")!;

                        // first submenu item content area made active
                        $(firstSubmenuTabId).addClass("dht-cosidebar-active");
                    }

                    //first item from submenu
                    $this.siblings(".dht-cosidebar-sub-menu").children("li:first").addClass("dht-cosidebar-active");
                    //make the parent li tag active from the submenu link
                    $this.parents("li").addClass("dht-cosidebar-active");
                }

                //if a dropdown item from the hover was clicked
                if ($this.parents(".dht-cosidebar-dropdown-menu").length > 0) {
                    //get clicked li tag number
                    const li_number = $this.parent().index();

                    //if link clicked from the hover dropdown, we need to make the dht-cosidebar-sub-menu active instead
                    $this
                        .parents(".dht-cosidebar-dropdown-menu")
                        .siblings(".dht-cosidebar-sub-menu")
                        .children("li:eq(" + li_number + ")")
                        .addClass("dht-cosidebar-active");

                    //make the parent li tag active from the submenu link
                    $this.parents("li").addClass("dht-cosidebar-active");

                    $this.parents(".dht-cosidebar-dropdown-menu").hide();
                }
            });
        }
    }

    //init sidemenu
    function init() {
        $(function(): void {
            new SideMenu();
        });
    }

    // Initialize on page load
    $(function() {
        init();
    });

    // Initialize after AJAX content is loaded
    $(document).on("dht_sideMenuAjaxComplete", function() {
        init();
    });
})(jQuery);
