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
            //remove selected class and border
            this.$_radioImage.siblings().removeClass("dht-img-select-wrapper-selected");
            this.$_radioImage.siblings().children(".dht-image-select").removeAttr("checked");

            //add selected class and border
            this.$_radioImage.addClass("dht-img-select-wrapper-selected");
            this.$_radioImage.children(".dht-image-select").attr("checked", "checked");
        }
    }

    //init each radio images option
    $(".dht-wrapper .dht-field-child-image-select .dht-img-select-wrapper").on("click", function () {
        new RadioImage($(this));
    });
})(jQuery);
