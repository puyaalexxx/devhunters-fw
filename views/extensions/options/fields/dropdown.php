<?php
if ( ! defined( 'DHT_MAIN' ) ) {
	die( 'Forbidden' );
}

use function DHT\Helpers\dht_parse_option_attributes;

$field = $args[ 'field' ] ?? [];
?>
<!-- field - dropdown -->

<?php do_action( 'dht_options_view_fields_dropdown_before_area' ); ?>

<div
    class="dht-field-wrapper <?php echo isset( $field[ 'attr' ][ 'class' ] ) ? esc_attr( $field[ 'attr' ][ 'class' ] ) : ''; ?>" <?php echo dht_parse_option_attributes( $field[ 'attr' ] ?? [] ); ?>>

    <div class="dht-title"><?php echo esc_html( $field[ 'title' ] ); ?></div>

    <div class="dht-field-child-wrapper dht-field-child-dropdown">
		
		<?php if ( ! empty( $field[ 'choices' ] ) ): ?>

            <label for="<?php echo esc_attr( $field[ 'id' ] ); ?>"><?php echo esc_attr( $field[ 'title' ] ); ?></label>

            <select class="dht-dropdown dht-field" name="<?php echo esc_attr( $field[ 'id' ] ); ?>"
                    id="<?php echo esc_attr( $field[ 'id' ] ); ?>">
				
				<?php foreach ( $field[ 'choices' ] as $key => $val ): ?>

                    <!--optgroup-->
					<?php if ( is_array( $val ) ): ?>
						
						<?php foreach ( $val as $group ): ?>

                            <optgroup label="<?php echo esc_attr( $group[ 'label' ] ); ?>">
								
								<?php foreach ( $group[ 'choices' ] as $group_value => $group_label ): ?>

                                    <option
                                        value="<?php echo esc_attr( $group_value ); ?>" <?php echo ( $field[ 'value' ] == $group_value ) ? 'selected' : ''; ?>>
										<?php echo esc_html( $group_label ); ?>
                                    </option>
								
								<?php endforeach; ?>

                            </optgroup>
						
						<?php endforeach; ?>

                        <!--simple option-->
					<?php else: ?>

                        <option
                            value="<?php echo esc_attr( $key ); ?>" <?php echo ( $field[ 'value' ] == $key ) ? 'selected' : ''; ?>>
							<?php echo esc_html( $val ); ?>
                        </option>
					
					<?php endif; ?>
				
				<?php endforeach; ?>

            </select>
		
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

<?php do_action( 'dht_options_view_fields_dropdown_after_area' ); ?>
