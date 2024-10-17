<?php
if( !defined( 'DHT_MAIN' ) ) {
	die( 'Forbidden' );
}

use function DHT\Helpers\dht_parse_option_attributes;

$field = $args[ 'field' ] ?? [];
?>
<!--upload gallery field-->

<?php do_action( 'dht:options:view:fields:upload_gallery_before_area' ); ?>

<div
    class="dht-field-wrapper <?php echo isset( $field[ 'attr' ][ 'class' ] ) ? esc_attr( $field[ 'attr' ][ 'class' ] ) : ''; ?>" <?php echo dht_parse_option_attributes( $field[ 'attr' ] ?? [] ); ?>>

    <div class="dht-title"><?php echo esc_html( $field[ 'title' ] ); ?></div>

    <div class="dht-field-child-wrapper dht-field-child-upload dht-field-child-upload-gallery">

        <div class="dht-gallery-group">
			
			<?php if( !empty( $field[ 'value' ] ) ): ?>
				
				<?php foreach ( $field[ 'value' ] as $attachment_id ): ?>
					
					<?php $attachemnt_url = wp_get_attachment_url( $attachment_id ); ?>

                    <div class="dht-img-remove">
                        <span class="dht-img-remove-icon"></span>
                        <img data-id="<?php echo (int) $attachment_id; ?>"
                             src="<?php echo esc_url( $attachemnt_url ); ?>"
                             alt="" width="100"
                             height="100" />
                    </div>
				
				<?php endforeach; ?>
			
			<?php endif; ?>

        </div>

        <input class="dht-upload-gallery-hidden dht-field"
               type="hidden"
               id="<?php echo esc_attr( $field[ 'id' ] ); ?>"
               name="<?php echo esc_attr( $field[ 'id' ] ); ?>"
               value="<?php echo !empty( $field[ 'value' ] ) ? implode( ',', $field[ 'value' ] ) : ''; ?>" />

        <span class="dht-upload-gallery-button button"
              data-media-text="<?php echo _x( 'Choose Images', 'options', DHT_PREFIX ) ?>">
            <?php echo _x( 'Upload Gallery', 'options', DHT_PREFIX ) ?>
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

<?php do_action( 'dht:options:view:fields:upload_gallery_after_area' ); ?>
