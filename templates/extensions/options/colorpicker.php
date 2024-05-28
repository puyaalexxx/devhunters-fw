<?php
if ( !defined( 'DHT_MAIN' ) ) die( 'Forbidden' );

use function DHT\Helpers\dht_parse_option_attributes;

$option = $args[ 'option' ] ?? [];
?>
    <!-- field - colorpicker -->
    <div class="dht-field-wrapper">

        <div class="dht-title"><?php echo esc_html( $option[ 'title' ] ); ?></div>

        <div
            class="dht-field-child-wrapper dht-field-child-colorpicker <?php echo isset( $option[ 'attr' ][ 'class' ] ) ? esc_attr( $option[ 'attr' ][ 'class' ] ) : ''; ?>"
            <?php echo dht_parse_option_attributes( $option[ 'attr' ] ); ?>>

            <label
                for="<?php echo esc_attr( $option[ 'id' ] ); ?>"><?php echo esc_html( $option[ 'label' ] ); ?></label>

            <input
                class="dht-colorpicker dht-field"
                id="<?php echo esc_attr( $option[ 'id' ] ); ?>"
                type="text"
                <?php echo ( $option[ 'subtype' ] == 'rgba' ) ? 'data-alpha="true" data-alpha-enabled="true"' : 'data-alpha="false" data-alpha-enabled="false"'; ?>
                name="<?php echo esc_attr( $option[ 'id' ] ); ?>"
                value="<?php echo esc_html( $option[ 'value' ] ); ?>"
                data-palette='<?php echo !empty( $option[ 'palettes' ] ) ? json_encode( $option[ 'palettes' ] ) : ''; ?>' />

            <input type="button" id="<?php echo esc_attr( $option[ 'id' ] ) . '-btn'; ?>"
                   class="dht-default-color-btn button button-small"
                   data-default-value="<?php echo esc_html( $option[ 'value' ] ); ?>"
                   value="<?php echo _x( 'Default', 'options', DHT_PREFIX ) ?>">

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