import jQuery from "jquery";

(function ($: JQueryStatic): void {
    "use strict";

    const $body = $("body");

    function dht_get_ajax_icons(icon_type: string, $dht_icons_type_group: JQuery<HTMLElement>, icon: string) {
        //disable icons dropdown to prevent choose several times until ajax is finished
        $dht_icons_type_group.children(".dht-icons-type").prop("disabled", true);

        $.ajax({
            // @ts-ignore
            url: dht_icon_option_ajax.ajax_url,
            type: "POST",
            dataType: "json",
            data: {
                action: "get_option_icons", // The name of your AJAX action
                data: { icon_type: icon_type, icon: icon },
            },
            beforeSend: function () {
                //show loading spinner
                $dht_icons_type_group.siblings(".spinner").css("visibility", "visible");

                // clear popup
                $dht_icons_type_group.siblings(".dht-icons-preview").empty();
            },
            success: function (response) {
                //hide loading spinner
                $dht_icons_type_group.siblings(".spinner").css("visibility", "hidden");

                if (response.success) {
                    $dht_icons_type_group.siblings(".dht-icons-preview").append(response.data);
                } else {
                    console.error("Ajax Response", response);
                }
            },
            error: function (error) {
                console.error("AJAX error:", error);
            },
            complete: function () {
                // Re-enable the dropdown after the request is complete
                $dht_icons_type_group.children(".dht-icons-type").prop("disabled", false);
            },
        });
    }

    //call ajax with default icons loaded (in our case - dashicons)
    $(".dht-field-child-icons .dht-thickbox").on("click", function () {
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
        dht_get_ajax_icons(icon_type, $dht_icons_type_group, icon);

        //return false;
    });

    // call ajax with icon type selected
    $(".dht-field-child-icons .dht-icons-type").on("change", function () {
        const $this = $(this);
        const icon_type: string = $this.val()! as string;

        if (icon_type.length === 0) return;

        //in case the dropdown is changed quickly - reset it
        $this.parent(".dht-icons-type-group").siblings(".dht-icons-preview").empty();

        dht_get_ajax_icons(icon_type, $this.parent(".dht-icons-type-group"), "");
    });

    //add selected icon on preview area
    $body.on("click", "#TB_window .dht-icons-preview i", function () {
        const $this = $(this);
        const icon_class = $this.attr("class")!;
        const icon_code = $this.attr("data-code");
        const $icons_dropdown = $this.parents(".dht-icons-preview-group").children(".dht-icons-type-group").children(".dht-icons-type");
        //get the popup id
        const popup_id = $this.parents(".dht-icons-preview-group").attr("data-popup-id");

        //add selected icon on preview area and display it
        const popup = $("#" + popup_id);
        popup.siblings(".dht-icon-select-preview").children("i").removeAttr("class").addClass(icon_class).parent().addClass("dht-icon-select-preview-show");

        //add selected icon to the hidden input to save it
        popup.siblings(".dht-icon-select-value").val(
            JSON.stringify({
                "icon-type": $icons_dropdown.val(),
                "icon-class": icon_class,
                "icon-code": icon_code,
            })
        );
        //show remove button
        popup.siblings(".dht-btn-remove").addClass("dht-btn-show");

        //close popup
        $("#TB_closeWindowButton").trigger("click");
    });

    //remove selected icon
    $(".dht-field-child-icons .dht-btn-remove").on("click", function () {
        const $this = $(this);
        $this.siblings(".dht-icon-select-preview").children("i").removeAttr("class").parent().removeClass("dht-icon-select-preview-show");
        $this.siblings(".dht-icon-select-value").val("");
        $this.removeClass("dht-btn-show");

        return false;
    });

    //search icons
    $body.on("keyup", ".dht-icons-preview-group .dht-search-for-icon", function () {
        const $this = $(this);
        const $popup = $this.parents(".dht-icons-preview-group");

        const searchText = $this.val().toLowerCase();

        // Filter list of icons based on search text
        $popup
            .children(".dht-icons-preview")
            .children("i")
            .each(function () {
                const $this = $(this);

                const icon_class = $this.attr("class")!.toLowerCase();

                if (icon_class.indexOf(searchText) === -1) {
                    $this.hide();
                } else {
                    $this.show();
                }
            });
    });
})(jQuery);
