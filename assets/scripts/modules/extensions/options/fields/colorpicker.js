"use strict";
(function ($) {
    "use strict";
    class ColorPicker {
        constructor() {
            this._wpColorPickerArgs = {};
            //init colorpickers
            this._initColorpicker();
        }
        /**
         * init colorpickers
         *
         * @return void
         */
        _initColorpicker() {
            const $thisClass = this;
            $(".dht-field-child-wrapper .dht-colorpicker").each(function () {
                const $this = $(this);
                //get default palette of colors
                const palette = $this.attr("data-palette");
                // get default button reference
                const $default_btn = $this.siblings(".dht-default-color-btn").clone(); // Clone the button for each picker
                //set the default colorpicker args
                $thisClass._setDefaultColorPickerArgs($this, palette);
                //reset the color picker color to its default value
                $thisClass._resetColoPickerValue($this, $default_btn);
            });
        }
        /**
         * set the default colorpicker args
         *
         * @return void
         */
        _setDefaultColorPickerArgs($colorpicker, palette) {
            if (palette.length !== 0) {
                this._wpColorPickerArgs = {
                    palettes: JSON.parse(palette),
                };
            }
            $colorpicker.wpColorPicker(this._wpColorPickerArgs);
        }
        /**
         * reset the color picker color to its default value
         *
         * @return void
         */
        _resetColoPickerValue($colorpicker, $default_btn) {
            //default button to reset the color picker color to its default value
            $default_btn.insertAfter($colorpicker.parent("label"));
            //reset the color picker color to its default value
            $default_btn.on("click", () => {
                const $this = $(this);
                //get option default color value
                let defaultColor = $default_btn.attr("data-default-value");
                $colorpicker.wpColorPicker("color", defaultColor);
            });
        }
    }
    //init each colorpicker option
    function init() {
        new ColorPicker();
    }
    // Initialize on page load
    $(function () {
        init();
    });
    // Initialize after AJAX content is loaded
    $(document).on("dht_colorPickerAjaxComplete", function () {
        init();
    });
})(jQuery);
