<?php

use function DHT\Helpers\dht_parse_option_attributes;
use function DHT\Helpers\dht_render_option_if_exists;

if ( !defined( 'DHT_MAIN' ) ) die( 'Forbidden' );

$group = $args[ 'group' ] ?? [];
//used to call the render method on
$registered_options = $args[ 'registered_options' ] ?? [];

$saved_values = !empty( $group[ 'value' ] ) ? $group[ 'value' ] : [];

//dht_print_r( $saved_values );
?>
<!-- field - addable box -->

<div class="dht-field-wrapper">

    <div class="dht-title"><?php echo esc_html( $group[ 'title' ] ); ?></div>

    <div
        class="dht-field-child-wrapper dht-field-child-accordion <?php echo isset( $group[ 'attr' ][ 'class' ] ) ? esc_attr( $group[ 'attr' ][ 'class' ] ) : ''; ?>"
        <?php echo dht_parse_option_attributes( $group[ 'attr' ] ); ?>>

        <div class="dht-accordion dht-accordion-repeater">

            <?php if ( !empty( $group[ 'options' ] ) ): ?>

                <?php if ( !empty( $saved_values ) ): ?>

                    <?php foreach ( $saved_values as $key => $saved_value ): ?>

                        <?php
                        dht_display_toggle( $group, $saved_value, $registered_options, $key );
                        ?>

                    <?php endforeach; ?>

                <?php else: ?>

                    <?php dht_display_toggle( $group, [], $registered_options ); ?>

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
function dht_display_toggle( array $group, mixed $saved_values, array $registered_options, int $cnt = 1 ) : void {

    $default_box_title = _x( 'Box Title', 'options', DHT_PREFIX );
    ?>
    <div class="dht-accordion-item">

        <div class="dht-accordion-title">

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

            <!--box title field-->
            <div class="dht-field-wrapper">
                <div class="dht-field-box-wrapper dht-field-child-input">
                    <label
                        for="<?php echo esc_attr( $group[ 'id' ] ); ?>[<?php echo esc_attr( $cnt ); ?>][box-title]">
                        <?php echo !empty( $saved_values[ 'box-title' ] ) ? esc_html( $saved_values[ 'box-title' ] ) : _x( 'Box Title', 'options', DHT_PREFIX ); ?>
                    </label>
                    <input
                        class="dht-input dht-field dht-box-title"
                        id="<?php echo esc_attr( $group[ 'id' ] ); ?>[<?php echo esc_attr( $cnt ); ?>][box-title]"
                        type="text"
                        name="<?php echo esc_attr( $group[ 'id' ] ); ?>[<?php echo esc_attr( $cnt ); ?>][box-title]"
                        value="<?php echo !empty( $saved_values[ 'box-title' ] ) ? esc_html( $saved_values[ 'box-title' ] ) : ''; ?>"
                        placeholder="<?php echo esc_attr( $default_box_title ); ?>" />
                </div>
            </div>

            <div class="dht-divider"></div>

            <!--box fields-->
            <?php foreach ( $group[ 'options' ] as $option ) : ?>

                <?php
                //get option saved value if exists
                $saved_value = array_key_exists( $option[ 'id' ], $saved_values ) ? $saved_values[ $option[ 'id' ] ] : '';

                //render the specific option type
                echo dht_render_option_if_exists( $option, $saved_value, $group[ 'id' ] . '[' . esc_attr( $cnt ) . ']', $registered_options );
                ?>

            <?php endforeach; ?>

            <!--remove box area-->
            <div class="dht-remove-toggle">
                <div class="dht-divider"></div>

                <a href=""
                   class="button button-primary dht-btn-remove"><?php _ex( 'Remove Box', 'options', DHT_PREFIX ); ?></a>
            </div>

        </div>

    </div>
<?php } ?>

<style>
    .dht-wrapper .dht-field-child-accordion .dht-accordion-item {
        margin: 5px auto;
    }

    .dht-wrapper .dht-field-child-accordion .dht-accordion-item .dht-accordion-title {
        position: relative;
        display: block;
        padding: 20px 60px 15px 20px;
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

    .dht-wrapper .dht-field-child-accordion .dht-accordion-content:after {
        content: "";
        clear: both;
        display: table;
    }

    .dht-wrapper .dht-field-child-accordion .button.button-primary.dht-btn-remove {
        background: red;
        border-color: red;
        float: right;
    }

    .dht-wrapper .dht-field-child-accordion .dht-toggle-remove-text {
        display: none;
    }
</style>
<script>

    jQuery(document).ready(function($) {
        //create accordion
        $(".dht-field-child-accordion").on("click", ".dht-accordion .dht-accordion-title", function(e) {
            e.preventDefault();

            const $this = $(this);

            if ($this.hasClass("dht-accordion-active")) return;

            const $parent = $this.parents(".dht-accordion");

            if (!$this.hasClass("dht-accordion-active")) {
                $parent.find(".dht-accordion-content").slideUp(400);
                $parent.find(".dht-accordion-title").removeClass("dht-accordion-active");
                $parent.find(".dht-accordion-arrow").removeClass("dht-accordion-icon-change");
            }

            $this.toggleClass("dht-accordion-active");
            $this.next().slideToggle();
            $(".dht-accordion-arrow", this).toggleClass("dht-accordion-icon-change");
        });

        //add new toggle in your accordion
        $(".dht-field-child-accordion").on("click", ".dht-accordion-repeater .dht-add-toggle", function(e) {
            e.preventDefault();

            const $this = $(this);

            let $toggle = $this.prev(".dht-accordion-item").clone();

            //replace the number of the name and id attributes to save them
            $toggle.find("[name]").each(function() {

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

            });

            //if toggle opened, close it
            $toggle.children(".dht-accordion-title").removeClass("dht-accordion-active");
            $toggle.children(".dht-accordion-title").children(".dht-accordion-arrow").removeClass("dht-accordion-icon-change");
            $toggle.children(".dht-accordion-content").hide();

            //clear inout values
            dhtClearFormInputs($toggle);

            $toggle.insertBefore($this);
        });

        //remove toggle item
        $(".dht-field-child-accordion").on("click", ".dht-accordion-repeater .dht-btn-remove", function(e) {
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

        //change box title on inout change event
        $(".dht-field-child-accordion").on("keyup", ".dht-accordion-repeater .dht-accordion-item .dht-box-title", function(e) {

            console.log("dsdsadasds");

            const value = $(this).val();

            $(this).parents(".dht-accordion-content").siblings(".dht-accordion-title").find(".dht-accordion-title-text").text(value);
        });

        // Function to clear form inputs
        function dhtClearFormInputs(content) {
            content.find("input[type=\"text\"], input[type=\"email\"], textarea").val("");
            content.find("input[type=\"checkbox\"], input[type=\"radio\"]").prop("checked", false);
            content.attr("value", "");
            const $box_title = content.find(".dht-accordion-title-text");
            $box_title.text($box_title.attr("data-default-title"));
        }
    });
</script>