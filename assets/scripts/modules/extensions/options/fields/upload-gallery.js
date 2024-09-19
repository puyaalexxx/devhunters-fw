"use strict";
(function ($) {
    "use strict";
    class UploadGallery {
        constructor($gallery) {
            //gallery reference
            this.$_gallery = $gallery;
            //upload gallery on click
            this._uploadGallery();
            //remove image when the x icon is clicked
            this._removeGalleryImage();
            //sort images
            this._onSortImages();
        }
        /**
         * upload gallery
         *
         * @return void
         */
        _uploadGallery() {
            //this class reference
            const $thisClass = this;
            this.$_gallery.off("click", ".dht-upload-gallery-button").on("click", ".dht-upload-gallery-button", function () {
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
                $thisClass._onSelectImages($this, $hidden_input, custom_uploader);
                custom_uploader.open();
                //open the WP media popup with a preselected attachment ids if exist
                $thisClass._preSelectImages($hidden_input, custom_uploader);
            });
        }
        /**
         * remove image from gallery and from the hidden input
         *
         * @return void
         */
        _removeGalleryImage() {
            //this class reference
            const $thisClass = this;
            this.$_gallery.off("click", ".dht-gallery-group .dht-img-remove-icon").on("click", ".dht-gallery-group .dht-img-remove-icon", function () {
                //get the removed image id
                const $hidden_input = $(this).parents(".dht-gallery-group").siblings(".dht-upload-gallery-hidden");
                const image_id = $(this).siblings("img").attr("data-id");
                //get input hidden ids
                let $ids = $thisClass._getHiddenInputValues($hidden_input);
                if ($ids.length > 0) {
                    //remove id from saved ids array and add the new array to the hidden input
                    if ($ids.indexOf(image_id) > -1) {
                        $ids.splice($ids.indexOf(image_id), 1);
                        //$hidden_input
                        $hidden_input.val($ids.join(","));
                    }
                }
                //remove the image container
                $(this).parent(".dht-img-remove").remove();
            });
        }
        /**
         * on select images manipulations
         *
         * @param $this : JQuery<HTMLElement>
         * @param $hidden_input : JQuery<HTMLElement>
         * @param custom_uploader : any
         *
         * @return void
         */
        _onSelectImages($this, $hidden_input, custom_uploader) {
            custom_uploader.off("select").on("select", function () {
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
                    $gallery_div.append("<span class=\"dht-img-remove\">" +
                        "<span class=\"dht-img-remove-icon\"></span>" +
                        "<img data-id=\"" +
                        image.id +
                        "\" src=\"" +
                        image.url +
                        "\" alt=\"\" width=\"100\" height=\"100\" />" +
                        "</span>");
                });
            });
        }
        /**
         * preselect selected images in Media popup
         *
         * @param $hidden_input : JQuery<HTMLElement>
         * @param custom_uploader : any
         *
         * @return void
         */
        _preSelectImages($hidden_input, custom_uploader) {
            let $ids = this._getHiddenInputValues($hidden_input);
            if ($ids.length > 0) {
                //set images as selected in the media popup
                const selection = custom_uploader.state().get("selection");
                $ids.forEach(function (id) {
                    let attachment = wp.media.attachment(id);
                    attachment.fetch();
                    selection.add(attachment ? [attachment] : []);
                });
            }
        }
        /**
         * sort images
         *
         * @return void
         */
        _onSortImages() {
            this.$_gallery
                .children(".dht-gallery-group")
                .sortable({
                //  axis: "x", // Ensure sorting is horizontal
                containment: "parent", // Keep sorting within the parent
                //update hidden input ids
                update: function (event, ui) {
                    let sortedIDs = $(this)
                        .children(".dht-img-remove")
                        .map(function () {
                        return $(this).find("img").attr("data-id");
                    })
                        .get();
                    $(this).siblings(".dht-upload-gallery-hidden").val(sortedIDs.join(","));
                },
            })
                .disableSelection();
        }
        /**
         * get hidden input values
         *
         * @return void
         */
        _getHiddenInputValues($hidden_input) {
            let images_ids = String($hidden_input.val());
            let images_ids_array = [];
            if (images_ids.length > 0) {
                images_ids_array = images_ids.split(",");
            }
            return images_ids_array;
        }
    }
    //init each upload gallery button option
    function init() {
        $(".dht-field-wrapper .dht-field-child-upload-gallery").each(function () {
            new UploadGallery($(this));
        });
    }
    // Initialize on page load
    $(function () {
        init();
    });
    // Initialize after AJAX content is loaded
    $(document).on("dht_uploadGalleryAjaxComplete", function () {
        init();
    });
})(jQuery);
