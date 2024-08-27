import jQuery from "jquery";

(function ($: JQueryStatic): void {
    "use strict";

    class RadioImage {
        //radio images reference
        private $_radioImage;

        constructor($radioImage: JQuery<HTMLElement>) {
            //radio images reference
            this.$_radioImage = $radioImage;

            //init radio images
            this._initRadioImages();
        }

        /**
         * init  radio images
         *
         * @return void
         */
        private _initRadioImages(): void {
            this.$_radioImage.off("click", ".dht-img-select-wrapper").on("click", ".dht-img-select-wrapper", function () {
                const $this = $(this);

                //remove selected class and border
                $this.siblings().removeClass("dht-img-select-wrapper-selected");
                $this.siblings().children(".dht-image-select").removeAttr("checked");

                //add selected class and border
                $this.addClass("dht-img-select-wrapper-selected");
                $this.children(".dht-image-select").attr("checked", "checked");
            });
        }
    }

    //init each radio images option
    function init() {
        $(".dht-field-child-image-select").each(function () {
            new RadioImage($(this));
        });
    }

    // Initialize on page load
    $(function () {
        init();
    });

    // Initialize after AJAX content is loaded
    $(document).on("dht_radioImageAjaxComplete", function () {
        init();
    });
})(jQuery);
