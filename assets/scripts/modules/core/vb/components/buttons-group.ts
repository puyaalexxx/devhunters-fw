"use strict";

import { errorLoadingModule } from "@helpers/general";

/**
 * Class used to initialize vb buttons group area
 */
class ButtonsGroup {
    //vb module element
    private readonly _vbModule: JQuery<HTMLElement>;
    //hidden input class for modal saved values
    private readonly _hiddenInputClass = "dht-modal-saved-values";
    //translated strings
    private readonly _translationStrings: IVbTranslations;

    constructor(vbModule: JQuery<HTMLElement>, translationStrings: IVbTranslations) {

        this._vbModule = vbModule;
        this._translationStrings = translationStrings;

        //init toggle button
        this._init();
    }

    /**
     * Init Buttons Group
     *
     * @return void
     */
    private _init(): void {

        const $this = this;
        //go through each VB module element
        this._vbModule.each(function() {
            //get module name and id
            const modalID = $(this).attr("data-dht-vb-module-id") ?? "";
            const moduleName = $(this).attr("data-dht-vb-module-name") ?? "";

            $this._addButtonsOnElement($(this));

            $this._openModalOnClick({
                $vbModule: $(this),
                modalID: modalID,
                moduleName: moduleName,
                hiddenInputClass: $this._hiddenInputClass,
            });

            $this._addSavedValuesInput({
                $vbModule: $(this),
                modalID: modalID,
                moduleName: moduleName,
                hiddenInputClass: $this._hiddenInputClass,
            });
        });
    }

    /**
     * Add buttons group HTML code to each vb module
     *
     * @param $vbModule Module element
     *
     * @return void
     */
    private _addButtonsOnElement($vbModule: JQuery<HTMLElement>): void {

        const $this = this;
        $vbModule.find(".dht-vb-module").each(function() {
            let btnDrag = "";
            let btnSettings = "";
            let btnDuplicate = "";
            let btnDelete = "";
            let btnOtherSetting = "";

            //drag button
            if ($vbModule.attr("data-dht-vb-button-drag") === "true") {
                btnDrag = `<button type="button" class="dht-vb-button dht-vb-icon-drag">
                                <div class="dht-vb-icon">
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512">
                                        <path d="M278.6 9.4c-12.5-12.5-32.8-12.5-45.3 0l-64 64c-12.5 12.5-12.5 32.8 0 45.3s32.8 12.5 45.3 0l9.4-9.4L224 224l-114.7 0 9.4-9.4c12.5-12.5 12.5-32.8 0-45.3s-32.8-12.5-45.3 0l-64 64c-12.5 12.5-12.5 32.8 0 45.3l64 64c12.5 12.5 32.8 12.5 45.3 0s12.5-32.8 0-45.3l-9.4-9.4L224 288l0 114.7-9.4-9.4c-12.5-12.5-32.8-12.5-45.3 0s-12.5 32.8 0 45.3l64 64c12.5 12.5 32.8 12.5 45.3 0l64-64c12.5-12.5 12.5-32.8 0-45.3s-32.8-12.5-45.3 0l-9.4 9.4L288 288l114.7 0-9.4 9.4c-12.5 12.5-12.5 32.8 0 45.3s32.8 12.5 45.3 0l64-64c12.5-12.5 12.5-32.8 0-45.3l-64-64c-12.5-12.5-32.8-12.5-45.3 0s-12.5 32.8 0 45.3l9.4 9.4L288 224l0-114.7 9.4 9.4c12.5 12.5 32.8 12.5 45.3 0s12.5-32.8 0-45.3l-64-64z" />
                                    </svg>
                                </div>
                                <div class='dht-vb-tooltip'><p class='on-bottom'>${$this._translationStrings.icon_drag}</p></div>
                           </button>`;
            }
            //settings button
            if ($vbModule.attr("data-dht-vb-button-settings") === "true") {
                btnSettings = `<button type="button" class="dht-vb-button dht-vb-icon-setting">
                                    <div class="dht-vb-icon">
                                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512">
                                            <path d="M495.9 166.6c3.2 8.7 .5 18.4-6.4 24.6l-43.3 39.4c1.1 8.3 1.7 16.8 1.7 25.4s-.6 17.1-1.7 25.4l43.3 39.4c6.9 6.2 9.6 15.9 6.4 24.6c-4.4 11.9-9.7 23.3-15.8 34.3l-4.7 8.1c-6.6 11-14 21.4-22.1 31.2c-5.9 7.2-15.7 9.6-24.5 6.8l-55.7-17.7c-13.4 10.3-28.2 18.9-44 25.4l-12.5 57.1c-2 9.1-9 16.3-18.2 17.8c-13.8 2.3-28 3.5-42.5 3.5s-28.7-1.2-42.5-3.5c-9.2-1.5-16.2-8.7-18.2-17.8l-12.5-57.1c-15.8-6.5-30.6-15.1-44-25.4L83.1 425.9c-8.8 2.8-18.6 .3-24.5-6.8c-8.1-9.8-15.5-20.2-22.1-31.2l-4.7-8.1c-6.1-11-11.4-22.4-15.8-34.3c-3.2-8.7-.5-18.4 6.4-24.6l43.3-39.4C64.6 273.1 64 264.6 64 256s.6-17.1 1.7-25.4L22.4 191.2c-6.9-6.2-9.6-15.9-6.4-24.6c4.4-11.9 9.7-23.3 15.8-34.3l4.7-8.1c6.6-11 14-21.4 22.1-31.2c5.9-7.2 15.7-9.6 24.5-6.8l55.7 17.7c13.4-10.3 28.2-18.9 44-25.4l12.5-57.1c2-9.1 9-16.3 18.2-17.8C227.3 1.2 241.5 0 256 0s28.7 1.2 42.5 3.5c9.2 1.5 16.2 8.7 18.2 17.8l12.5 57.1c15.8 6.5 30.6 15.1 44 25.4l55.7-17.7c8.8-2.8 18.6-.3 24.5 6.8c8.1 9.8 15.5 20.2 22.1 31.2l4.7 8.1c6.1 11 11.4 22.4 15.8 34.3zM256 336a80 80 0 1 0 0-160 80 80 0 1 0 0 160z" />
                                        </svg>
                                    </div>
                                    <div class='dht-vb-tooltip'><p class='on-bottom'>${$this._translationStrings.icon_settings}</p></div>
                                </button>`;
            }
            //duplicate button
            if ($vbModule.attr("data-dht-vb-button-duplicate") === "true") {
                btnDuplicate = `<button type="button" class="dht-vb-button dht-vb-icon-duplicate">
                                <div class="dht-vb-icon">
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512">
                                        <path d="M288 448L64 448l0-224 64 0 0-64-64 0c-35.3 0-64 28.7-64 64L0 448c0 35.3 28.7 64 64 64l224 0c35.3 0 64-28.7 64-64l0-64-64 0 0 64zm-64-96l224 0c35.3 0 64-28.7 64-64l0-224c0-35.3-28.7-64-64-64L224 0c-35.3 0-64 28.7-64 64l0 224c0 35.3 28.7 64 64 64z" />
                                    </svg>
                                </div>
                                <div class='dht-vb-tooltip'><p class='on-bottom'>${$this._translationStrings.icon_duplicate}</p></div>
                             </button>`;
            }
            //delete button
            if ($vbModule.attr("data-dht-vb-button-delete") === "true") {
                btnDelete = `<button type="button" class="dht-vb-button dht-vb-icon-delete">
                                <div class="dht-vb-icon">
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512">
                                        <path d="M135.2 17.7L128 32 32 32C14.3 32 0 46.3 0 64S14.3 96 32 96l384 0c17.7 0 32-14.3 32-32s-14.3-32-32-32l-96 0-7.2-14.3C307.4 6.8 296.3 0 284.2 0L163.8 0c-12.1 0-23.2 6.8-28.6 17.7zM416 128L32 128 53.2 467c1.6 25.3 22.6 45 47.9 45l245.8 0c25.3 0 46.3-19.7 47.9-45L416 128z" />
                                    </svg>
                                </div>
                                <div class='dht-vb-tooltip'><p class='on-bottom'>${$this._translationStrings.icon_delete}</p></div>
                            </button>`;
            }
            //other settings button
            if ($vbModule.attr("data-dht-vb-button-other-settings") === "true") {
                btnOtherSetting = `<button type="button" class="dht-vb-button dht-vb-icon-other-setting">
                                        <div class="dht-vb-icon">
                                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 128 512">
                                                <path d="M64 360a56 56 0 1 0 0 112 56 56 0 1 0 0-112zm0-160a56 56 0 1 0 0 112 56 56 0 1 0 0-112zM120 96A56 56 0 1 0 8 96a56 56 0 1 0 112 0z" />
                                            </svg>
                                        </div>
                                        <div class='dht-vb-tooltip'><p class='on-bottom'>${$this._translationStrings.icon_other_settings}</p></div>
                                    </button>`;
            }

            const buttonsGroupHTML = `
                <div class="dht-vb-buttons-group-container">
                    <div class="dht-vb-button-group">
                        ${btnDrag}
                        ${btnSettings}
                        ${btnDuplicate}
                        ${btnDelete}
                        ${btnOtherSetting}
                    </div>
                </div>
            `;

            $(this).prepend(buttonsGroupHTML);
        });
    }

    /**
     * Open modal on clicking the settings icon
     *
     * @param moduleInfo All module required info
     *
     * @return void
     */
    private _openModalOnClick(moduleInfo: ModuleInfo): void {
        const $this = this;
        const { $vbModule, modalID, moduleName } = moduleInfo;

        $vbModule.find(".dht-vb-buttons-group-container").on("click", ".dht-vb-button.dht-vb-icon-setting", function(event) {
            event.preventDefault();

            //some error handling
            if (modalID.length === 0 || moduleName.length === 0) {
                if (modalID.length === 0) console.error("Please provide a unque module id");
                if (moduleName.length === 0) console.error("No module name provided");
                return;
            }

            //init modal component
            $this._initModalComponent(moduleInfo)
                .then(() => {
                    //open the modal
                    $("#dht-modal-" + modalID).dhtVBModal("open");

                    //disable all editing buttons area (change it when the feature to open several popus will be added)
                    $(".dht-vb-module").addClass("dht-vb-disabled");
                })
                .catch(error => {
                    console.error(error);
                });
        });
    }

    /**
     * init modal component
     *
     * @param moduleInfo All module required info
     *
     * @return void
     */
    private async _initModalComponent(moduleInfo: ModuleInfo): Promise<void> {
        const { modalID } = moduleInfo;

        try {
            const { dhtCreateVBModal } = await import("./modal");

            //add modal HTML to the VB container
            dhtCreateVBModal({ ...moduleInfo, modalTitle: this._translationStrings.modal_title });

            //init modal
            $("#dht-modal-" + modalID).dhtVBModal({
                autoClose: false,
                pos_y: "50",
                movable: true,
                resizable: true,
                touchOutsideForClose: false,
            });

        } catch (error) {
            errorLoadingModule(error as string);
        }
    }

    /**
     * add hidden input for modal saved values to the module container
     *
     * @param moduleInfo All module required info
     *
     * @return void
     */
    private _addSavedValuesInput(moduleInfo: ModuleInfo): void {
        const { $vbModule, modalID, moduleName, hiddenInputClass } = moduleInfo;

        $vbModule.append(`<input type="hidden" name="dht-fw-modules[${moduleName}][${modalID}]" class="${hiddenInputClass}" value="">`);
    }

}

//init each button groups area
export function dhtInitButtonsGroupComponent(vbModule: JQuery<HTMLElement>, translationStrings: IVbTranslations): void {
    new ButtonsGroup(vbModule, translationStrings);
}