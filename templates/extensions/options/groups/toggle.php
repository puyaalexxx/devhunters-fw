<?php

use function DHT\Helpers\dht_render_option_if_exists;

if ( !defined( 'DHT_MAIN' ) ) die( 'Forbidden' );

$group = $args[ 'group' ] ?? [];
//used to call the render method on
$registered_options = $args[ 'registered_options' ] ?? [];
//saved values
$saved_values = $args[ 'saved_values' ] ?? [];

$on_off_class = in_array( $group[ 'value' ], $group[ 'left-choice' ] ) ? 'dht-slider-on' : 'dht-slider-off';

$left_choice = $group[ 'left-choice' ];
$right_choice = $group[ 'right-choice' ];
?>
<!-- field - toggle  -->
<div class="dht-field-wrapper">

    <div class="dht-title"><?php echo esc_html( $group[ 'title' ] ); ?></div>

    <div class="dht-field-child-wrapper dht-field-child-toggle">

        <label class="dht-toggle <?php echo esc_attr( $on_off_class ); ?>"
               for="<?php echo esc_attr( $group[ 'id' ] ); ?>">

            <input type="hidden" name="<?php echo esc_attr( $group[ 'id' ] ); ?>[value]"
                   value="<?php echo esc_attr( $group[ 'value' ] ); ?>" />

            <span class="dht-slider">
                    <span class="dht-slider-yes"
                          data-value="<?php echo esc_attr( $left_choice[ 'value' ] ); ?>"><?php echo esc_attr( $left_choice[ 'label' ] ); ?></span>
                    <span class="dht-slider-no"
                          data-value="<?php echo esc_attr( $right_choice[ 'value' ] ); ?>"><?php echo esc_attr( $right_choice[ 'label' ] ); ?></span>
                </span>

        </label>

        <?php if ( !empty( $left_choice[ 'options' ] ) ): ?>

            <div
                class="dht-toggle-content dht-toggle-left-choice <?php echo $left_choice[ 'value' ] == $group[ 'value' ] ? 'dht-toggle-show' : ''; ?>"
                data-toggle-value="<?php echo esc_attr( $left_choice[ 'value' ] ); ?>">
                <?php
                foreach ( $left_choice[ 'options' ] as $group_option ) {

                    //get saved value
                    $saved_value = $saved_values[ 'left-choice' ][ $group_option[ 'id' ] ] ?? [];

                    //render the specific option type
                    echo dht_render_option_if_exists( $group_option, $saved_value, $group[ 'id' ] . '[left-choice]', $registered_options );
                }
                ?>
            </div>

        <?php endif; ?>

        <?php if ( !empty( $right_choice[ 'options' ] ) ): ?>

            <div
                class="dht-toggle-content dht-toggle-right-choice <?php echo $right_choice[ 'value' ] == $group[ 'value' ] ? 'dht-toggle-show' : ''; ?>"
                data-toggle-value="<?php echo esc_attr( $right_choice[ 'value' ] ); ?>">
                <?php
                foreach ( $right_choice[ 'options' ] as $group_option ) {

                    //get saved value
                    $saved_value = $saved_values[ 'right-choice' ][ $group_option[ 'id' ] ] ?? [];

                    //render the specific option type
                    echo dht_render_option_if_exists( $group_option, $saved_value, $group[ 'id' ] . '[right-choice]', $registered_options );
                }
                ?>
            </div>

        <?php endif; ?>

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

<script>
    jQuery(document).ready(function($) {
        $(".dht-field-child-toggle .dht-toggle").on("click", function() {

            const $this = $(this);
            const input_value = $(this).children("input").attr("value");

            $this.siblings(".dht-toggle-content").each(function() {

                $(this).removeClass("dht-toggle-show");

                if ($(this).attr("data-toggle-value") === input_value) {
                    $(this).addClass("dht-toggle-show");
                }
            });
        });
    });
</script>
