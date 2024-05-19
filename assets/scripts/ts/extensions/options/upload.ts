import jQuery from "jquery";

(function ($: JQueryStatic): void {
    "use strict";

    const $dht_field_wrapper = $(".dht-field-wrapper");

    $dht_field_wrapper.on("click", ".dht-field-child-upload .dht-upload-item-button", function () {
        const $this = $(this);
        const $hidden_input = $this.siblings(".dht-upload-item-hidden");
        const $media_text = $this.attr("data-media-text");
        const $media_type = $this.attr("data-media-type");

        //open WP media popup
        const custom_uploader = wp.media({
            title: $media_text,
            button: {
                text: $media_text,
            },
            library: { type: $media_type },
            multiple: false,
        });

        custom_uploader.on("select", function () {
            const attachment = custom_uploader.state().get("selection").first().toJSON();
            $this.siblings(".dht-upload-item").attr("value", attachment.url);
            $this.siblings(".dht-upload-item").val(attachment.url);

            //add attachment id to the hidden input
            $hidden_input.val(attachment.id);
        });

        custom_uploader.open();

        //open the WP media popup with a preselected attachment id if exist
        const $hidden_input_val = +$hidden_input.val()!;
        if ($hidden_input_val > 0) {
            custom_uploader.state().get("selection").add(wp.media.attachment($hidden_input.val()));
        }
    });
    //remove video if when input is cleared
    $dht_field_wrapper.on("input", ".dht-field-child-upload .dht-upload-item", function () {
        const $this = $(this);

        // Check if the input field is empty and remove the item
        if ($this.val() === "") {
            $this.siblings(".dht-upload-item-hidden").val("");
            $this.attr("value", "");
        }

        //change input value when adding a new link
        if ($this.val().length > 0) {
            $this.attr("value", $this.val());
        }
    });
})(jQuery);
