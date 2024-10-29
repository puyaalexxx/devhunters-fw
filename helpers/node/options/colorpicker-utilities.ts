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
 * set the default colorpicker args
 *
 * @param $colorpicker Colorpicker instance
 * @param palette      Colorpicker palette of colors
 *
 * @return void
 */
function dhtSetDefaultColorPickerArgs($colorpicker: any, palette: string): void {

    let wpColorPickerArgs = {};

    if (palette.length !== 0) {
        wpColorPickerArgs = {
            palettes: JSON.parse(palette),
        };
    }

    $colorpicker.wpColorPicker(wpColorPickerArgs);
}

/**
 * reset the color picker color to its default value
 *
 * @param $colorpicker Colorpicker instance
 * @param $default_btn Button that change the color to default one
 *
 * @return void
 */
function dhtResetColoPickerValue($colorpicker: any, $default_btn: JQuery<HTMLElement>): void {
    //default button to reset the color picker color to its default value
    $default_btn.insertAfter($colorpicker.parent("label"));

    //reset the color picker color to its default value
    $default_btn.on("click", () => {
        //get option default color value
        let defaultColor = $default_btn.attr("data-default-value")!;

        $colorpicker.wpColorPicker("color", defaultColor);
    });
}

