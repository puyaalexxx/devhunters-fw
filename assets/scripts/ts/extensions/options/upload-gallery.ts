import jQuery from "jquery";

(function ($: JQueryStatic): void {
    "use strict";

    const $dht_field_wrapper = $(".dht-field-wrapper");

    $dht_field_wrapper.on("click", ".dht-field-child-upload .dht-upload-gallery-button", function () {
        const $this = jQuery(this);
        const $hidden_input = $this.siblings(".dht-upload-gallery-hidden");
        const $media_text = $this.attr("data-media-text");

        //open WP media popup
        const custom_uploader = wp.media({
            title: $media_text,
            button: {
                text: $media_text,
            },
            library: { type: "image" },
            multiple: true,
        });

        //do manipulations after inserting the images
        custom_uploader.on("select", function () {
            let $gallery_div = $this.siblings(".dht-gallery-group");
            $gallery_div.empty();

            const attachments = custom_uploader.state().get("selection").toJSON();

            const image_ids = [];
            let gallery = [];
            for (let i = 0; i < attachments.length; i++) {
                image_ids.push(attachments[i].id);

                gallery.push({ id: attachments[i].id, url: attachments[i].url });
            }
            //add attachment ids to the hidden input
            $hidden_input.val(image_ids.join(","));

            //insert selected images - create a gallery view
            gallery.forEach(function (image) {
                $gallery_div.append(
                    '<span class="dht-img-remove">' +
                        '<span class="dht-img-remove-icon"></span>' +
                        '<img data-id="' +
                        image.id +
                        '" src="' +
                        image.url +
                        '" alt="" width="100" height="100" />' +
                        "</span>"
                );
            });
        });

        custom_uploader.open();

        //open the WP media popup with a preselected attachment ids if exist
        const $hidden_input_val = $hidden_input.val();
        if ($hidden_input_val.length > 0) {
            //get hidden input ids
            const gallery_ids = $hidden_input_val.split(",");

            //set images as selected in the media popup
            const selection = custom_uploader.state().get("selection");
            gallery_ids.forEach(function (id: number) {
                let attachment = wp.media.attachment(id);
                attachment.fetch();
                selection.add(attachment ? [attachment] : []);
            });
        }
    });

    //remove image from gallery and from the hidden input
    $dht_field_wrapper.on("click", ".dht-field-child-upload .dht-gallery-group .dht-img-remove-icon", function () {
        //get the removed image id
        const $hidden_input = $(this).parents(".dht-gallery-group").siblings(".dht-upload-gallery-hidden");
        const image_id = $(this).siblings("img").attr("data-id")!;

        //get input hidden ids
        let saved_ids = $hidden_input.val();
        if (typeof saved_ids === "string") {
            saved_ids = saved_ids.split(",");

            //remove id from saved ids array and add the new array to the hidden input
            if (saved_ids.indexOf(image_id) > -1) {
                saved_ids.splice(saved_ids.indexOf(image_id), 1);

                //$hidden_input
                $hidden_input.val(saved_ids.join(","));
            }
        }

        //remove the image container
        $(this).parent(".dht-img-remove").remove();
    });
})(jQuery);
