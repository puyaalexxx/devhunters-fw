<?php

use function DHT\Helpers\dht_parse_option_attributes;

if ( !defined( 'DHT_MAIN' ) ) die( 'Forbidden' );

$option = $args[ 'option' ] ?? [];

$on_off_class = in_array( $option[ 'value' ], $option[ 'left-choice' ] ) ? 'dht-slider-on' : 'dht-slider-off';
?>
    <!-- field - switch  -->
    <div
        class="dht-field-wrapper <?php echo isset( $option[ 'attr' ][ 'class' ] ) ? esc_attr( $option[ 'attr' ][ 'class' ] ) : ''; ?>" <?php echo dht_parse_option_attributes( $option[ 'attr' ] ); ?>>

        <div class="dht-title"><?php echo esc_html( $option[ 'title' ] ); ?></div>

        <div class="dht-field-child-wrapper dht-field-child-switch">

            <label class="dht-switch <?php echo esc_attr( $on_off_class ); ?>"
                   for="<?php echo esc_attr( $option[ 'id' ] ); ?>">

                <input type="hidden" name="<?php echo esc_attr( $option[ 'id' ] ); ?>"
                       value="<?php echo esc_attr( $option[ 'value' ] ); ?>" />

                <span class="dht-slider">
                    <span class="dht-slider-yes"
                          data-value="<?php echo esc_attr( $option[ 'left-choice' ][ 'value' ] ); ?>"><?php echo esc_attr( $option[ 'left-choice' ][ 'label' ] ); ?></span>
                    <span class="dht-slider-no"
                          data-value="<?php echo esc_attr( $option[ 'right-choice' ][ 'value' ] ); ?>"><?php echo esc_attr( $option[ 'right-choice' ][ 'label' ] ); ?></span>
                </span>

            </label>

            <?php if ( !empty( $option[ 'description' ] ) ): ?>
                <div class="dht-description"><?php echo esc_html( $option[ 'description' ] ); ?></div>
            <?php endif; ?>

        </div>

        <?php if ( !empty( $option[ 'tooltip' ] ) ): ?>
            <div class="dht-info-help dashicons dashicons-info"
                 data-tooltips="<?php echo esc_html( $option[ 'tooltip' ] ); ?>"
                 data-position="OnLeft">
            </div>
        <?php endif; ?>

    </div>

<?php if ( isset( $option[ 'divider' ] ) && $option[ 'divider' ] ): ?>
    <div class="dht-divider"></div>
<?php endif; ?>