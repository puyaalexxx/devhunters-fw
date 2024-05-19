<?php
if ( !defined( 'DHT_MAIN' ) ) die( 'Forbidden' );

use function DHT\Helpers\dht_parse_option_attributes;

$args = $args ?? [];

$item_url = '';
//if item id present
if ( !empty( $args[ 'value' ][ 'item_id' ] ) ) {

    $attachemnt_url = wp_get_attachment_url( (int)$args[ 'value' ][ 'item_id' ] );
    $item_url = $attachemnt_url;
} //if item link present
elseif ( !empty( $args[ 'value' ][ 'item' ] ) ) {

    $item_url = $args[ 'value' ][ 'item' ];
}
?>
<!--upload field-->
<div class="dht-field-wrapper">

    <div class="dht-title"><?php echo esc_html( $args[ 'title' ] ); ?></div>

    <div
        class="dht-field-child-wrapper dht-field-child-upload dht-field-child-upload-item <?php echo isset( $args[ 'attr' ][ 'class' ] ) ? esc_attr( $args[ 'attr' ][ 'class' ] ) : ''; ?>"
        <?php echo dht_parse_option_attributes( $args[ 'attr' ] ); ?>>

        <label
            for="<?php echo esc_attr( $args[ 'id' ] ); ?>"><?php echo esc_html( $args[ 'label' ] ); ?></label><br />

        <input class="dht-upload-item dht-field"
               type="text"
               id="<?php echo esc_attr( $args[ 'id' ] ); ?>"
               name="<?php echo esc_attr( $args[ 'id' ] ); ?>[item]"
               value="<?php echo !empty( $item_url ) ? esc_url( $item_url ) : ''; ?>" />

        <input class="dht-upload-item-hidden dht-field"
               type="hidden"
               name="<?php echo esc_attr( $args[ 'id' ] ); ?>[item_id]"
               value="<?php echo !empty( $args[ 'value' ][ 'item_id' ] ) ? esc_attr( (int)$args[ 'value' ][ 'item_id' ] ) : ''; ?>" />

        <span class="dht-upload-item-button button"
              data-media-text="<?php echo _x( 'Choose File', 'options', DHT_PREFIX ) ?>"
              data-media-type="<?php echo !empty( $args[ 'file_type' ] ) ? esc_attr( $args[ 'file_type' ] ) : 'video'; ?>">
            <?php echo _x( 'Upload', 'options', DHT_PREFIX ) ?>
        </span>

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
