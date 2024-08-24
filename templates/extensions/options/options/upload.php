<?php
if ( !defined( 'DHT_MAIN' ) ) die( 'Forbidden' );

use function DHT\Helpers\dht_parse_option_attributes;

$option = $args[ 'option' ] ?? [];

$item_url = '';
//if item id present
if ( !empty( $option[ 'value' ][ 'item_id' ] ) ) {

    $attachemnt_url = wp_get_attachment_url( (int)$option[ 'value' ][ 'item_id' ] );
    $item_url = $attachemnt_url;
} //if item link present
elseif ( !empty( $option[ 'value' ][ 'item' ] ) ) {

    $item_url = $option[ 'value' ][ 'item' ];
}
?>
<!--upload field-->
<div
    class="dht-field-wrapper <?php echo isset( $option[ 'attr' ][ 'class' ] ) ? esc_attr( $option[ 'attr' ][ 'class' ] ) : ''; ?>" <?php echo dht_parse_option_attributes( $option[ 'attr' ] ); ?>>

    <div class="dht-title"><?php echo esc_html( $option[ 'title' ] ); ?></div>

    <div class="dht-field-child-wrapper dht-field-child-upload dht-field-child-upload-item">

        <label
            for="<?php echo esc_attr( $option[ 'id' ] ); ?>"><?php echo esc_html( $option[ 'title' ] ); ?></label><br />

        <input class="dht-upload-item dht-field"
               type="text"
               id="<?php echo esc_attr( $option[ 'id' ] ); ?>"
               name="<?php echo esc_attr( $option[ 'id' ] ); ?>[item]"
               value="<?php echo !empty( $item_url ) ? esc_url( $item_url ) : ''; ?>" />

        <input class="dht-upload-item-hidden dht-field"
               type="hidden"
               name="<?php echo esc_attr( $option[ 'id' ] ); ?>[item_id]"
               value="<?php echo !empty( $option[ 'value' ][ 'item_id' ] ) ? esc_attr( (int)$option[ 'value' ][ 'item_id' ] ) : ''; ?>" />

        <span class="dht-upload-item-button button"
              data-media-text="<?php echo _x( 'Choose File', 'options', DHT_PREFIX ) ?>"
              data-media-type="<?php echo !empty( $option[ 'file_type' ] ) ? esc_attr( $option[ 'file_type' ] ) : 'video'; ?>">
            <?php echo _x( 'Upload', 'options', DHT_PREFIX ) ?>
        </span>

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
