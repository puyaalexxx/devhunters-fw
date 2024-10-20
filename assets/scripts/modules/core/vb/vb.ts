(function($: JQueryStatic): void {
    "use strict";

    /**
     * Class used to initialize visual builder functionality
     */
    class VB {
        //vb editor area elements (there could be many of them on the page)
        private readonly _vbContainerEditorAreas: JQuery<HTMLElement>;
        //@ts-ignore - translation strings
        private readonly _translationStrings: IVbTranslations = dht_framework_info.translations.vb;

        constructor() {

            //get vb editor areas
            this._vbContainerEditorAreas = this._getVBEditorArea();

            //if not editor area available, skip the rest of the code
            if (this._vbContainerEditorAreas.length === 0) return;

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
        private _getVBEditorArea() {
            const editorElement = $(".dht-vb-enabled  [data-dht-vb-editor='true']");

            return editorElement.length ? editorElement : $();
        }

        /**
         * Surround each vb editor child element with vb container for editing
         *
         * @return void
         */
        private _enableElementVB() {
            this._vbContainerEditorAreas.children().each(function() {
                $(this).wrap(`<div class="dht-vb-element dht-vb-with-border"></div>`);
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
                        dhtInitButtonsGroupComponent(this._vbContainerEditorAreas, this._translationStrings);
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