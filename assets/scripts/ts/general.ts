import { dhtInitializePreloader } from "./features/preloader";
import jQuery from "jquery";

(function ($: JQueryStatic): void {
    "use strict";

    /**
     * Class used to create and delete custom sidebars
     */
    class GeneralScript {
        constructor() {
            // initialize the preloader
            dhtInitializePreloader($);
        }
    }

    $(function (): void {
        new GeneralScript();
    });
})(jQuery);
