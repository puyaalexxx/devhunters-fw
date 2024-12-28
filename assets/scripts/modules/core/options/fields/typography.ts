import { errorLoadingModule } from "@helpers/general";

(function($: JQueryStatic): void {
    "use strict";

    class Typography {
        //typography reference
        private readonly $_typography;

        private $_preview_area;
        private $_fonts_dropdown;
        private $_font_weight_dropdown;
        private $_font_style_dropdown;
        private $_font_subsets_dropdown;
        private $_text_transform_dropdown;
        private $_text_decoration_dropdown;
        private $_text_align_dropdown;
        private $_text_font_size;
        private $_text_line_height;
        private $_text_letter_spacing;
        private $_colorpicker;
        private _font_prefix: string;
        private $_font_type_hidden_input;
        private $_font_path_hidden_input;

        constructor($typography: JQuery<HTMLElement>) {
            //typography reference
            this.$_typography = $typography;
            //this class reference
            const $thisClass = this;

            //preview area div
            this.$_preview_area = this.$_typography.children(".dht-field-child-typography-preview");
            //fonts dropdown
            this.$_fonts_dropdown = this.$_typography.find(".dht-typography");
            //font weights dropdown
            this.$_font_weight_dropdown = this.$_typography.find(".dht-typography-weight");
            //font styles dropdown
            this.$_font_style_dropdown = this.$_typography.find(".dht-typography-style");
            //font subsets
            this.$_font_subsets_dropdown = this.$_typography.find(".dht-typography-subsets");
            //text transform
            this.$_text_transform_dropdown = this.$_typography.find(".dht-typography-transform");
            //text decoration
            this.$_text_decoration_dropdown = this.$_typography.find(".dht-typography-decoration");
            //text align
            this.$_text_align_dropdown = this.$_typography.find(".dht-typography-align");
            //text font size
            this.$_text_font_size = this.$_typography.find(".dht-typography-font-size");
            //text line height
            this.$_text_line_height = this.$_typography.find(".dht-typography-line-height");
            //text letter spacing
            this.$_text_letter_spacing = this.$_typography.find(".dht-typography-letter-spacing");
            //text align
            this.$_colorpicker = this.$_typography.find(".dht-colorpicker");
            //font prefix
            this._font_prefix = this.$_fonts_dropdown.attr("data-font-prefix")!;
            //font type hidden input
            this.$_font_type_hidden_input = this.$_fonts_dropdown.siblings(".dht-typography-font-type-hidden");
            //font path hidden input
            this.$_font_path_hidden_input = this.$_fonts_dropdown.siblings(".dht-typography-path-hidden");

            //set saved values
            this._setHeaderFontFromSavedValues($thisClass);

            //font family dropdown
            this._fontDropdown($thisClass);

            //font weights dropdown
            this._fontWeightsDropdown($thisClass);

            //font styles dropdown
            this._fontStylesDropdown($thisClass);

            //font subsets dropdown
            this._fontSubsetsDropdown($thisClass);

            //text transform dropdown
            this._textTransformDropdown($thisClass);

            //text decoration dropdown
            this._textDecorationDropdown($thisClass);

            //text align dropdown
            this._textAlignDropdown($thisClass);

            //text font size
            this._fontSize($thisClass);

            //text line height
            this._lineHeight($thisClass);

            //text letter spacing
            this._letterSpacing($thisClass);

            //init colorpickers
            this._initColorpicker($thisClass).then(() => {
            }).catch(error => {
                console.error(error);
            });
        }

        ////////////////////////////////////////////////////////////////////////
        //////                  Main Methods used above                   //////
        ////////////////////////////////////////////////////////////////////////

        /**
         * init fonts dropdown
         *
         * @param $thisClass : this
         *
         * @return void
         */
        private _fontDropdown($thisClass: this): void {
            this.$_fonts_dropdown.select2({
                //allowClear: true,
            });

            this.$_fonts_dropdown.off("change.mychange").on("change.mychange", function() {
                const $selected_font = $(this);

                //get font type (google, standard, divi)
                const font_type = String($selected_font.find("option:selected").attr("data-font-type"))!;

                //get the selected font family
                const font_family: string = $thisClass._getSelectedFontFamily($thisClass, $selected_font);

                $thisClass._applyStyles("font-family", font_family.length ? font_family : "");

                //if Google font
                if (font_family.length) {
                    if (font_type === "google") {
                        $thisClass._googleFontsManipulations($thisClass, $selected_font, font_family);
                    } else if (font_type === "standard") {
                        $thisClass._standardFontsManipulations($thisClass);
                    } else {
                        $thisClass._customFontsManipulations($thisClass, $selected_font, font_family);
                    }
                } else {
                    $thisClass._setFontFamilyHiddenInputs($thisClass, "", "");
                }
            });
        }

        /**
         * Google fonts manipulations
         *
         * @param $thisClass : this
         * @param $selected_font : JQuery<HTMLElement>
         * @param font_family : string
         *
         * @return void
         */
        private _googleFontsManipulations($thisClass: this, $selected_font: JQuery<HTMLElement>, font_family: string): void {
            $thisClass._setFontFamilyHiddenInputs($thisClass, "google", "");

            //get the selected Google font - font subsets
            const font_subsets = String($selected_font.find("option:selected").attr("data-font-subsets"))!;
            //include the font link for preview
            $thisClass._buildFontLink(font_family);

            //add Google font - font weights to the font weights dropdown
            const font_weights = $selected_font.find("option:selected").attr("data-font-weights")!;
            $thisClass._populateFontWeightDropdown($thisClass, font_weights);

            //add Google font - font subsets to the font subsets dropdown
            $thisClass._populateFontSubsetsDropdown($thisClass, font_subsets);

            // Trigger change event to update Select2
            $thisClass.$_font_weight_dropdown.trigger("change.mychange");
        }

        /**
         * Custom fonts manipulations
         *
         * @param $thisClass : this
         * @param $selected_font : JQuery<HTMLElement>
         * @param font_family : string
         *
         * @return void
         */
        private _customFontsManipulations($thisClass: this, $selected_font: JQuery<HTMLElement>, font_family: string): void {
            //get font path
            const font_path = $thisClass._getCustomFontPath($selected_font);
            $thisClass._setFontFamilyHiddenInputs($thisClass, "divi", font_path);

            //add font-face style to the header area
            $thisClass._addHeaderFontFaceStyle($thisClass, font_family, font_path);

            //no subsets present for standard fonts
            $thisClass.$_font_subsets_dropdown.empty().trigger("change.mychange");

            //add Divi font - font weights to the font weights dropdown
            const font_weights = $selected_font.find("option:selected").attr("data-font-weights")!;
            $thisClass._populateFontWeightDropdown($thisClass, font_weights);
        }

        /**
         * standard fonts manipulations
         *
         * @param $thisClass : this
         *
         * @return void
         */
        private _standardFontsManipulations($thisClass: this): void {
            $thisClass._setFontFamilyHiddenInputs($thisClass, "standard", "");

            //no subsets present for standard fonts
            $thisClass.$_font_subsets_dropdown.empty().trigger("change.mychange");

            //restore the standard font weights
            const font_weights = $thisClass.$_font_weight_dropdown.attr("data-standard-font-weights")!;
            $thisClass._populateFontWeightDropdown($thisClass, font_weights);
        }

        /**
         * font weights dropdown
         *
         * @param $thisClass : this
         *
         * @return void
         */
        private _fontWeightsDropdown($thisClass: this): void {
            this.$_font_weight_dropdown.select2({
                //allowClear: true,
            });
            this.$_font_weight_dropdown.off("change.mychange").on("change.mychange", function() {
                const font_weight = String($(this).val())!;
                const font_family: string = $thisClass._getSelectedFontFamily($thisClass);

                //include the font link for preview + font weight
                if (font_weight.length !== 0) {
                    $thisClass._buildFontLink(font_family, font_weight);
                }

                $thisClass._applyStyles("font-weight", font_weight.length ? font_weight : "");
            });
        }

        /**
         * font subsets dropdown
         *
         * @param $thisClass : this
         *
         * @return void
         */
        private _fontSubsetsDropdown($thisClass: this): void {
            this.$_font_subsets_dropdown.select2({
                //allowClear: true,
            });
        }

        /**
         * font styles dropdown
         *
         * @param $thisClass : this
         *
         * @return void
         */
        private _fontStylesDropdown($thisClass: this): void {
            this.$_font_style_dropdown.select2({
                //allowClear: true,
            });
            this.$_font_style_dropdown.off("change.mychange").on("change.mychange", function() {
                const font_style = String($(this).val());

                $thisClass._applyStyles("font-style", font_style.length ? font_style : "");
            });
        }

        /**
         * text transform dropdown
         *
         * @param $thisClass : this
         *
         * @return void
         */
        private _textTransformDropdown($thisClass: this): void {
            this.$_text_transform_dropdown.select2({
                //allowClear: true,
            });
            this.$_text_transform_dropdown.off("change.mychange").on("change.mychange", function() {
                const text_transform = String($(this).val());

                if (text_transform === "small-caps") {
                    $thisClass._applyStyles("font-variant", text_transform.length ? text_transform : "");
                    $thisClass._applyStyles("text-transform", "");
                } else {
                    $thisClass._applyStyles("text-transform", text_transform.length ? text_transform : "");
                    $thisClass._applyStyles("font-variant", "");
                }
            });
        }

        /**
         * text decoration dropdown
         *
         * @param $thisClass : this
         *
         * @return void
         */
        private _textDecorationDropdown($thisClass: this): void {
            this.$_text_decoration_dropdown.select2({
                //allowClear: true,
            });
            this.$_text_decoration_dropdown.off("change.mychange").on("change.mychange", function() {
                const text_decoration = String($(this).val());

                $thisClass._applyStyles("text-decoration", text_decoration.length ? text_decoration : "");
            });
        }

        /**
         * text align dropdown
         *
         * @param $thisClass : this
         *
         * @return void
         */
        private _textAlignDropdown($thisClass: this): void {
            this.$_text_align_dropdown.select2({
                //allowClear: true,
            });
            this.$_text_align_dropdown.off("change.mychange").on("change.mychange", function() {
                const text_align = String($(this).val());

                $thisClass._applyStyles("text-align", text_align.length ? text_align : "");
            });
        }

        /**
         * text font zie
         *
         * @param $thisClass : this
         *
         * @return void
         */
        private _fontSize($thisClass: this): void {
            //on size dropdown change
            this.$_text_font_size.children("select").off("change").on("change", function() {
                const size = String($(this).val());
                const value = String($(this).siblings(".dht-input").val());

                $thisClass._applyStyles("font-size", value + size);
            });
            //on input change
            this.$_text_font_size.children(".dht-input").off("input change").on("input change", function() {
                const value = String($(this).val());
                const size = String($(this).siblings("select").val());
                const preparedValue = value.length === 0 ? 0 + size : value + size;

                $thisClass._applyStyles("font-size", preparedValue);
            });
        }

        /**
         * text line height
         *
         * @param $thisClass : this
         *
         * @return void
         */
        private _lineHeight($thisClass: this): void {
            //on size dropdown change
            this.$_text_line_height.children("select").off("change").on("change", function() {
                const size = String($(this).val());
                const value = String($(this).siblings(".dht-input").val());

                $thisClass._applyStyles("line-height", value + size);
            });
            //on input change
            this.$_text_line_height.children(".dht-input").off("input change").on("input change", function() {
                const value = String($(this).val());
                const size = String($(this).siblings("select").val());
                const preparedValue = value.length === 0 ? 0 + size : value + size;

                $thisClass._applyStyles("line-height", preparedValue);
            });
        }

        /**
         * text letter spacing
         *
         * @param $thisClass : this
         *
         * @return void
         */
        private _letterSpacing($thisClass: this): void {
            //on size dropdown change
            this.$_text_letter_spacing.children("select").off("change").on("change", function() {
                const size = String($(this).val());
                const value = String($(this).siblings(".dht-input").val());

                $thisClass._applyStyles("letter-spacing", value + size);
            });
            //on input change
            this.$_text_letter_spacing.children(".dht-input").off("input change").on("input change", function() {
                const value = String($(this).val());
                const size = String($(this).siblings("select").val());
                const preparedValue = value.length === 0 ? 0 + size : value + size;

                $thisClass._applyStyles("letter-spacing", preparedValue);
            });
        }

        /**
         * initialize colorpicker field
         *
         * @param $thisClass : this
         *
         * @return void
         */
        private async _initColorpicker($thisClass: this): Promise<void> {
            try {
                const {
                    dhtInitColorpicker,
                    dhtOnChangeColorpicker,
                } = await import("@helpers/options/colorpicker-utilities");

                //call colorpicker functionality
                this.$_colorpicker.each(function() {
                    const $this = $(this);

                    //load colorpicker
                    dhtInitColorpicker($this);

                    //apply styles on colorPicker change value
                    dhtOnChangeColorpicker($this, (color) => {
                        $thisClass._applyStyles("color", color);
                    });
                });
            } catch (error) {
                errorLoadingModule(error as string);
            }
        }

        ////////////////////////////////////////////////////////////////////////
        //////                 Helper Methods used above                  //////
        ////////////////////////////////////////////////////////////////////////

        /**
         * populate font weight dropdown
         *
         * @param $thisClass : this
         * @param font_weights : string
         *
         * @return void
         */
        private _populateFontWeightDropdown($thisClass: this, font_weights: string): void {
            $thisClass.$_font_weight_dropdown.empty();

            if (font_weights && font_weights.length > 0) {
                $thisClass.$_font_weight_dropdown.append("<option></option>");
                $.each(JSON.parse(font_weights), function(weight_value: string, weight_value_label: string) {
                    $thisClass.$_font_weight_dropdown.append("<option value=\"" + weight_value + "\">" + weight_value_label + "</option>");
                });
            }
        }

        /**
         * populate font subsets dropdown
         *
         * @param $thisClass : this
         * @param font_subsets : JQuery<HTMLElement>
         *
         * @return void
         */
        private _populateFontSubsetsDropdown($thisClass: this, font_subsets: string): void {
            $thisClass.$_font_subsets_dropdown.empty();
            if (font_subsets.length > 0) {
                $thisClass.$_font_subsets_dropdown.append("<option></option>");
                $.each(JSON.parse(font_subsets), function(index, subset) {
                    $thisClass.$_font_subsets_dropdown.append("<option value=\"" + subset + "\">" + subset + "</option>");
                });
            }
        }

        /**
         * set header font from saved values
         *
         * @param $thisClass : this
         *
         * @return void
         */
        private _setHeaderFontFromSavedValues($thisClass: this): void {
            let saved_values = this.$_fonts_dropdown.attr("data-saved-values")!;
            //set the font link in header with the saved values if a Google font
            if (saved_values.length > 0) {
                const saved_vals = JSON.parse(saved_values);

                if (saved_vals["font_type"] === "google") {
                    $thisClass._buildFontLink(saved_vals["font"], saved_vals["weight"]);
                }
            }
        }

        /**
         * add custom font font-face style to the header tag area
         *
         * @param $thisClass : this
         * @param font_family : string
         * @param font_path : string
         *
         * @return void
         */
        private _addHeaderFontFaceStyle($thisClass: this, font_family: string, font_path: string): void {
            if (font_path.length > 0) {
                const fontFormat = $thisClass._getFontFormatFromPath(font_path);

                $(`<style class='dht-custom-font-face-style'>@font-face{font-family:${font_family};src:url(${encodeURI(font_path)}) format('${fontFormat}');font-display: swap;}</style>`).appendTo("head");
            }
        }

        /**
         * get selected custom font path
         *
         * @param $selected_font Current selected font from element from dropdown
         *
         * @return string
         */
        private _getCustomFontPath($selected_font: JQuery<HTMLElement>): string {
            //get font path
            return String($selected_font.find("option:selected").attr("data-font-path"))!;
        }

        /**
         * get font format value from the font link extension
         *
         * @param font_path : string
         *
         * @return string
         */
        private _getFontFormatFromPath(font_path: string): string {
            // Extract the file extension to determine the font format
            const file_extension = font_path.split(".").pop()?.toLowerCase();
            let font_format: string;

            // Determine the font format based on the file extension
            switch (file_extension) {
                case "otf":
                    font_format = "opentype";
                    break;
                case "ttf":
                    font_format = "truetype";
                    break;
                case "woff":
                    font_format = "woff";
                    break;
                case "woff2":
                    font_format = "woff2";
                    break;
                default:
                    font_format = "truetype";  // Default to truetype if the extension is unknown
                    break;
            }

            return font_format;
        }

        /**
         * build Google font link
         *
         * @param font_family : string
         * @param font_weight : string
         *
         * @return void
         */
        private _buildFontLink(font_family: string, font_weight = ""): void {
            let fontLink = "https://fonts.googleapis.com/css2?family=" + font_family;

            //add font weight to the font also
            if (font_weight.length > 0) {
                fontLink = "https://fonts.googleapis.com/css2?family=" + font_family + ":wght@" + font_weight;
            }

            $("<link href=\"" + fontLink + "\" rel=\"stylesheet\">").appendTo("head");
        }

        /**
         * get font dropdown selected font name
         *
         * @param $thisClass
         * @param $selected_font_dropdown Current font dropdown element
         *
         * @return string
         */
        private _getSelectedFontFamily($thisClass: this, $selected_font_dropdown: JQuery<HTMLElement> = $()): string {
            $selected_font_dropdown = $selected_font_dropdown.length > 0 ? $selected_font_dropdown : $thisClass.$_fonts_dropdown;

            // If no value is found, return an empty string
            const fontValue = $selected_font_dropdown.val() ? String($selected_font_dropdown.val()) : "";

            return fontValue.replace(new RegExp(`^${$thisClass._font_prefix}-`), "");
        }

        /**
         * Set font family dropdown hidden inputs
         * These are needed to contruct an array of font family values, like
         * font, font-type and font-path
         *
         * @param $thisClass
         * @param font_type Font type to be applied
         * @param font_path Font path if it is a custom font
         *
         * @return void
         */
        private _setFontFamilyHiddenInputs($thisClass: this, font_type: string, font_path: string): void {
            //set font type input value
            $thisClass.$_font_type_hidden_input.attr("value", font_type);
            //set font path input value
            $thisClass.$_font_path_hidden_input.attr("value", font_path);
        }

        /**
         * Helper function to apply the styles to preview area
         * and the live editing feature
         *
         * @param cssProperty   CSS property to apply the values to (font-size)
         * @param preparedValue
         *
         * @return void
         */
        private _applyStyles(cssProperty: string, preparedValue: string) {
            //apply font to preview area
            this.$_preview_area.css(cssProperty, preparedValue);

            //init live editing with font size
            this._liveEditing({ [cssProperty]: preparedValue }).then(() => {
            }).catch(error => {
                console.error(error);
            });
        }

        /**
         * live editing
         * Ability to change other areas via changing the field
         * with the provided CSS selectors
         *
         * @param style Style to be applied on the selectors
         *
         * @return Promise<void>
         */
        private async _liveEditing(style: { [key: string]: string }): Promise<void> {
            //no live editor attribute
            if (!(this.$_typography.attr("data-live-selectors") ?? "").length) return;

            try {
                const {
                    dhtApplyChangesForNotKeyedSelectors, dhtRestoreElementDefaultValues, dhtGetDefaultValue,
                } = await import("@helpers/options/live-editing");

                dhtApplyChangesForNotKeyedSelectors(
                    this.$_typography,
                    // Live change handler
                    (target: string, selectors: string) => {
                        if (target === "style") {
                            applyChangesHelper(selectors, style);
                        }
                    },
                    //restore to defaults
                    (target: string, selectors: string) => {
                        if (target === "style") {
                            dhtRestoreElementDefaultValues(this.$_typography, () => {
                                const defaultTypographyValues = dhtGetDefaultValue(this.$_typography);

                                if (defaultTypographyValues.length) applyChangesHelper(selectors, JSON.parse(defaultTypographyValues));
                            });
                        }
                    },
                );

                //helper function to apply the style changes
                function applyChangesHelper(selectors: string, style: { [key: string]: string }) {
                    $(selectors).css(style);
                }
            } catch (error) {
                errorLoadingModule(error as string);
            }
        }
    }

    //init each typography option
    function init() {
        $(".dht-field-wrapper-typography .dht-field-child-typography").each(function() {
            new Typography($(this));
        });
    }

    // Initialize on page load
    $(function() {
        init();
    });

    // Initialize after AJAX content is loaded
    $(document).on("dht_typographyAjaxComplete", function() {
        init();
    });
})(jQuery);
