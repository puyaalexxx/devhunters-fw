<?php
if ( !defined( 'DHT_MAIN' ) ) die( 'Forbidden' );

use function DHT\Helpers\dht_parse_option_attributes;

$args = $args ?? [];

//border styles
$styles = [ "solid" => 'Solid', "dashed" => 'Dashed', "dotted" => 'Dotted', "double" => 'Double', "none" => 'None' ];
?>
<!-- field - borders -->
<div class="dht-field-wrapper">

    <div class="dht-title"><?php echo esc_html( $args[ 'title' ] ); ?></div>

    <div
        class="dht-field-child-wrapper dht-field-child-borders <?php echo isset( $args[ 'attr' ][ 'class' ] ) ? esc_attr( $args[ 'attr' ][ 'class' ] ) : ''; ?>"
        <?php echo dht_parse_option_attributes( $args[ 'attr' ] ); ?>>

        <div class="dht-field-borders-group">

            <div class="dht-field-borders-input">

                <label
                    for="<?php echo esc_attr( $args[ 'id' ] ); ?>-top"><?php echo _x( 'Top', 'options', DHT_PREFIX ) ?></label>

                <span class="dht-borders-top"></span>

                <input class="dht-borders dht-field"
                       id="<?php echo esc_attr( $args[ 'id' ] ); ?>-top"
                       type="number"
                       min="0"
                       name="<?php echo esc_attr( $args[ 'id' ] ); ?>[top]"
                       value="<?php echo esc_attr( $args[ 'value' ][ 'top' ] ); ?>" />

            </div>

            <div class="dht-field-borders-input">

                <label
                    for="<?php echo esc_attr( $args[ 'id' ] ); ?>-right"><?php echo _x( 'Right', 'options', DHT_PREFIX ) ?></label>

                <span class="dht-borders-right"></span>

                <input class="dht-borders dht-field"
                       id="<?php echo esc_attr( $args[ 'id' ] ); ?>-right"
                       type="number"
                       min="0"
                       name="<?php echo esc_attr( $args[ 'id' ] ); ?>[right]"
                       value="<?php echo esc_attr( $args[ 'value' ][ 'right' ] ); ?>" />

            </div>

            <div class="dht-field-borders-input">

                <label
                    for="<?php echo esc_attr( $args[ 'id' ] ); ?>-bottom"><?php echo _x( 'Bottom', 'options', DHT_PREFIX ) ?></label>

                <span class="dht-borders-bottom"></span>

                <input class="dht-borders dht-field"
                       id="<?php echo esc_attr( $args[ 'id' ] ); ?>-bottom"
                       type="number"
                       min="0"
                       name="<?php echo esc_attr( $args[ 'id' ] ); ?>[bottom]"
                       value="<?php echo esc_attr( $args[ 'value' ][ 'bottom' ] ); ?>" />

            </div>

            <div class="dht-field-borders-input">

                <label
                    for="<?php echo esc_attr( $args[ 'id' ] ); ?>-left"><?php echo _x( 'Left', 'options', DHT_PREFIX ) ?></label>

                <span class="dht-borders-left"></span>

                <input class="dht-borders dht-field"
                       id="<?php echo esc_attr( $args[ 'id' ] ); ?>-left"
                       type="number"
                       min="0"
                       name="<?php echo esc_attr( $args[ 'id' ] ); ?>[left]"
                       value="<?php echo esc_attr( $args[ 'value' ][ 'left' ] ); ?>" />

            </div>

            <div class="dht-field-borders-input">

                <label
                    for="<?php echo esc_attr( $args[ 'id' ] ); ?>-style"><?php echo _x( 'Style', 'options', DHT_PREFIX ) ?></label>

                <select class="dht-borders-dropdown dht-field"
                        name="<?php echo esc_attr( $args[ 'id' ] ); ?>[style]"
                        id="<?php echo esc_attr( $args[ 'id' ] ); ?>-style">

                    <?php foreach ( $styles as $key => $style ): ?>
                        <option
                            value="<?php echo esc_attr( $key ); ?>" <?php echo $args[ 'value' ][ 'style' ] == $key ? 'selected' : ''; ?>><?php echo esc_html( $style ); ?></option>
                    <?php endforeach; ?>

                </select>

            </div>
        </div>

        <div class="dht-field-borders-group-colorpicker">

            <label for="<?php echo esc_attr( $args[ 'id' ] ); ?>-color"></label>

            <input class="dht-alphacolorpicker dht-field"
                   id="<?php echo esc_attr( $args[ 'id' ] ); ?>-color"
                   type="text"
                   name="<?php echo esc_attr( $args[ 'id' ] ); ?>[color]"
                   value="<?php echo esc_html( $args[ 'value' ][ 'color' ] ); ?>"
                   data-palette='<?php echo !empty( $args[ 'palettes' ] ) ? json_encode( $args[ 'palettes' ] ) : ''; ?>' />

            <input type="button" id="<?php echo esc_attr( $args[ 'id' ] ) . '-btn'; ?>"
                   class="dht-default-color-btn button button-small"
                   data-default-value="<?php echo esc_html( $args[ 'value' ][ 'color' ] ); ?>"
                   value="<?php echo _x( 'Default', 'options', DHT_PREFIX ) ?>">

        </div>

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
