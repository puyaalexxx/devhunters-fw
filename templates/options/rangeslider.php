<?php
if ( !defined( 'DHT_MAIN' ) ) die( 'Forbidden' );

use function DHT\Helpers\dht_parse_option_attributes;

$args = $args ?? [];
?>
    <!-- field - rangeslider -->
    <div class="dht-field-wrapper">

        <div class="dht-title"><?php echo esc_html( $args[ 'title' ] ); ?></div>

        <div
            class="dht-field-child-wrapper dht-field-child-rangeslider <?php echo isset( $args[ 'attr' ][ 'class' ] ) ? esc_attr( $args[ 'attr' ][ 'class' ] ) : ''; ?>"
            <?php echo dht_parse_option_attributes( $args[ 'attr' ] ); ?>>

            <?php if ( isset( $args[ 'range' ] ) && $args[ 'range' ] ): ?>

                <div class="dht-slider-group">

                    <label
                        for="<?php echo esc_attr( $args[ 'id' ] ); ?>-1"><?php echo esc_html( $args[ 'label' ] ); ?></label>
                    <input class="dht-range-slider dht-range-slider-1 dht-field"
                           id="<?php echo esc_attr( $args[ 'id' ] ); ?>-1"
                           type="text"
                           name="<?php echo esc_attr( $args[ 'id' ] ); ?>[]"
                           value="<?php echo !empty( $args[ 'value' ] ) ? $args[ 'value' ][ 0 ] : ''; ?>"
                    />
                    -
                    <label
                        for="<?php echo esc_attr( $args[ 'id' ] ); ?>-2"><?php echo esc_html( $args[ 'label' ] ); ?></label>
                    <input class="dht-range-slider dht-range-slider-2 dht-field"
                           id="<?php echo esc_attr( $args[ 'id' ] ); ?>-2"
                           type="text"
                           name="<?php echo esc_attr( $args[ 'id' ] ); ?>[]"
                           value="<?php echo !empty( $args[ 'value' ] ) ? $args[ 'value' ][ 1 ] : ''; ?>"
                    />
                </div>

                <!--range slider -->
                <div class="dht-slider-slider"
                     data-range="yes"
                     data-values="<?php echo implode( ',', $args[ 'value' ] ); ?>"
                     data-min="<?php echo (int)$args[ 'min' ]; ?>"
                     data-max="<?php echo (int)$args[ 'max' ]; ?>"
                >
                </div>

            <?php else: ?>

                <label
                    for="<?php echo esc_attr( $args[ 'id' ] ); ?>"><?php echo esc_html( $args[ 'label' ] ); ?></label>
                <input class="dht-slider dht-field"
                       id="<?php echo esc_attr( $args[ 'id' ] ); ?>"
                       type="text"
                       name="<?php echo esc_attr( $args[ 'id' ] ); ?>"
                       value="<?php echo esc_html( $args[ 'value' ] ); ?>" />

                <!--range slider -->
                <div class="dht-slider-slider"
                     data-range="no"
                     data-values="<?php echo (int)$args[ 'value' ]; ?>"
                     data-min="<?php echo (int)$args[ 'min' ]; ?>"
                     data-max="<?php echo (int)$args[ 'max' ]; ?>"
                >
                </div>

            <?php endif; ?>

            <?php if ( !empty( $args[ 'description' ] ) ): ?>
                <div class="dht-description"><?php echo esc_html( $args[ 'description' ] ); ?></div>
            <?php endif; ?>

        </div>

        <?php if ( !empty( $args[ 'tooltip' ] ) ): ?>
            <div class="dht-info-help dashicons dashicons-info"
                 data-tooltips="<?php echo esc_html( $args[ 'tooltip' ] ); ?>"
                 data-position="OnLeft">
            </div>
        <?php endif; ?>

    </div>

<?php if ( $args[ 'divider' ] ): ?>
    <div class="dht-divider"></div>
<?php endif; ?>