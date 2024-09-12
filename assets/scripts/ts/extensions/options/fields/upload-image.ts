import jQuery from "jquery";

"use strict";

class UploadImage {
    //upload gallery reference
    private $_uploadImage;

    constructor($uploadImage: JQuery<HTMLElement>) {
        //upload image reference
        this.$_uploadImage = $uploadImage;

        //upload image on click
        this._uploadImage();

        //remove image when input is cleared
        this._removeImageOnInput();
    }

    /**
     * upload image
     *
     * @return void
     */
    private _uploadImage(): void {
        //this class reference
        const $thisClass = this;

        this.$_uploadImage.off("click", ".dht-upload-image-button").on("click", ".dht-upload-image-button", function () {
            const $this = jQuery(this);
            const $hidden_input = $this.siblings(".dht-upload-hidden");
            const $media_text = $this.attr("data-media-text");

            //open WP media popup
            const custom_uploader = wp.media({
                title: $media_text,
                button: {
                    text: $media_text,
                },
                library: {type: "image"},
                multiple: false,
            });

            custom_uploader.off("select").on("select", function () {
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
                $image_input.before('<img src="' + attachment.url + '" width="100" height="100"  alt=""/>');
            });

            custom_uploader.open();

            //open the WP media popup with a preselected attachment id if exist
            $thisClass._preSelectImages($hidden_input, custom_uploader);
        });
    }

    /**
     * remove image when input is cleared
     *
     * @return void
     */
    private _removeImageOnInput(): void {
        this.$_uploadImage.off("input", ".dht-upload").on("input", ".dht-upload", function () {
            const $this = jQuery(this);

            // Check if the input field is empty and remove the image id and URL
            if ($this.val() === "") {
                $this.siblings("img").remove();
                $this.siblings(".dht-upload-hidden").val("");
                $this.attr("value", "");
            }

            //change image when adding a new link
            if ($this.val().length > 0) {
                $this.siblings("img").remove();
                $this.before('<img src="' + $this.val() + '" width="100" height="100"  alt=""/>');
                $this.attr("value", $this.val());
            }
        });
    }

    /**
     * preselect selected image in Media popup
     *
     * @param $hidden_input : JQuery<HTMLElement>
     * @param custom_uploader : any
     *
     * @return void
     */
    private _preSelectImages($hidden_input: JQuery<HTMLElement>, custom_uploader: any) {
        const $hidden_input_val = +$hidden_input.val()!;
        if ($hidden_input_val > 0) {
            custom_uploader.state().get("selection").add(wp.media.attachment($hidden_input.val()));
        }
    }
}

export function initializetUploadImage() {
    //init each upload image button option
    function init() {
        jQuery(".dht-field-child-upload-image").each(function () {
            new UploadImage(jQuery(this));
        });
    }

    // Initialize on page load
    jQuery(function () {
        init();
    });

    // Initialize after AJAX content is loaded
    jQuery(document).on("dht_uploadImageAjaxComplete", function () {
        init();
    });
}
