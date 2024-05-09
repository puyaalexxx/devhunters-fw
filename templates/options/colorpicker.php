<?php
if ( !defined( 'DHT_MAIN' ) ) die( 'Forbidden' );

use function DHT\Helpers\dht_parse_option_attributes;

$args = $args ?? [];
?>
<!-- field - colorpicker -->
<div class="dht-field-wrapper">

    <div class="dht-title"><?php echo esc_html( $args[ 'title' ] ); ?></div>

    <div
        class="dht-field-child-wrapper dht-field-child-colorpicker <?php echo isset( $args[ 'attr' ][ 'class' ] ) ? esc_attr( $args[ 'attr' ][ 'class' ] ) : ''; ?>"
        <?php echo dht_parse_option_attributes( $args[ 'attr' ] ); ?>>

        <label for="<?php echo esc_attr( $args[ 'id' ] ); ?>"><?php echo esc_html( $args[ 'label' ] ); ?></label>

        <input class="dht-alphacolorpicker dht-field"
               id="<?php echo esc_attr( $args[ 'id' ] ); ?>"
               type="text"
            <?php echo ( $args[ 'subtype' ] == 'rgba' ) ? 'data-alpha="true" data-alpha-enabled="true"' : 'data-alpha="false" data-alpha-enabled="false"'; ?>
               name="<?php echo esc_attr( $args[ 'id' ] ); ?>"
               value="<?php echo esc_html( $args[ 'value' ] ); ?>"
               data-palette='<?php echo !empty( $args[ 'palettes' ] ) ? json_encode( $args[ 'palettes' ] ) : ''; ?>'
        />

        <input type="button" id="<?php echo esc_attr( $args[ 'id' ] ) . '-btn'; ?>"
               class="dht-default-color-btn button button-small"
               value="Default">

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