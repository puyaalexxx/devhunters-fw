"use strict";

/**
 * init colorpickers
 *
 * @param $colorpicker This colorpicker HTML element
 *
 * @return void
 */
export function dhtInitColorpicker($colorpicker: JQuery<HTMLElement>) {
    //get default palette of colors
    const palette = $colorpicker.attr("data-palette")!;

    // get default button reference
    const $default_btn = $colorpicker.siblings(".dht-default-color-btn").clone(); // Clone the button for each picker

    //set the default colorpicker args
    dhtSetDefaultColorPickerArgs($colorpicker, palette);

    //reset the color picker color to its default value
    dhtResetColoPickerValue($colorpicker, $default_btn);
}

/**
 * on change colorpicker values
 *
 * @param $colorpicker This colorpicker HTML element
 * @param applyStyles  A closure to apply the styles from where it is called
 *
 * @return void
 */
export function dhtOnChangeColorpicker($colorpicker: JQuery<HTMLElement>, applyStyles: (color: string) => void) {
    //check if it is the rgba colorpicker type
    const isAlphaPicker = $colorpicker.attr("data-alpha-enabled");

    // Grab color on colorpicker change
    ($colorpicker as any).wpColorPicker({
        change: function(_: any, ui: any) {
            let color = ui.color.toString();

            //check if it is the rgba colorpicker type
            if (isAlphaPicker === "true") {
                const alphaOptions = ($colorpicker as any).wpColorPicker("instance").alphaOptions; // Get the alpha options
                //grab rgba color type and not the rgb
                color = ui.color.to_s(alphaOptions.alphaColorType);
            }

            // Manually trigger change event
            $(this).val(color).trigger("change");
        },
        clear: function() {
            // Manually trigger change event
            $colorpicker.val("").trigger("change");
        },
    });

    // Grab color on input change
    $colorpicker.off("input change").on("input change", function() {
        const color = String($(this).val());

        applyStyles(color);
    });
}

/**
 * set the default colorpicker args
 *
 * @param $colorpicker Colorpicker instance
 * @param palette      Colorpicker palette of colors
 *
 * @return void
 */
function dhtSetDefaultColorPickerArgs($colorpicker: JQuery<HTMLElement>, palette: string): void {
    let wpColorPickerArgs = {};

    if (palette.length !== 0) {
        wpColorPickerArgs = {
            palettes: JSON.parse(palette),
        };
    }

    ($colorpicker as any).wpColorPicker(wpColorPickerArgs);
}

/**
 * reset the color picker color to its default value
 *
 * @param $colorpicker Colorpicker instance
 * @param $default_btn Button that change the color to default one
 *
 * @return void
 */
function dhtResetColoPickerValue($colorpicker: JQuery<HTMLElement>, $default_btn: JQuery<HTMLElement>): void {
    //default button to reset the color picker color to its default value
    $default_btn.insertAfter($colorpicker.parent("label"));

    //reset the color picker color to its default value
    $default_btn.on("click", () => {
        //get option default color value
        let defaultColor = $default_btn.attr("data-default-value")!;

        $colorpicker.val(defaultColor);
        ($colorpicker as any).wpColorPicker("color", defaultColor);
    });
}

