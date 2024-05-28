import jQuery from "jquery";

(function ($: JQueryStatic): void {
    "use strict";

    class ColorPicker {
        private _wpColorPickerArgs = {};
        private readonly _palette;
        //default button to reset the color picker color to its default value
        private $_default_btn;
        //colorpicker reference
        private $_colorpicker: any;

        constructor($colorpicker: JQuery<HTMLElement>) {
            //colorpicker reference
            this.$_colorpicker = $colorpicker;

            //get default palette of colors
            this._palette = $colorpicker.attr("data-palette")!;

            //get default button reference
            this.$_default_btn = $colorpicker.parents(".dht-field-child-wrapper").find(".dht-default-color-btn");

            //set the default colorpicker args
            this._setDefaultColorPickerArgs();

            //reset the color picker color to its default value
            this._resetColoPickerValue();
        }

        /**
         * set the default colorpicker args
         *
         * @return void
         */
        private _setDefaultColorPickerArgs(): void {
            if (this._palette.length !== 0) {
                this._wpColorPickerArgs = {
                    palettes: JSON.parse(this._palette),
                };
            }

            this.$_colorpicker.wpColorPicker(this._wpColorPickerArgs);
        }

        /**
         * reset the color picker color to its default value
         *
         * @return void
         */
        private _resetColoPickerValue(): void {
            //default button to reset the color picker color to its default value
            this.$_default_btn.insertAfter(this.$_colorpicker.parent("label"));

            //reset the color picker color to its default value
            this.$_default_btn.on("click", () => {
                const $this = $(this);

                //get option default color value
                let defaultColor = this.$_default_btn.attr("data-default-value");

                this.$_colorpicker.wpColorPicker("color", defaultColor);
            });
        }
    }

    //init each colorpicker option
    $(".dht-field-child-wrapper .dht-colorpicker").each(function () {
        new ColorPicker($(this));
    });
})(jQuery);
