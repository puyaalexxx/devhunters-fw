<?php
if( !defined( 'DHT_MAIN' ) ) {
	die( 'Forbidden' );
}

use function DHT\Helpers\dht_parse_option_attributes;

$field = $args[ 'field' ] ?? [];

$image_url = '';
if( !empty( $field[ 'value' ][ 'image_id' ] ) ) {
	
	$attachemnt_url = wp_get_attachment_url( (int) $field[ 'value' ][ 'image_id' ] );
	$image_url      = $attachemnt_url;
	
}
elseif( !empty( $field[ 'value' ][ 'image' ] ) ) {
	
	$image_url = esc_url( $field[ 'value' ][ 'image' ] );
}
?>
<!--upload image field-->

<?php do_action( 'dht:options:view:fields:upload_image_before_area' ); ?>

<div
    class="dht-field-wrapper <?php echo isset( $field[ 'attr' ][ 'class' ] ) ? esc_attr( $field[ 'attr' ][ 'class' ] ) : ''; ?>" <?php echo dht_parse_option_attributes( $field[ 'attr' ] ?? [] ); ?>>

    <div class="dht-title"><?php echo esc_html( $field[ 'title' ] ); ?></div>

    <div class="dht-field-child-wrapper dht-field-child-upload dht-field-child-upload-image">

        <label
            for="<?php echo esc_attr( $field[ 'id' ] ); ?>"><?php echo esc_html( $field[ 'title' ] ); ?></label>

        <!--show image preview if image link not empty -->
		<?php if( !empty( $image_url ) ): ?>

            <img src="<?php echo esc_url( $image_url ); ?>" alt="" width="100" height="100">
		
		<?php endif; ?>

        <input class="dht-upload dht-field"
               type="text"
               id="<?php echo esc_attr( $field[ 'id' ] ); ?>"
               name="<?php echo esc_attr( $field[ 'id' ] ); ?>[image]"
               value="<?php echo !empty( $image_url ) ? esc_url( $image_url ) : ''; ?>" />

        <input class="dht-upload-hidden dht-field"
               type="hidden"
               name="<?php echo esc_attr( $field[ 'id' ] ); ?>[image_id]"
               value="<?php echo !empty( $field[ 'value' ][ 'image_id' ] ) ? esc_attr( (int) $field[ 'value' ][ 'image_id' ] ) : ''; ?>" />

        <span class="dht-upload-image-button button"
              data-media-text="<?php echo _x( 'Choose Image', 'options', DHT_PREFIX ) ?>"><?php echo _x( 'Upload Image', 'options', DHT_PREFIX ) ?></span>
		
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

<?php do_action( 'dht:options:view:fields:upload_image_after_area' ); ?>
