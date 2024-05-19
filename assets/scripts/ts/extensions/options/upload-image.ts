import jQuery from "jquery";

(function ($: JQueryStatic): void {
    "use strict";

    const $dht_field_wrapper = $(".dht-field-wrapper");

    //open media popup
    $dht_field_wrapper.on("click", ".dht-field-child-upload .dht-upload-image-button", function () {
        const $this = $(this);
        const $hidden_input = $(".dht-upload-hidden");
        const $media_text = $this.attr("data-media-text");

        //open WP media popup
        const custom_uploader = wp.media({
            title: $media_text,
            button: {
                text: $media_text,
            },
            library: { type: "image" },
            multiple: false,
        });

        custom_uploader.on("select", function () {
            const $image_input = $this.siblings(".dht-upload");
            //remove image preview before proceeding
            $image_input.siblings("img").remove();

            const attachment = custom_uploader.state().get("selection").first().toJSON();

            //add image URL
            $image_input.val(attachment.url);
            $image_input.attr("value", attachment.url);

            //add attachment ids to the hidden input
            $hidden_input.val(attachment.id);

            //display a preview image with the selected image url
            $image_input.before('<img src="' + attachment.url + '" width="100" height="100" />');
        });

        custom_uploader.open();

        //open the WP media popup with a preselected attachment id if exist
        const $hidden_input_val = +$hidden_input.val()!;
        if ($hidden_input_val > 0) {
            custom_uploader.state().get("selection").add(wp.media.attachment($hidden_input.val()));
        }
    });

    //remove image when input is cleared
    $dht_field_wrapper.on("input", ".dht-field-child-upload .dht-upload", function () {
        const $this = $(this);

        // Check if the input field is empty and remove the image id and URL
        if ($this.val() === "") {
            $this.siblings("img").remove();
            $this.siblings(".dht-upload-hidden").val("");
            $this.attr("value", "");
        }

        //change image when adding a new link
        if ($this.val().length > 0) {
            $this.siblings("img").remove();
            $this.before('<img src="' + $this.val() + '" width="100" height="100" />');
            $this.attr("value", $this.val());
        }
    });
})(jQuery);
