import { errorLoadingModule } from "@helpers/general";

(function($: JQueryStatic): void {
    "use strict";

    class Icon {
        //icon reference
        private readonly $_icon;

        constructor($icon: JQuery<HTMLElement>) {
            //icon reference
            this.$_icon = $icon;

            //call ajax with default icons loaded (in our case - dashicons)
            this._onPopupOpen();

            // call ajax with icon type selected
            this._callAjaxWithSelectedIcon();

            //add selected icon on preview area
            this._addSelectedIconOnPreviewArea();

            //remove selected icon
            this._removeSelectedIcon();

            //search icons
            this._searchIcon();
        }

        /**
         * when opening the popup call ajax with default icons loaded (in our case - dashicons) or the saved one
         *
         * @return void
         */
        private _onPopupOpen(): void {
            //this class reference
            const $thisClass = this;

            this.$_icon.off("click", ".dht-thickbox").on("click", ".dht-thickbox", function() {
                const $this = $(this);

                // icon group area from popup
                const $dht_icons_type_group = $this.siblings(".dht-modal-icons").find(".dht-icons-type-group");

                //clear search input
                $dht_icons_type_group.children(".dht-search-for-icon").val("");

                //get selected icon from input
                let selected_input_val = $this.siblings(".dht-icon-select-value").val()! as string;

                //get saved icon values
                let icon_type = "dashicons";
                let icon = "";
                if (selected_input_val.length > 0) {
                    const selected_input_values = JSON.parse(selected_input_val);
                    icon_type = selected_input_values["icon-type"];
                    // @ts-ignore
                    icon = selected_input_values["icon-class"];
                }

                //set icons dropdown with the saved icon type
                $dht_icons_type_group.children(".dht-icons-type").val(icon_type);

                //call ajax
                $thisClass._getIconsViaAjax(icon_type, $dht_icons_type_group, icon);
            });
        }

        /**
         * call ajax with icon type selected
         *
         * @return void
         */
        private _callAjaxWithSelectedIcon(): void {
            //this class reference
            const $thisClass = this;

            $(document)
                .off("change", ".dht-icons-preview-group .dht-icons-type")
                .on("change", ".dht-icons-preview-group .dht-icons-type", function() {
                    const $this = $(this);
                    const icon_type: string = $this.val()! as string;

                    if (icon_type.length === 0) return;

                    //in case the dropdown is changed quickly - reset it
                    $this.parent(".dht-icons-type-group").siblings(".dht-icons-preview").empty();

                    $thisClass._getIconsViaAjax(icon_type, $this.parent(".dht-icons-type-group"), "");
                });
        }

        /**
         * add selected icon on preview area
         *
         * @return void
         */
        private _addSelectedIconOnPreviewArea(): void {
            //this class reference
            const $thisClass = this;

            $(document)
                .off("click", "#TB_window .dht-icons-preview i")
                .on("click", "#TB_window .dht-icons-preview i", function() {
                    const $this = $(this);
                    const icon_class = $this.attr("class")!;
                    const icon_code = $this.attr("data-code");
                    const $icons_dropdown = $this.parents(".dht-icons-preview-group").children(".dht-icons-type-group").children(".dht-icons-type");
                    //get the popup id
                    const popup_id = $this.parents(".dht-icons-preview-group").attr("data-popup-id");

                    //add selected icon on preview area and display it
                    const popup = $("#" + popup_id);
                    popup
                        .siblings(".dht-icon-select-preview")
                        .children("i")
                        .removeAttr("class")
                        .addClass(icon_class)
                        .parent()
                        .addClass("dht-icon-select-preview-show");

                    //add selected icon to the hidden input to save it
                    popup.siblings(".dht-icon-select-value").val(
                        JSON.stringify({
                            "icon-type": $icons_dropdown.val(),
                            "icon-class": icon_class,
                            "icon-code": icon_code,
                        }),
                    );
                    //show remove button
                    popup.siblings(".dht-btn-remove").addClass("dht-btn-show");

                    //close popup
                    $("#TB_closeWindowButton").trigger("click");

                    //init live editing
                    $thisClass._liveEditing(popup.parents(".dht-field-wrapper-icons"), icon_class).then(() => {
                    }).catch(error => {
                        console.error(error);
                    });
                });
        }

        /**
         * remove selected icon
         *
         * @return void
         */
        private _removeSelectedIcon(): void {
            //this class reference
            const $thisClass = this;

            this.$_icon.off("click", ".dht-btn-remove").on("click", ".dht-btn-remove", function() {
                const $this = $(this);
                $this.siblings(".dht-icon-select-preview").children("i").removeAttr("class").parent().removeClass("dht-icon-select-preview-show");
                $this.siblings(".dht-icon-select-value").val("");
                $this.removeClass("dht-btn-show");

                //init live editing
                $thisClass._liveEditing($this.parents(".dht-field-wrapper-icons"), "").then(() => {
                }).catch(error => {
                    console.error(error);
                });

                return false;
            });
        }

        /**
         * search icon in popup
         *
         * @return void
         */
        private _searchIcon(): void {
            $(document)
                .off("keyup", ".dht-icons-preview-group .dht-search-for-icon")
                .on("keyup", ".dht-icons-preview-group .dht-search-for-icon", function() {
                    const $this = $(this);
                    const $popup = $this.parents(".dht-icons-preview-group");

                    const searchText = $this.val().toLowerCase();

                    // Filter list of icons based on search text
                    $popup
                        .children(".dht-icons-preview")
                        .children("i")
                        .each(function() {
                            const $this = $(this);

                            const icon_class = $this.attr("class")!.toLowerCase();

                            if (icon_class.indexOf(searchText) === -1) {
                                $this.hide();
                            } else {
                                $this.show();
                            }
                        });
                });
        }

        /**
         * ajax method to grab the icons
         *
         * @return void
         */
        private _getIconsViaAjax(icon_type: string, $dht_icons_type_group: JQuery<HTMLElement>, icon: string) {
            //disable icons dropdown to prevent choose several times until ajax is finished
            $dht_icons_type_group.children(".dht-icons-type").prop("disabled", true);

            $.ajax({
                // @ts-ignore
                url: dht_framework_info.ajax_url,
                type: "POST",
                dataType: "json",
                data: {
                    action: "getOptionIcons", // The name of your AJAX action
                    //post id is used to add it to the ajax $_POST
                    post_id: $("#post_ID[name=\"post_ID\"]").val(),
                    data: { icon_type: icon_type, icon: icon },
                },
                beforeSend: function() {
                    //show loading spinner
                    $dht_icons_type_group.siblings(".spinner").css("visibility", "visible");

                    // clear popup
                    $dht_icons_type_group.siblings(".dht-icons-preview").empty();
                },
                success: function(response) {
                    if (response.success) {
                        $dht_icons_type_group.siblings(".dht-icons-preview").append(response.data);
                    } else {
                        console.error("Ajax Response", response);
                    }
                },
                error: function(error) {
                    console.error("AJAX error:", error);
                },
                complete: function() {
                    //hide loading spinner
                    $dht_icons_type_group.siblings(".spinner").css("visibility", "hidden");

                    // Re-enable the dropdown after the request is complete
                    $dht_icons_type_group.children(".dht-icons-type").prop("disabled", false);
                },
            });
        }

        /**
         * live editing
         * Ability to change other areas via changing the field
         * with the provided CSS selectors
         *
         * @param $thisIconsWrapper Icon wrapper area
         * @param iconClass         Icon class to apply on the selector
         *
         * @return Promise<void>
         */
        private async _liveEditing($thisIconsWrapper: JQuery<HTMLElement>, iconClass: string): Promise<void> {
            //no live editor attribute
            if (!($thisIconsWrapper.attr("data-live-selectors") ?? "").length) return;

            try {
                const { dhtNotKeyedSelectorsHelper } = await import("@helpers/options/live-editing");

                dhtNotKeyedSelectorsHelper($thisIconsWrapper, (target: string, selectors: string) => {
                    if (target === "class") {
                        $(selectors).attr("class", iconClass);
                    }
                });
            } catch (error) {
                errorLoadingModule(error as string);
            }
        }
    }

    //init icon option
    function init() {
        $(".dht-field-wrapper-icons").each(function() {
            new Icon($(this));
        });
    }

    // Initialize on page load
    $(function() {
        init();
    });

    // Initialize after AJAX content is loaded
    $(document).on("dht_iconAjaxComplete", function() {
        init();
    });
})(jQuery);
