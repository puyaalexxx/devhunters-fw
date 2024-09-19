"use strict";
(function ($) {
    "use strict";
    class Icon {
        constructor($icon) {
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
        _onPopupOpen() {
            //this class reference
            const $thisClass = this;
            this.$_icon.off("click", ".dht-thickbox").on("click", ".dht-thickbox", function () {
                const $this = $(this);
                // icon group area from popup
                const $dht_icons_type_group = $this.siblings(".dht-modal-icons").find(".dht-icons-type-group");
                //clear search input
                $dht_icons_type_group.children(".dht-search-for-icon").val("");
                //get selected icon from input
                let selected_input_val = $this.siblings(".dht-icon-select-value").val();
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
        _callAjaxWithSelectedIcon() {
            //this class reference
            const $thisClass = this;
            $(document)
                .off("change", ".dht-icons-preview-group .dht-icons-type")
                .on("change", ".dht-icons-preview-group .dht-icons-type", function () {
                const $this = $(this);
                const icon_type = $this.val();
                if (icon_type.length === 0)
                    return;
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
        _addSelectedIconOnPreviewArea() {
            $(document)
                .off("click", "#TB_window .dht-icons-preview i")
                .on("click", "#TB_window .dht-icons-preview i", function () {
                const $this = $(this);
                const icon_class = $this.attr("class");
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
                popup.siblings(".dht-icon-select-value").val(JSON.stringify({
                    "icon-type": $icons_dropdown.val(),
                    "icon-class": icon_class,
                    "icon-code": icon_code,
                }));
                //show remove button
                popup.siblings(".dht-btn-remove").addClass("dht-btn-show");
                //close popup
                $("#TB_closeWindowButton").trigger("click");
            });
        }
        /**
         * remove selected icon
         *
         * @return void
         */
        _removeSelectedIcon() {
            this.$_icon.off("click", ".dht-btn-remove").on("click", ".dht-btn-remove", function () {
                const $this = $(this);
                $this.siblings(".dht-icon-select-preview").children("i").removeAttr("class").parent().removeClass("dht-icon-select-preview-show");
                $this.siblings(".dht-icon-select-value").val("");
                $this.removeClass("dht-btn-show");
                return false;
            });
        }
        /**
         * search icon in popup
         *
         * @return void
         */
        _searchIcon() {
            $(document)
                .off("keyup", ".dht-icons-preview-group .dht-search-for-icon")
                .on("keyup", ".dht-icons-preview-group .dht-search-for-icon", function () {
                const $this = $(this);
                const $popup = $this.parents(".dht-icons-preview-group");
                const searchText = $this.val().toLowerCase();
                // Filter list of icons based on search text
                $popup
                    .children(".dht-icons-preview")
                    .children("i")
                    .each(function () {
                    const $this = $(this);
                    const icon_class = $this.attr("class").toLowerCase();
                    if (icon_class.indexOf(searchText) === -1) {
                        $this.hide();
                    }
                    else {
                        $this.show();
                    }
                });
            });
        }
        _getIconsViaAjax(icon_type, $dht_icons_type_group, icon) {
            //disable icons dropdown to prevent choose several times until ajax is finished
            $dht_icons_type_group.children(".dht-icons-type").prop("disabled", true);
            $.ajax({
                // @ts-ignore
                url: dht_framework_ajax_info.ajax_url,
                type: "POST",
                dataType: "json",
                data: {
                    action: "getOptionIcons", // The name of your AJAX action
                    data: { icon_type: icon_type, icon: icon },
                },
                beforeSend: function () {
                    //show loading spinner
                    $dht_icons_type_group.siblings(".spinner").css("visibility", "visible");
                    // clear popup
                    $dht_icons_type_group.siblings(".dht-icons-preview").empty();
                },
                success: function (response) {
                    if (response.success) {
                        $dht_icons_type_group.siblings(".dht-icons-preview").append(response.data);
                    }
                    else {
                        console.error("Ajax Response", response);
                    }
                },
                error: function (error) {
                    console.error("AJAX error:", error);
                },
                complete: function () {
                    //hide loading spinner
                    $dht_icons_type_group.siblings(".spinner").css("visibility", "hidden");
                    // Re-enable the dropdown after the request is complete
                    $dht_icons_type_group.children(".dht-icons-type").prop("disabled", false);
                },
            });
        }
    }
    //init icon option
    function init() {
        $(".dht-field-wrapper .dht-field-child-icons").each(function () {
            new Icon($(this));
        });
    }
    // Initialize on page load
    $(function () {
        init();
    });
    // Initialize after AJAX content is loaded
    $(document).on("dht_iconAjaxComplete", function () {
        init();
    });
})(jQuery);
