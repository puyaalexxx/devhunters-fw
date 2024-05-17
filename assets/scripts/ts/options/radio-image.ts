import jQuery from "jquery";

(function ($: JQueryStatic): void {
    "use strict";

    $(".dht-wrapper .dht-field-child-image-select .dht-img-select-wrapper").on("click", function () {
        //remove selected class and border
        $(this).siblings().removeClass("dht-img-select-wrapper-selected");
        $(this).siblings().children(".dht-image-select").removeAttr("checked");

        //add selected class and border
        $(this).addClass("dht-img-select-wrapper-selected");
        $(this).children(".dht-image-select").attr("checked", "checked");
    });
})(jQuery);
