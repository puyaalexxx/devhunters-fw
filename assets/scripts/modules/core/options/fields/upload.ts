(function($: JQueryStatic): void {
    "use strict";

    class Upload {
        //upload reference
        private $_upload;

        constructor($upload: JQuery<HTMLElement>) {
            //upload reference
            this.$_upload = $upload;

            //upload item on click
            this._uploadItem();

            //remove item when input is cleared
            this._removeItemOnInput();
        }

        /**
         * upload item
         *
         * @return void
         */
        private _uploadItem(): void {
            //this class reference
            const $thisClass = this;

            this.$_upload.off("click", ".dht-upload-item-button").on("click", ".dht-upload-item-button", function() {
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

                custom_uploader.off("select").on("select", function() {
                    const attachment = custom_uploader.state().get("selection").first().toJSON();
                    $this.siblings(".dht-upload-item").attr("value", attachment.url);
                    $this.siblings(".dht-upload-item").val(attachment.url);

                    //add attachment id to the hidden input
                    $hidden_input.val(attachment.id);
                });

                custom_uploader.open();

                //open the WP media popup with a preselected attachment id if exist
                $thisClass._preSelectItems($hidden_input, custom_uploader);
            });
        }

        /**
         * remove item when input is cleared
         *
         * @return void
         */
        private _removeItemOnInput(): void {
            this.$_upload.off("input", ".dht-upload-item").on("input", ".dht-upload-item", function() {
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
        }

        /**
         * preselect selected item in Media popup
         *
         * @param $hidden_input : JQuery<HTMLElement>
         * @param custom_uploader : any
         *
         * @return void
         */
        private _preSelectItems($hidden_input: JQuery<HTMLElement>, custom_uploader: any) {
            const $hidden_input_val = +$hidden_input.val()!;
            if ($hidden_input_val > 0) {
                custom_uploader.state().get("selection").add(wp.media.attachment($hidden_input.val()));
            }
        }
    }

    //init each upload button option
    function init() {
        $(".dht-field-wrapper-upload-item").each(function() {
            new Upload($(this));
        });
    }

    // Initialize on page load
    $(function() {
        init();
    });

    // Initialize after AJAX content is loaded
    $(document).on("dht_uploadAjaxComplete", function() {
        init();
    });
})(jQuery);
