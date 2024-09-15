import jQuery from "jquery";
import { dhtInitializePreloader } from "./features/preloader";

(function($: JQueryStatic): void {
    "use strict";

    /**
     * Class used to add general js settings for the framework
     */
    class GeneralScript {
        constructor() {
            this.init();
        }

        init(): void {
            //init preloader feature
            dhtInitializePreloader();
        }
    }

    jQuery(function(): void {
        new GeneralScript();
    });
})(jQuery);