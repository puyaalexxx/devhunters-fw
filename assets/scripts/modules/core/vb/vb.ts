(function($: JQueryStatic): void {
    "use strict";

    /**
     * Class used to initialize visual builder functionality
     */
    class VB {
        //vb module elements (there could be many of them on the page)
        private readonly _vbModule: JQuery<HTMLElement>;
        //@ts-ignore - translation strings
        private readonly _translationStrings: IVbTranslations = dht_framework_info.translations.vb;

        constructor() {

            //get vb modules
            this._vbModule = this._getVBModules();

            //if no modules available, skip the rest of the code
            if (this._vbModule.length === 0) return;

            this._init()
                .then(() => {
                })
                .catch(err => console.error(err));
        }

        /**
         * Init Visual Builder
         *
         * @return void
         */
        private async _init(): Promise<void> {

            //enable builder on each element
            this._enableElementVB();

            //load builder components
            await this._loadComponent("disable-enable-vb");
            await this._loadComponent("buttons-group");
        }

        /**
         * Get the element on which we should enable the VB
         *
         * @return JQuery<HTMLElement>
         */
        private _getVBModules() {
            const module = $(".dht-vb-enabled  [data-dht-vb-editor='true']");

            return module.length ? module : $();
        }

        /**
         * Surround each vb child element with vb module code for editing
         *
         * @return void
         */
        private _enableElementVB() {
            this._vbModule.children().each(function() {
                $(this).wrap(`<div class="dht-vb-module dht-vb-module-with-border"></div>`);
            });
        }

        /**
         * Load a component dynamically
         *
         * @param module - The module to load
         *
         * @return void
         */
        private async _loadComponent(module: string): Promise<void> {
            try {
                switch (module) {
                    case "disable-enable-vb":
                        const { dhtInitDisableEnableBuilderButtonsComponent } = await import("./components/disable-enable-vb");
                        dhtInitDisableEnableBuilderButtonsComponent();
                        break;
                    case "buttons-group":
                        const { dhtInitButtonsGroupComponent } = await import("./components/buttons-group");
                        dhtInitButtonsGroupComponent(this._vbModule, this._translationStrings);
                        break;
                    default:
                        console.error(`Unknown module: ${module}`);
                        return; // Exit if the module name is not recognized
                }
            } catch (error) {
                console.error(`Error loading module ${module}:`, error);
            }
        }
    }

    $(function(): void {
        new VB();
    });
})(jQuery);