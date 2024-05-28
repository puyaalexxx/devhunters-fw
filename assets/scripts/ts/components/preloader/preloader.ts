import jQuery from "jquery";

(function ($: JQueryStatic): void {
    "use strict";

    const $dht_preloader = $("#dht-preloader");
    const delay = $dht_preloader.attr("data-delay")!;

    // Set a timeout to hide the preloader after 3 seconds (3000 milliseconds)
    setTimeout(function () {
        // Hide the preloader
        $dht_preloader.fadeOut("slow");
    }, +delay); // Change the value to the desired delay in milliseconds
})(jQuery);
