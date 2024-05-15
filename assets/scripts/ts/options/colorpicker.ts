import jQuery from "jquery";

(function ($: JQueryStatic): void {
    "use strict";

    $(".dht-field-child-colorpicker .dht-alphacolorpicker").each(function () {
        const $colorpicker = $(this);
        let wpColorPickerArgs = {};

        //get default palette of colors
        const palette = $colorpicker.attr("data-palette")!;

        //set the default colorpicker args
        if (palette.length !== 0) {
            wpColorPickerArgs = {
                palettes: JSON.parse(palette),
            };
        }

        //set default color picker args
        ($colorpicker as any).wpColorPicker(wpColorPickerArgs);

        //default button to reset the color picker color to its default value
        const $default_btn = $colorpicker
            .parents(".dht-field-child-colorpicker")
            .find(".dht-default-color-btn");
        $default_btn.insertAfter($colorpicker.parent("label"));

        //reset the color picker color to its default value
        $default_btn.on("click", function () {
            let defaultColor = $(this).attr("data-default-value"); // Set your default color here

            ($colorpicker as any).wpColorPicker("color", defaultColor);
        });
    });
})(jQuery);
