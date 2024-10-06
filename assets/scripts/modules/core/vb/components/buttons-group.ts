"use strict";

/**
 * Class used to initialize vb buttons group area
 */
class ButtonsGroup {

    //buttons area reference
    private $_btns: JQuery<HTMLElement>;

    constructor($btns: JQuery<HTMLElement>) {

        this.$_btns = $btns;

        //init toggle button
        this._init();
    }

    /**
     * Init Buttons Group
     *
     * @return void
     */
    private _init(): void {

        this._openModalOnClick();
    }

    /**
     * Open modal on clicking the settings icon
     *
     * @return void
     */
    private _openModalOnClick(): void {

        const $this = this;

        $this.$_btns.find(".dht-vb-icon.dht-vb-icon-setting").on("click", function(event) {
            event.preventDefault();

            //init modal component
            $this._initModalComponent()
                .then(() => {

                    //open the modal
                    $("#myDialog3").dhtVBModal("open");

                    //disable editing buttons area
                    $(this).parents(".dht-vb-container").addClass("dht-vb-disabled");

                })
                .catch(error => {
                    console.error(error);
                });
        });
    }

    /**
     * init modal component
     *
     * @return void
     */
    private async _initModalComponent(): Promise<void> {

        try {
            await import("./modal");

            //init modal
            $("#myDialog3").dhtVBModal({
                autoClose: false,
                pos_y: "50",
                movable: true,
                resizable: true,
                touchOutsideForClose: false,
            });

        } catch (error) {
            console.error("Error loading module:", error);
        }
    }

    /**
     * init tooltips
     *
     * @return void
     */
    private _initTooltips() {
        $(".dht-vb-enabled .dht-vb-component-settings .dht-vb-button-group .dht-vb-button").each(function() {
            let $tooltip = $(this);
            $tooltip.on("mouseenter", function() {
                let $this = $(this);
                $this.css("position", "relative");
                $this.html(
                    $this.html() + "<div class='dht-vb-tooltip'><p class='on-bottom'>" + $this.attr("data-tip") + "</p>",
                );

                //show tooltip after a delay
                setTimeout(function() {
                    $this.children(".dht-vb-tooltip").show();
                }, 1000);
            });
            $tooltip.on("mouseleave", function() {
                $(".dht-vb-enabled").find(".dht-vb-tooltip").remove();
            });
        });
    }

}

//init each button groups area
export function dhtInitButtonsGroupComponent() {
    $(".dht-vb-enabled .dht-vb-buttons-group-container").each(function() {
        new ButtonsGroup($(this));
    });
}
