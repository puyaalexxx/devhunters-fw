import { dhtInitializePreloader } from "./features/preloader";

(function($: JQueryStatic): void {
    "use strict";

    /**
     * Class used to add general js settings for the framework
     *
     * some testing comments
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

    $(function(): void {
        new GeneralScript();
    });
})(jQuery);