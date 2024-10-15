<?php
if ( ! defined( 'DHT_MAIN' ) ) {
	die( 'Forbidden' );
}

use function DHT\Helpers\dht_parse_option_attributes;

$field = $args[ 'field' ] ?? [];
?>
<!-- field - checkbox -->

<?php do_action( 'dht:options:view:fields:radio_before_area' ); ?>

<div
    class="dht-field-wrapper <?php echo isset( $field[ 'attr' ][ 'class' ] ) ? esc_attr( $field[ 'attr' ][ 'class' ] ) : ''; ?>" <?php echo dht_parse_option_attributes( $field[ 'attr' ] ?? [] ); ?>>

    <div class="dht-title"><?php echo esc_html( $field[ 'title' ] ); ?></div>

    <div class="dht-field-child-wrapper dht-field-child-radio">
		
		<?php if ( ! empty( $field[ 'choices' ] ) ): ?>
			
			<?php $cnt = 0;
			foreach ( $field[ 'choices' ] as $value => $label ): ?>
				
				<?php $radio_id = esc_attr( $field[ 'id' ] ) . '-' . $cnt; ?>
                <div class="dht-radio-wrapper">

                    <input
                        class="dht-radio dht-field"
                        type="radio"
                        name="<?php echo esc_attr( $field[ 'id' ] ); ?>"
                        id="<?php echo $field[ 'id' ] . $radio_id; ?>"
                        value="<?php echo esc_attr( $value ); ?>"
						<?php echo ( $field[ 'value' ] == $value ) ? 'checked="checked"' : ''; ?>/>

                    <label for="<?php echo $field[ 'id' ] . $radio_id; ?>"><?php echo esc_html( $label ); ?></label>

                </div>
				<?php $cnt ++; endforeach; ?>
		
		<?php endif; ?>
		
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

<?php do_action( 'dht:options:view:fields:radio_after_area' ); ?>
