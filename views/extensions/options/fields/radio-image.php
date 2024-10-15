<?php
if ( ! defined( 'DHT_MAIN' ) ) {
	die( 'Forbidden' );
}

use function DHT\Helpers\dht_parse_option_attributes;

$field = $args[ 'field' ] ?? [];
?>
<!-- field - radio image -->

<?php do_action( 'dht:options:view:fields:radio_image_before_area' ); ?>

<div
    class="dht-field-wrapper <?php echo isset( $field[ 'attr' ][ 'class' ] ) ? esc_attr( $field[ 'attr' ][ 'class' ] ) : ''; ?>" <?php echo dht_parse_option_attributes( $field[ 'attr' ] ?? [] ); ?>>

    <div class="dht-title"><?php echo esc_html( $field[ 'title' ] ); ?></div>

    <div class="dht-field-child-wrapper dht-field-child-image-select">

        <div class="dht-field-child-image-select-container">
			
			<?php if ( ! empty( $field[ 'choices' ] ) ): ?>
				
				<?php $cnt = 0;
				foreach ( $field[ 'choices' ] as $value => $radio ): ?>
					
					<?php $radio_id = esc_attr( $field[ 'id' ] ) . '-' . $cnt; ?>

                    <div
                        class="dht-img-select-wrapper <?php echo ( $field[ 'value' ] == $value ) ? 'dht-img-select-wrapper-selected' : ''; ?>">
                        <input class="dht-image-select dht-field"
                               type="radio"
                               name="<?php echo esc_attr( $radio_id ); ?>[img]"
                               id="<?php echo esc_attr( $radio_id ); ?>"
                               value="<?php echo esc_attr( $value ); ?>"
							<?php echo ( $field[ 'value' ] == $value ) ? 'checked' : ''; ?>/>
                        <img
                            src="<?php echo ! empty( $radio[ 'image' ] ) ? esc_url( $radio[ 'image' ] ) : DHT_ASSETS_URI . "images/demo.png"; ?>"
                            alt="<?php echo esc_attr( $radio[ 'label' ] ); ?>"
                            title="<?php echo esc_attr( $radio[ 'label' ] ); ?>" />
                        <label
                            for="<?php echo esc_attr( $radio_id ); ?>"><?php echo esc_html( $radio[ 'label' ] ); ?></label>

                    </div>
					
					<?php $cnt ++; endforeach; ?>
			
			<?php endif; ?>

        </div>
		
		<?php if ( ! empty( $field[ 'description' ] ) ): ?>
            <div class="dht-description"><?php echo esc_html( $field[ 'description' ] ); ?></div>
		<?php endif; ?>

    </div>
	
	<?php if ( ! empty( $field[ 'tooltip' ] ) ): ?>
        <div class="dht-info-help dashicons dashicons-info"
             data-tooltips="<?php echo esc_html( $field[ 'tooltip' ] ); ?>"
             data-position="OnLeft">
        </div>
	<?php endif; ?>

</div>

<?php if ( isset( $field[ 'divider' ] ) && $field[ 'divider' ] ): ?>
    <div class="dht-divider"></div>
<?php endif; ?>

<?php do_action( 'dht:options:view:fields:radio_image_after_area' ); ?>
