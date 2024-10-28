<?php
if( !defined( 'DHT_MAIN' ) ) {
	die( 'Forbidden' );
}

use function DHT\Helpers\dht_fw_live_option_selectors;
use function DHT\Helpers\dht_parse_option_attributes;

$field = $args[ 'field' ] ?? [];
?>
<!-- field - datepicker -->

<?php do_action( 'dht:options:view:fields:datepicker_before_area' ); ?>

<div
    class="dht-field-wrapper dht-field-wrapper-datepicker <?php echo isset( $field[ 'attr' ][ 'class' ] ) ? esc_attr( $field[ 'attr' ][ 'class' ] ) : ''; ?>"
	<?php echo dht_parse_option_attributes( $field[ 'attr' ] ?? [] ); ?> <?php echo dht_fw_live_option_selectors( $field[ 'live' ] ?? "" ); ?>>
	
	<?php if( !empty( $field[ 'title' ] ) ): ?>
        <div class="dht-title"><?php echo esc_html( $field[ 'title' ] ); ?></div>
	<?php endif; ?>

    <div class="dht-field-child-wrapper dht-field-child-datepicker">

        <label for="<?php echo esc_attr( $field[ 'id' ] ); ?>"><?php echo esc_html( $field[ 'title' ] ); ?></label>

        <input class="dht-datepicker dht-field"
               id="<?php echo esc_attr( $field[ 'id' ] ); ?>"
               type="text"
               name="<?php echo esc_attr( $field[ 'id' ] ); ?>"
               value="<?php echo esc_html( $field[ 'value' ] ); ?>"
               data-format="<?php echo esc_attr( $field[ 'format' ] ); ?>" />
		
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

<?php do_action( 'dht:options:view:fields:datepicker_after_area' ); ?>
