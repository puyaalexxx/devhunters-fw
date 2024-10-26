(function($: JQueryStatic): void {
    "use strict";

    class MultiOptions {
        //multioptions reference
        private $_multioptions;
        private $_dropdown;
        private readonly $_input_text;
        private $_selected_values;
        private readonly $_minimumInputLength;

        constructor($multioptions: JQuery<HTMLElement>) {
            //multioptions reference
            this.$_multioptions = $multioptions;

            this.$_dropdown = this.$_multioptions.children(".dht-multioptions");
            this.$_input_text = this.$_dropdown.attr("data-input-text");
            this.$_selected_values = this.$_dropdown.attr("data-values")!;
            this.$_minimumInputLength = +this.$_dropdown.attr("data-minimumInputLength")!;

            //set selected values
            this._setSelectedValues();

            //if ajax is enabled
            this._useAjax();

            // Bind focus event to input field
            this._bindInputFocus();
        }

        /**
         * set selected values
         *
         * @return void
         */
        private _setSelectedValues(): void {
            if (this.$_selected_values.length > 0) {
                const predefined_values = this.$_selected_values.split(",");

                this.$_dropdown.val(predefined_values);
            }
        }

        /**
         * Bind focus event to input field
         *
         * @return void
         */
        private _bindInputFocus(): void {
            this.$_dropdown.off("focus").on("focus", function() {
                // Reset the input field value
                $(this).val("");
            });
        }

        /**
         * ajax functionality
         *
         * @return void
         */
        private _useAjax(): boolean {
            if (this.$_dropdown.attr("data-ajax-enabled") === "yes") {
                //get ajax action function to retrieve the dropdown values on search
                const ajax_action = this.$_dropdown.attr("data-ajax-action")!;

                //if no ajax action provided, skip ajax
                if (ajax_action.length === 0) {
                    console.error("No ajax action function provided");

                    return false;
                }

                // Initialize Select2 with AJAX
                this.$_dropdown.select2({
                    minimumInputLength: this.$_minimumInputLength, // Set minimum input length to 1 to trigger AJAX after typing
                    placeholder: this.$_input_text, // Placeholder text
                    allowClear: true, // Allow clearing the selection
                    ajax: {
                        //@ts-ignore
                        url: dht_framework_info.ajax_url,
                        dataType: "json",
                        delay: 250,
                        type: "POST",
                        data: function(params) {
                            return {
                                action: ajax_action,
                                //text typed in the input field
                                term: params.term,
                            };
                        },
                        processResults: function(data) {
                            console.log(data);

                            return {
                                results: data,
                            };
                        },
                        cache: true,
                    },
                });
            }
            //simple multioptions drodpwon without ajax
            else {
                this.$_dropdown.select2({
                    placeholder: this.$_input_text, // Placeholder text
                    minimumInputLength: this.$_minimumInputLength,
                    allowClear: true, // Allow clearing the selection
                });
            }

            return true;
        }
    }

    //init each multioptions option
    function init() {
        $(".dht-field-wrapper-multioptions").each(function() {
            new MultiOptions($(this));
        });
    }

    // Initialize on page load
    $(function() {
        init();
    });

    // Initialize after AJAX content is loaded
    $(document).on("dht_multiOptionsAjaxComplete", function() {
        init();
    });
})(jQuery);
