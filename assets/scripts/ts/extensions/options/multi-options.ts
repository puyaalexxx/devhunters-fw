import jQuery from "jquery";

(function ($: JQueryStatic): void {
    "use strict";

    $(".dht-field-child-multioptions").each(function () {
        const $parent = $(this);
        const $dropdown = $parent.children(".dht-multioptions");
        const input_text = $dropdown.attr("data-input-text");
        const selected_values = $dropdown.attr("data-values")!;
        const minimumInputLength = +$dropdown.attr("data-minimumInputLength")!;

        //set selected values
        if (selected_values.length > 0) {
            const predefined_values = selected_values.split(",");

            $dropdown.val(predefined_values);
        }

        //if ajax is enabled
        if ($dropdown.attr("data-ajax-enabled") === "yes") {
            //get ajax action function to retrieve the dropdown values on search
            const ajax_action = $dropdown.attr("data-ajax-action")!;

            //if no ajax action provided, skip ajax
            if (ajax_action.length === 0) {
                console.error("No ajax action function provided");

                return false;
            }

            // Initialize Select2 with AJAX
            $dropdown.select2({
                minimumInputLength: minimumInputLength, // Set minimum input length to 1 to trigger AJAX after typing
                placeholder: input_text, // Placeholder text
                allowClear: true, // Allow clearing the selection
                ajax: {
                    //@ts-ignore
                    url: dht_multioptions_ajax.ajax_url,
                    dataType: "json",
                    delay: 250,
                    type: "POST",
                    data: function (params) {
                        return {
                            action: ajax_action,
                            //text typed in the input field
                            term: params.term,
                        };
                    },
                    processResults: function (data) {
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
            $dropdown.select2({
                placeholder: input_text, // Placeholder text
                minimumInputLength: minimumInputLength,
                allowClear: true, // Allow clearing the selection
            });
        }

        // Bind focus event to input field
        $dropdown.on("focus", function () {
            // Reset the input field value
            $(this).val("");
        });
    });
})(jQuery);
