<?php

use DHT\Helpers\Classes\OptionsHelpers;
use function DHT\Helpers\dht_parse_option_attributes;

if( !defined( 'DHT_MAIN' ) ) {
	die( 'Forbidden' );
}

$field = $args[ 'field' ] ?? [];

$on_off_class = in_array( $field[ 'value' ], $field[ 'left-choice' ] ) ? 'dht-slider-on' : 'dht-slider-off';
$size         = $field[ 'size' ] ?? '';
?>
<!-- field - switch  -->

<?php do_action( 'dht:options:view:fields:switch_before_area' ); ?>

<div
    class="dht-field-wrapper dht-field-wrapper-switch <?php echo isset( $field[ 'attr' ][ 'class' ] ) ? esc_attr( $field[ 'attr' ][ 'class' ] ) : ''; ?>"
	<?php echo dht_parse_option_attributes( $field[ 'attr' ] ?? [] ); ?> <?php echo OptionsHelpers::liveOptionSelectors( $field[ 'live' ] ?? [], $field[ 'value' ] ); ?>>
	
	<?php if( !empty( $field[ 'title' ] ) ): ?>
        <div class="dht-title"><?php echo esc_html( $field[ 'title' ] ); ?></div>
	<?php endif; ?>

    <div class="dht-field-child-wrapper dht-field-child-switch">

        <label
            class="dht-switch <?php echo !empty( $size ) ? 'dht-toggle-btn-' . $size : ''; ?> <?php echo esc_attr( $on_off_class ); ?>"
            for="<?php echo esc_attr( $field[ 'id' ] ); ?>">

            <input type="hidden" name="<?php echo esc_attr( $field[ 'id' ] ); ?>"
                   value="<?php echo esc_attr( $field[ 'value' ] ); ?>" />

            <span class="dht-slider">
                <span class="dht-slider-yes" data-value="<?php echo esc_attr( $field[ 'left-choice' ][ 'value' ] ); ?>">
                    <?php echo esc_attr( $field[ 'left-choice' ][ 'label' ] ); ?>
                </span>
                <span class="dht-slider-no" data-value="<?php echo esc_attr( $field[ 'right-choice' ][ 'value' ] ); ?>">
                    <?php echo esc_attr( $field[ 'right-choice' ][ 'label' ] ); ?>
                </span>
            </span>

        </label>
		
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

<?php do_action( 'dht:options:view:fields:switch_after_area' ); ?>
