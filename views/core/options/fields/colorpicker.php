<?php
if( !defined( 'DHT_MAIN' ) ) {
	die( 'Forbidden' );
}

use DHT\Helpers\Classes\OptionsHelpers;
use function DHT\Helpers\dht_parse_option_attributes;

$field = $args[ 'field' ] ?? [];
?>
<!-- field - colorpicker -->

<?php do_action( 'dht:options:view:fields:colorpicker_before_area' ); ?>

<div
    class="dht-field-wrapper dht-field-wrapper-colorpicker <?php echo isset( $field[ 'attr' ][ 'class' ] ) ? esc_attr( $field[ 'attr' ][ 'class' ] ) : ''; ?>"
	<?php echo dht_parse_option_attributes( $field[ 'attr' ] ?? [] ); ?> <?php echo OptionsHelpers::liveOptionSelectors( $field[ 'live' ] ?? [], $field[ 'value' ] ); ?>>
	
	<?php if( !empty( $field[ 'title' ] ) ): ?>
        <div class="dht-title"><?php echo esc_html( $field[ 'title' ] ); ?></div>
	<?php endif; ?>

    <div class="dht-field-child-wrapper dht-field-child-colorpicker">

        <label for="<?php echo esc_attr( $field[ 'id' ] ); ?>"><?php echo esc_html( $field[ 'title' ] ); ?></label>

        <input
            class="dht-colorpicker dht-field"
            id="<?php echo esc_attr( $field[ 'id' ] ); ?>"
            type="text"
			<?php echo ( $field[ 'subtype' ] == 'rgba' ) ? 'data-alpha="true" data-alpha-enabled="true"' : 'data-alpha="false" data-alpha-enabled="false"'; ?>
            name="<?php echo esc_attr( $field[ 'id' ] ); ?>"
            value="<?php echo esc_html( $field[ 'value' ] ); ?>"
            data-palette='<?php echo !empty( $field[ 'palettes' ] ) ? json_encode( $field[ 'palettes' ] ) : ''; ?>' />

        <input type="button" id="<?php echo esc_attr( $field[ 'id' ] ) . '-btn'; ?>"
               class="dht-default-color-btn button button-small"
               data-default-value="<?php echo esc_html( $field[ 'value' ] ); ?>"
               value="<?php echo _x( 'Default', 'options', DHT_PREFIX ) ?>">
		
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

<?php do_action( 'dht:options:view:fields:colorpicker_after_area' ); ?>
