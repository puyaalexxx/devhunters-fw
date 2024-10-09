<?php
if ( ! defined( 'DHT_MAIN' ) ) {
	die( 'Forbidden' );
}

use function DHT\Helpers\dht_parse_option_attributes;

$field = $args[ 'field' ] ?? [];
?>
<!-- field - multiinput -->

<?php do_action( 'dht_options_view_fields_multiinput_before_area' ); ?>

<div
    class="dht-field-wrapper <?php echo isset( $field[ 'attr' ][ 'class' ] ) ? esc_attr( $field[ 'attr' ][ 'class' ] ) : ''; ?>" <?php echo dht_parse_option_attributes( $field[ 'attr' ] ?? [] ); ?>>

    <div class="dht-title"><?php echo esc_html( $field[ 'title' ] ); ?></div>

    <div class="dht-field-child-wrapper dht-field-child-multiinput">

        <label for="<?php echo esc_attr( $field[ 'id' ] ); ?>"><?php echo esc_html( $field[ 'title' ] ); ?></label>
		
		<?php foreach ( $field[ 'value' ] as $value ): ?>

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

<?php do_action( 'dht_options_view_fields_multiinput_after_area' ); ?>
