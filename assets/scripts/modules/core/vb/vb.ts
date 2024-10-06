(function($: JQueryStatic): void {
    "use strict";

    /**
     * Class used to initialize visual builder functionality
     */
    class VB {
        constructor() {

            this._init();
        }

        /**
         * Init Visual Builder
         *
         * @return void
         */
        private async _init(): Promise<void> {

            await this._loadComponent("disable-enable-vb");
            await this._loadComponent("buttons-group");
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
                let initComponent: InitComponentFunction | undefined;

                switch (module) {
                    case "disable-enable-vb":
                        const disableEnableModule = await import("./components/disable-enable-vb");
                        initComponent = disableEnableModule.dhtInitDisableEnableBuilderButtonsComponent;
                        break;
                    case "buttons-group":
                        const buttonsGroupModule = await import("./components/buttons-group");
                        initComponent = buttonsGroupModule.dhtInitButtonsGroupComponent;
                        break;
                    default:
                        console.error(`Unknown module: ${module}`);
                        return; // Exit if the module name is not recognized
                }

                if (typeof initComponent === "function") {
                    initComponent(); // Call the initialization function
                } else {
                    console.error(`Component ${module} is not a function`);
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