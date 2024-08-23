<?php

use function DHT\Helpers\dht_parse_option_attributes;

if ( !defined( 'DHT_MAIN' ) ) die( 'Forbidden' );

$group = $args[ 'group' ] ?? [];
$saved_values = !empty( $group[ 'value' ] ) ? $group[ 'value' ] : [];

//dht_print_r( $group );
?>
<!-- field - addable box -->
<div class="dht-field-wrapper">

    <div class="dht-title"><?php echo esc_html( $group[ 'title' ] ); ?></div>

    <div
        class="dht-field-child-wrapper dht-field-child-accordion <?php echo isset( $group[ 'attr' ][ 'class' ] ) ? esc_attr( $group[ 'attr' ][ 'class' ] ) : ''; ?>"
        <?php echo dht_parse_option_attributes( $group[ 'attr' ] ); ?>>

        <div class="dht-accordion dht-accordion-repeater">

            <?php if ( !empty( $group[ 'options' ] ) ): ?>

                <input type="hidden" class="dht-accordion-json-data"
                       value='<?php echo json_encode( $group, JSON_UNESCAPED_UNICODE ) ?>' />

                <?php if ( !empty( $saved_values ) ): ?>

                    <?php foreach ( $saved_values as $key => $saved_value ): ?>

                        <?php dht_display_toggle( $key ); ?>

                    <?php endforeach; ?>

                <?php else: ?>

                    <?php dht_display_toggle(); ?>

                <?php endif; ?>

                <a href=""
                   class="button button-primary dht-add-toggle"><?php echo _x( 'Add', 'options', DHT_PREFIX ); ?></a>
                <div
                    class="dht-toggle-remove-text"><?php echo _x( 'Can\'t remove the only item', 'options', DHT_PREFIX ); ?></div>

            <?php endif; ?>
        </div>

        <?php if ( !empty( $group[ 'description' ] ) ): ?>
            <div class="dht-description"><?php echo esc_html( $group[ 'description' ] ); ?></div>
        <?php endif; ?>

    </div>

    <?php if ( !empty( $group[ 'tooltip' ] ) ): ?>
        <div class="dht-info-help dashicons dashicons-info"
             data-tooltips="<?php echo esc_html( $group[ 'tooltip' ] ); ?>"
             data-position="OnLeft">
        </div>
    <?php endif; ?>

</div>

<?php if ( isset( $group[ 'divider' ] ) && $group[ 'divider' ] ): ?>
    <div class="dht-divider"></div>
<?php endif; ?>

<?php
/*
 * added for convenience to not repeat the markup twice
 */
function dht_display_toggle( int $cnt = 1 ) : void {

    $default_box_title = _x( 'Box Title', 'options', DHT_PREFIX );
    ?>
    <div class="dht-accordion-item">

        <div class="dht-accordion-title">

            <span class="spinner"></span>

            <div class="dht-accordion-arrow">
                <span class="dht-accordion-arrow-item dashicons dashicons-plus-alt"></span>
                <span class="dht-accordion-arrow-item-close dashicons dashicons-dismiss"></span>
            </div>

            <span
                class="dht-accordion-title-text" data-default-title="<?php echo esc_attr( $default_box_title ); ?>">
                <?php echo !empty( $saved_values[ 'box-title' ] ) ? esc_html( $saved_values[ 'box-title' ] ) : $default_box_title; ?>
            </span>

        </div>

        <div class="dht-accordion-content">

            content

        </div>

    </div>
<?php } ?>

<style>
    .dht-wrapper .dht-field-child-accordion .dht-accordion-item {
        margin: 5px auto;
    }

    .dht-accordion-repeater .dht-info-help {
        display: none;
    }

    .dht-wrapper .dht-field-child-accordion .dht-accordion-item .dht-accordion-title {
        position: relative;
        display: block;
        padding: 20px 35px 15px 20px;
        margin-bottom: 2px;
        color: #202020;
        font-size: 20px;
        text-decoration: none;
        background-color: #eaeaea;
        border-radius: 3px;
        -webkit-transition: background-color 0.2s;
        transition: background-color 0.2s;
        cursor: pointer;
        text-transform: uppercase;
        overflow: hidden;
    }

    .dht-wrapper .dht-field-child-accordion.dht-accordion-item .dht-accordion-title:hover {
        background-color: #e5e4e4;
        transition: all 0.5s ease-out;
    }

    .dht-wrapper .dht-field-child-accordion .dht-accordion-item .dht-accordion-active {
        background-color: #e5e4e4;
    }

    .dht-wrapper .dht-field-child-accordion .dht-accordion-item .dht-accordion-title .dht-accordion-arrow {
        position: absolute;
        top: 13px;
        right: 15px;
        display: inline-block;
        vertical-align: middle;
        text-align: center;
        -webkit-transition: all 0.2s ease-out;
        transition: all 0.2s ease-out;
    }

    .dht-wrapper .dht-field-child-accordion .dht-accordion-item .dht-accordion-content {
        padding: 30px;
        margin-bottom: 2px;
        font-size: 14px;
        display: none;
        background-color: #f3f3f3;
    }

    .dht-wrapper .dht-field-child-accordion .dht-accordion-item .dht-accordion-arrow-item,
    .dht-wrapper .dht-field-child-accordion .dht-accordion-item .dht-accordion-arrow-item-close {
        top: 3px;
        position: relative;
        font-size: 25px !important;
    }

    .dht-wrapper .dht-field-child-accordion .dht-accordion-arrow .dht-accordion-arrow-item-close,
    .dht-wrapper .dht-field-child-accordion .dht-accordion-arrow.dht-accordion-icon-change .dht-accordion-arrow-item {
        display: none;
    }

    .dht-wrapper .dht-field-child-accordion .dht-accordion-arrow.dht-accordion-icon-change .dht-accordion-arrow-item-close {
        display: block;
    }

    .dht-wrapper .dht-field-child-accordion .dht-accordion .dht-field-wrapper {
        display: block;
        padding: 0;
    }

    .dht-wrapper .dht-field-child-accordion .dht-accordion .dht-divider {
        margin: 20px 0;
    }

    .dht-wrapper .dht-field-child-accordion .dht-accordion .dht-field-wrapper .dht-title {
        margin-bottom: 10px;
    }

    .dht-wrapper .dht-field-child-accordion .dht-add-toggle {
        margin-top: 5px;
        float: right;
    }

    .dht-wrapper .dht-field-child-accordion .dht-add-toggle.dht-btn-disabled {
        cursor: not-allowed;
        opacity: 0.6;
        pointer-events: none;
    }

    .dht-wrapper .dht-field-child-accordion .dht-accordion-content:after {
        content: "";
        clear: both;
        display: table;
    }

    .dht-wrapper .dht-field-child-accordion .button.button-primary.dht-btn-remove-box-item {
        background: red;
        border-color: red;
        float: right;
    }

    .dht-wrapper .dht-field-child-accordion .dht-toggle-remove-text {
        display: none;
    }

    .dht-wrapper .dht-field-child-accordion span.spinner {
        margin-top: -1px;
    }


</style>
<script>

    jQuery(document).ready(function($) {
        //create accordion
        $(".dht-field-child-accordion").on("click", ".dht-accordion .dht-accordion-title", function(e) {
            e.preventDefault();

            const $current_box_title = $(this);

            if ($current_box_title.hasClass("dht-accordion-active")) return;

            const $current_parent = $current_box_title.parent(".dht-accordion-item");
            const $current_content_area = $current_parent.find(".dht-accordion-content");

            //disable add toggle button
            $current_parent.siblings(".dht-add-toggle").addClass("dht-btn-disabled");

            //get json data
            const json_data = $current_parent.siblings(".dht-accordion-json-data").val();

            $.ajax({
                // @ts-ignore
                url: dht_addable_box_option_ajax.ajax_url,
                type: "POST",
                dataType: "json",
                data: {
                    action: "getBoxOptions", // The name of your AJAX action
                    data: { json_data },
                },
                beforeSend: function() {
                    //show loading spinner
                    $current_box_title.children(".spinner").css("visibility", "visible");

                    // clear content area
                    $current_content_area.empty();
                },
                success: function(response) {
                    if (response.success) {

                        //append HTML content of the options to the box
                        $current_content_area.append(response.data);

                        console.log(response);


                        // Initialize options so they could work as expected
                        setTimeout(function() {
                            dhtReinitializeOptions($current_content_area);
                        }, 100);

                        //get other box items title references
                        const $box_items = $current_parent.siblings(".dht-accordion-item");
                        const $box_title = $box_items.children(".dht-accordion-title");

                        //remove active class from other box items
                        $box_title.removeClass("dht-accordion-active");
                        $box_title.children(".dht-accordion-arrow").removeClass("dht-accordion-icon-change");
                        $box_items.find(".dht-accordion-content").slideUp(400);

                        //add active class and change the icon
                        $current_box_title.toggleClass("dht-accordion-active");
                        $current_box_title.next().slideToggle();
                        $current_box_title.children(".dht-accordion-arrow").toggleClass("dht-accordion-icon-change");

                    } else {
                        console.error("Ajax Response", response);
                    }
                },
                error: function(error) {
                    console.error("AJAX error:", error);
                },
                complete: function() {
                    //hide loading spinner
                    $current_box_title.children(".spinner").css("visibility", "hidden");

                    //enable add toggle button back
                    $current_parent.siblings(".dht-add-toggle").removeClass("dht-btn-disabled");
                },
            });
        });

        // Function to reinitialize options loaded via ajax
        function dhtReinitializeOptions($content) {

            // Trigger custom ajax events based on the presence of specific elements
            {
                //if colorpicker exists in the current content, reload its js code
                if ($content.find(".dht-field-child-colorpicker") || $content.find(".dht-field-child-borders")) {
                    $(document).trigger("dht_colorPickerAjaxComplete");
                }
                //if Ace editor exists in the current content, reload its js code
                if ($content.find(".dht-field-child-code-editor")) {
                    $(document).trigger("dht_aceEditorAjaxComplete");
                }
                //if datepicker exists in the current content, reload its js code
                if ($content.find(".dht-field-child-datepicker")) {
                    $(document).trigger("dht_datePickerAjaxComplete");
                }
                //if datetimepicker exists in the current content, reload its js code
                if ($content.find(".dht-field-child-datetimepicker")) {
                    $(document).trigger("dht_dateTimePickerAjaxComplete");
                }
                //if timepicker exists in the current content, reload its js code
                if ($content.find(".dht-field-child-timepicker")) {
                    $(document).trigger("dht_timePickerAjaxComplete");
                }
                //if rangeslider exists in the current content, reload its js code
                if ($content.find(".dht-field-child-rangeslider")) {
                    $(document).trigger("dht_rangeSliderAjaxComplete");
                }
                //if multioptions exists in the current content, reload its js code
                if ($content.find(".dht-field-child-multioptions")) {
                    $(document).trigger("dht_multiOptionsAjaxComplete");
                }
                //if upload exists in the current content, reload its js code
                if ($content.find(".dht-field-child-upload-item")) {
                    $(document).trigger("dht_uploadAjaxComplete");
                }
                //if upload image exists in the current content, reload its js code
                if ($content.find(".dht-field-child-upload-image")) {
                    $(document).trigger("dht_uploadImageAjaxComplete");
                }
                //if upload gallery exists in the current content, reload its js code
                if ($content.find(".dht-field-child-upload-gallery")) {
                    $(document).trigger("dht_uploadGalleryAjaxComplete");
                }
                //if typography exists in the current content, reload its js code
                if ($content.find(".dht-field-child-typography")) {
                    $(document).trigger("dht_typographyAjaxComplete");
                }
            }

            //reinitialize the wp editor option
            $content.find("textarea.wp-editor-area").each(function() {

                if (typeof wp === "undefined" || typeof wp.editor === "undefined") return;

                //get editor if
                const id = $(this).attr("id");

                if (typeof tinymce !== "undefined") {
                    // Remove existing editors
                    tinymce.execCommand("mceRemoveEditor", true, id);

                    // Reinitialize TinyMCE editor
                    tinymce.execCommand("mceAddEditor", true, id);

                    //add editor skin
                    tinymce.tinymce = {
                        skin: "wp_theme",
                    };

                    // Initialize Quicktags
                    if (typeof quicktags === "function") {
                        quicktags({ id: id });
                    }
                }
            });
        }

        //add new toggle in your accordion
        $(".dht-field-child-accordion").on("click", ".dht-accordion-repeater .dht-add-toggle", function(e) {
            e.preventDefault();

            const $this = $(this);

            let $toggle = $this.prev(".dht-accordion-item").clone();

            //if toggle opened, close it
            $toggle.children(".dht-accordion-title").removeClass("dht-accordion-active");
            $toggle.children(".dht-accordion-title").children(".dht-accordion-arrow").removeClass("dht-accordion-icon-change");
            $toggle.children(".dht-accordion-content").empty().hide();

            //clear box title values
            const $box_title = $toggle.find(".dht-accordion-title-text");
            $box_title.text($box_title.attr("data-default-title"));

            //add the cloned box
            $toggle.insertBefore($this);
        });

        //remove toggle item
        $(".dht-field-child-accordion").on("click", ".dht-accordion-repeater .dht-btn-remove-box-item", function(e) {
            e.preventDefault();

            const $this = $(this);
            const $main_parent = $this.parents(".dht-accordion-repeater");

            if ($main_parent.children(".dht-accordion-item").length === 1) {
                confirm($main_parent.find(".dht-toggle-remove-text").text());

                return;
            }

            $this.parents(".dht-accordion-item").remove();

            return false;
        });

        //change box title on input change event
        $(".dht-field-child-accordion").on("keyup", ".dht-accordion-repeater .dht-accordion-item .dht-box-title", function(e) {

            const value = $(this).val();

            $(this).parents(".dht-accordion-content").siblings(".dht-accordion-title").find(".dht-accordion-title-text").text(value);
        });

        //replace the number of the name and id attributes to save them
        /*$toggle.find("[name]").each(function() {

            const $this = $(this);
            const name_attribute = $this.attr("name");

            let regex = /\[(\d+)\]/;
            let match = name_attribute.match(regex);

            if (match) {
                // Extract the current number and increment it
                let new_number = parseInt(match[1]) + 1;

                // Replace the old number with the new one
                let new_name_attr = name_attribute.replace(regex, "[" + new_number + "]");

                $this.attr("name", new_name_attr);
                $this.attr("id", new_name_attr);
                $this.siblings("label").attr("for", new_name_attr);
            }

        });*/

        //content.find("input:not([type='button']), textarea").val("");
        // content.find("input[type=\"checkbox\"], input[type=\"radio\"]").prop("checked", false);
        //content.attr("value", "");
        //const $box_title = content.find(".dht-accordion-title-text");
        //$box_title.text($box_title.attr("data-default-title"));


    });
</script>