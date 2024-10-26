<?php
if( !defined( 'DHT_MAIN' ) ) {
	die( 'Forbidden' );
}

use function DHT\Helpers\dht_fw_live_option_selectors;
use function DHT\Helpers\dht_parse_option_attributes;

$field = $args[ 'field' ] ?? [];

$item_url = '';
//if item id present
if( !empty( $field[ 'value' ][ 'item_id' ] ) ) {
	
	$attachemnt_url = wp_get_attachment_url( (int) $field[ 'value' ][ 'item_id' ] );
	$item_url       = $attachemnt_url;
} //if item link present
elseif( !empty( $field[ 'value' ][ 'item' ] ) ) {
	
	$item_url = $field[ 'value' ][ 'item' ];
}
?>
<!--upload field-->

<?php do_action( 'dht:options:view:fields:upload_before_area' ); ?>

<div
    class="dht-field-wrapper dht-field-wrapper-upload-item <?php echo isset( $field[ 'attr' ][ 'class' ] ) ? esc_attr( $field[ 'attr' ][ 'class' ] ) : ''; ?>"
	<?php echo dht_parse_option_attributes( $field[ 'attr' ] ?? [] ); ?> <?php echo dht_fw_live_option_selectors( $field[ 'live' ] ?? "" ); ?>>

    <div class="dht-title"><?php echo esc_html( $field[ 'title' ] ); ?></div>

    <div class="dht-field-child-wrapper dht-field-child-upload dht-field-child-upload-item">

        <label
            for="<?php echo esc_attr( $field[ 'id' ] ); ?>"><?php echo esc_html( $field[ 'title' ] ); ?></label>

        <input class="dht-upload-item dht-field"
               type="text"
               id="<?php echo esc_attr( $field[ 'id' ] ); ?>"
               name="<?php echo esc_attr( $field[ 'id' ] ); ?>[item]"
               value="<?php echo !empty( $item_url ) ? esc_url( $item_url ) : ''; ?>" />

        <input class="dht-upload-item-hidden dht-field"
               type="hidden"
               name="<?php echo esc_attr( $field[ 'id' ] ); ?>[item_id]"
               value="<?php echo !empty( $field[ 'value' ][ 'item_id' ] ) ? esc_attr( (int) $field[ 'value' ][ 'item_id' ] ) : ''; ?>" />

        <span class="dht-upload-item-button button"
              data-media-text="<?php echo _x( 'Choose File', 'options', DHT_PREFIX ) ?>"
              data-media-type="<?php echo !empty( $field[ 'file_type' ] ) ? esc_attr( $field[ 'file_type' ] ) : 'video'; ?>">
            <?php echo _x( 'Upload', 'options', DHT_PREFIX ) ?>
        </span>
		
		<?php if( !empty( $field[ 'description' ] ) ): ?>
            <div class="dht-description"><?php echo esc_html( $field[ 'description' ] ); ?></div>
		<?php endif; ?>

    </div>
	
	<?php if( !empty( $field[ 'tooltip' ] ) ): ?>
        <div class="dht-info-help dashicons dashicons-info">
            <div class="dht-tooltips"><p class="OnLeft"><?php echo esc_html( $field[ 'tooltip' ] ); ?></p></div>
        </div>
	<?php endif; ?>

</div>

<?php if( isset( $field[ 'divider' ] ) && $field[ 'divider' ] ): ?>
    <div class="dht-divider"></div>
<?php endif; ?>

<?php do_action( 'dht:options:view:fields:upload_after_area' ); ?>
