<?php
if ( !defined( 'DHT_MAIN' ) ) die( 'Forbidden' );

use function DHT\Helpers\dht_parse_option_attributes;

$option = $args[ 'option' ] ?? [];
?>
    <!-- field - rangeslider -->
    <div class="dht-field-wrapper">

        <div class="dht-title"><?php echo esc_html( $option[ 'title' ] ); ?></div>

        <div
            class="dht-field-child-wrapper dht-field-child-rangeslider <?php echo isset( $option[ 'attr' ][ 'class' ] ) ? esc_attr( $option[ 'attr' ][ 'class' ] ) : ''; ?>"
            <?php echo dht_parse_option_attributes( $option[ 'attr' ] ); ?>>

            <?php if ( isset( $option[ 'range' ] ) && $option[ 'range' ] ): ?>

                <div class="dht-slider-group">

                    <label
                        for="<?php echo esc_attr( $option[ 'id' ] ); ?>-1"><?php echo esc_html( $option[ 'label' ] ); ?></label>
                    <input class="dht-range-slider dht-range-slider-1 dht-field"
                           id="<?php echo esc_attr( $option[ 'id' ] ); ?>-1"
                           type="text"
                           name="<?php echo esc_attr( $option[ 'id' ] ); ?>[]"
                           value="<?php echo !empty( $option[ 'value' ] ) ? $option[ 'value' ][ 0 ] : ''; ?>" />
                    -
                    <label
                        for="<?php echo esc_attr( $option[ 'id' ] ); ?>-2"><?php echo esc_html( $option[ 'label' ] ); ?></label>
                    <input class="dht-range-slider dht-range-slider-2 dht-field"
                           id="<?php echo esc_attr( $option[ 'id' ] ); ?>-2"
                           type="text"
                           name="<?php echo esc_attr( $option[ 'id' ] ); ?>[]"
                           value="<?php echo !empty( $option[ 'value' ] ) ? $option[ 'value' ][ 1 ] : ''; ?>" />
                </div>

                <!--range slider -->
                <div class="dht-slider-slider"
                     data-range="yes"
                     data-values="<?php echo implode( ',', $option[ 'value' ] ); ?>"
                     data-min="<?php echo (int)$option[ 'min' ]; ?>"
                     data-max="<?php echo (int)$option[ 'max' ]; ?>"
                >
                </div>

            <?php else: ?>

                <label
                    for="<?php echo esc_attr( $option[ 'id' ] ); ?>"><?php echo esc_html( $option[ 'label' ] ); ?></label>
                <input class="dht-slider dht-field"
                       id="<?php echo esc_attr( $option[ 'id' ] ); ?>"
                       type="text"
                       name="<?php echo esc_attr( $option[ 'id' ] ); ?>"
                       value="<?php echo esc_html( $option[ 'value' ] ); ?>" />

                <!--range slider -->
                <div class="dht-slider-slider"
                     data-range="no"
                     data-values="<?php echo (int)$option[ 'value' ]; ?>"
                     data-min="<?php echo (int)$option[ 'min' ]; ?>"
                     data-max="<?php echo (int)$option[ 'max' ]; ?>"
                >
                </div>

            <?php endif; ?>

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