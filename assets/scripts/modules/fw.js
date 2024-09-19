import { dhtInitializePreloader } from "./features/preloader";
(function ($) {
    "use strict";
    /**
     * Class used to add general js settings for the framework
     */
    class GeneralScript {
        constructor() {
            this.init();
        }
        init() {
            //init preloader feature
            dhtInitializePreloader();
        }
    }
    $(function () {
        new GeneralScript();
    });
})(jQuery);
