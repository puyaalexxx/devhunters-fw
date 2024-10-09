<?php

use function DHT\Helpers\dht_parse_option_attributes;

if ( ! defined( 'DHT_MAIN' ) ) {
	die( 'Forbidden' );
}

$field = $args[ 'field' ] ?? [];
?>
<!-- field - input -->

<?php do_action( 'dht_options_view_fields_input_before_area' ); ?>

<div
    class="dht-field-wrapper <?php echo isset( $field[ 'attr' ][ 'class' ] ) ? esc_attr( $field[ 'attr' ][ 'class' ] ) : ''; ?>" <?php echo dht_parse_option_attributes( $field[ 'attr' ] ?? [] ); ?>>

    <div class="dht-title"><?php echo esc_html( $field[ 'title' ] ); ?></div>

    <div class="dht-field-child-wrapper dht-field-child-input">

        <label for="<?php echo esc_attr( $field[ 'id' ] ); ?>"><?php echo esc_html( $field[ 'title' ] ); ?></label>

        <input
            class="dht-input dht-field"
            id="<?php echo esc_attr( $field[ 'id' ] ); ?>"
            type="<?php echo ! empty( $field[ 'subtype' ] ) ? esc_attr( $field[ 'subtype' ] ) : esc_attr( $field[ 'type' ] ); ?>"
            name="<?php echo esc_attr( $field[ 'id' ] ); ?>"
            value="<?php echo esc_html( $field[ 'value' ] ); ?>" />
		
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

<?php do_action( 'dht_options_view_fields_input_after_area' ); ?>
