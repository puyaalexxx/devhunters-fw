<?php
if( !defined( 'DHT_MAIN' ) ) {
	die( 'Forbidden' );
}

use DHT\Helpers\Classes\OptionsHelpers;
use function DHT\Helpers\dht_parse_option_attributes;

$field = $args[ 'field' ] ?? [];

// Check if 'value' exists and is an array (this also avoids unnecessary checks in the loop)
$values = !empty( $field[ 'value' ] ) && is_array( $field[ 'value' ] ) ? $field[ 'value' ] : [ '' ]; // Default to empty string if no values
?>
<!-- field - multiinput -->

<?php do_action( 'dht:options:view:fields:multiinput_before_area' ); ?>

<div
    class="dht-field-wrapper dht-field-wrapper-multiinput <?php echo isset( $field[ 'attr' ][ 'class' ] ) ? esc_attr( $field[ 'attr' ][ 'class' ] ) : ''; ?>"
	<?php echo dht_parse_option_attributes( $field[ 'attr' ] ?? [] ); ?> <?php echo OptionsHelpers::liveOptionSelectors( $field[ 'live' ] ?? [] ); ?>>
	
	<?php if( !empty( $field[ 'title' ] ) ): ?>
        <div class="dht-title"><?php echo esc_html( $field[ 'title' ] ); ?></div>
	<?php endif; ?>

    <div class="dht-field-child-wrapper dht-field-child-multiinput">

        <label for="<?php echo esc_attr( $field[ 'id' ] ); ?>"><?php echo esc_html( $field[ 'title' ] ); ?></label>
		
		<?php foreach ( $values as $value ): ?>

            <div class="dht-multiinput-child-wrapper">

                <input class="dht-multi-input dht-field"
                       id="<?php echo esc_attr( $field[ 'id' ] ); ?>"
                       type="text"
                       name="<?php echo esc_attr( $field[ 'id' ] ); ?>[]"
                       value="<?php echo esc_html( $value ); ?>" />

                <!--remove input button-->
                <a href="javascript:void(0);" class="dht-multiinput-remove"
                   data-remove-text="<?php echo _x( 'Can\'t remove the only field', 'options', DHT_PREFIX ) ?>">
					<?php echo _x( 'Remove', 'options', DHT_PREFIX ) ?>
                </a>

            </div>
		
		<?php endforeach; ?>

        <!--add button-->
        <a href="javascript:void(0);"
           class="dht-button dht-btn-small dht-multiinput-add"
           data-limit="<?php echo (int) esc_attr( $field[ 'limit' ] ); ?>"
           data-add-text="<?php echo sprintf( _x( 'You can\'t add more than %d inputs ', 'options', DHT_PREFIX ), (int) esc_attr( $field[ 'limit' ] ) ); ?>"
        >
			<?php echo _x( 'Add More', 'options', DHT_PREFIX ) ?>
        </a>
		
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

<?php do_action( 'dht:options:view:fields:multiinput_after_area' ); ?>
