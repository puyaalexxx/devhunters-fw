<?php
if ( !defined( 'DHT_MAIN' ) ) die( 'Forbidden' );

use function DHT\Helpers\dht_parse_option_attributes;

$option = $args[ 'option' ] ?? [];

//spacing sizes
$sizes = [ "px" => 'px', "percentage" => '%', "em" => 'em', "rem" => 'rem', "vw" => 'vw', "vh" => 'vh' ];
?>
    <!-- field - spacing -->
    <div class="dht-field-wrapper">

        <div class="dht-title"><?php echo esc_html( $option[ 'title' ] ); ?></div>

        <div
            class="dht-field-child-wrapper dht-field-child-spacing <?php echo isset( $option[ 'attr' ][ 'class' ] ) ? esc_attr( $option[ 'attr' ][ 'class' ] ) : ''; ?>"
            <?php echo dht_parse_option_attributes( $option[ 'attr' ] ); ?>
        >

            <div class="dht-field-spacing-group">

                <div class="dht-field-spacing-input">

                    <label
                        for="<?php echo esc_attr( $option[ 'id' ] ); ?>-top"><?php echo _x( 'Top', 'options', DHT_PREFIX ); ?></label>

                    <span class="dht-spacing-top"></span>

                    <input class="dht-spacing dht-field"
                           id="<?php echo esc_attr( $option[ 'id' ] ); ?>-top"
                           type="number"
                           name="<?php echo esc_attr( $option[ 'id' ] ); ?>[top]"
                           value="<?php echo esc_attr( $option[ 'value' ][ 'top' ] ); ?>" />

                </div>

                <div class="dht-field-spacing-input">

                    <label
                        for="<?php echo esc_attr( $option[ 'id' ] ); ?>-right"><?php echo _x( 'Right', 'options', DHT_PREFIX ); ?></label>

                    <span class="dht-spacing-right"></span>

                    <input class="dht-spacing dht-field"
                           id="<?php echo esc_attr( $option[ 'id' ] ); ?>-right"
                           type="number"
                           name="<?php echo esc_attr( $option[ 'id' ] ); ?>[right]"
                           value="<?php echo esc_attr( $option[ 'value' ][ 'right' ] ); ?>" />

                </div>

                <div class="dht-field-spacing-input">

                    <label
                        for="<?php echo esc_attr( $option[ 'id' ] ); ?>-bottom"><?php echo _x( 'Bottom', 'options', DHT_PREFIX ); ?></label>

                    <span class="dht-spacing-bottom"></span>

                    <input class="dht-spacing dht-field"
                           id="<?php echo esc_attr( $option[ 'id' ] ); ?>-bottom"
                           type="number"
                           name="<?php echo esc_attr( $option[ 'id' ] ); ?>[bottom]"
                           value="<?php echo esc_attr( $option[ 'value' ][ 'bottom' ] ); ?>" />

                </div>

                <div class="dht-field-spacing-input">

                    <label
                        for="<?php echo esc_attr( $option[ 'id' ] ); ?>-left"><?php echo _x( 'Left', 'options', DHT_PREFIX ); ?></label>

                    <span class="dht-spacing-left"></span>

                    <input class="dht-spacing dht-field"
                           id="<?php echo esc_attr( $option[ 'id' ] ); ?>-left"
                           type="number"
                           name="<?php echo esc_attr( $option[ 'id' ] ); ?>[left]"
                           value="<?php echo esc_attr( $option[ 'value' ][ 'left' ] ); ?>" />

                </div>

                <div class="dht-field-spacing-input">

                    <label
                        for="<?php echo esc_attr( $option[ 'id' ] ); ?>-sizes"><?php echo _x( 'Sizes', 'options', DHT_PREFIX ); ?></label>

                    <select class="dht-spacing-dropdown dht-field"
                            name="<?php echo esc_attr( $option[ 'id' ] ); ?>[size]"
                            id="<?php echo esc_attr( $option[ 'id' ] ); ?>-sizes">

                        <?php foreach ( $sizes as $key => $size ): ?>
                            <option
                                value="<?php echo esc_attr( $key ); ?>" <?php echo $option[ 'value' ][ 'size' ] == $key ? 'selected' : ''; ?>><?php echo esc_html( $size ); ?></option>
                        <?php endforeach; ?>

                    </select>

                </div>
            </div>

            <?php //echo esc_attr( $option[ 'value' ] ); ?>

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