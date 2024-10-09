<?php
if ( ! defined( 'DHT_MAIN' ) ) {
	die( 'Forbidden' );
}

use function DHT\Helpers\dht_parse_option_attributes;

if ( ! defined( 'DHT_MAIN' ) ) {
	die( 'Forbidden' );
}

$field = $args[ 'field' ] ?? [];
?>
    <!-- field - checkbox -->

<?php do_action( 'dht_options_view_fields_checkbox_before_area' ); ?>

    <div
        class="dht-field-wrapper <?php echo isset( $field[ 'attr' ][ 'class' ] ) ? esc_attr( $field[ 'attr' ][ 'class' ] ) : ''; ?>" <?php echo dht_parse_option_attributes( $field[ 'attr' ] ?? [] ); ?>>

        <div class="dht-title"><?php echo esc_html( $field[ 'title' ] ); ?></div>

        <div class="dht-field-child-wrapper dht-field-child-checkbox">
			
			<?php if ( ! empty( $field[ 'choices' ] ) ): ?>
				
				<?php foreach ( $field[ 'choices' ] as $key => $checkbox ): ?>

                    <div class="dht-checkbox-wrapper">

                        <input
                            class="dht-checkbox dht-field"
                            type="checkbox"
                            name="<?php echo esc_attr( $field[ 'id' ] ); ?>[<?php echo esc_attr( $checkbox[ 'id' ] ); ?>]"
                            id="<?php echo esc_attr( $field[ 'id' ] . $checkbox[ 'id' ] ); ?>"
                            value="<?php echo esc_attr( esc_attr( $checkbox[ 'value' ] ) ); ?>"
							<?php echo in_array( $checkbox[ 'id' ], $field[ 'value' ] ) ? 'checked="checked"' : ''; ?>/>

                        <label
                            for="<?php echo esc_attr( $field[ 'id' ] . $checkbox[ 'id' ] ); ?>"><?php echo esc_html( $checkbox[ 'label' ] ); ?></label>

                    </div>
				<?php endforeach; ?>
			
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

<?php do_action( 'dht_options_view_fields_checkbox_after_area' ); ?>