<?php
if( !defined( 'DHT_MAIN' ) ) {
	die( 'Forbidden' );
}

use DHT\Helpers\Classes\OptionsHelpers;
use function DHT\Helpers\dht_parse_option_attributes;

$field = $args[ 'field' ] ?? [];

$min = isset( $field[ 'min' ] ) ? (int) $field[ 'min' ] : 0;
$max = isset( $field[ 'max' ] ) ? (int) $field[ 'max' ] : 0;

$values = implode( ",", $field[ 'value' ] );
?>
<!-- field - rangeslider -->

<?php do_action( 'dht:options:view:fields:range_slider_before_area' ); ?>

<div
    class="dht-field-wrapper dht-field-wrapper-rangeslider <?php echo isset( $field[ 'attr' ][ 'class' ] ) ? esc_attr( $field[ 'attr' ][ 'class' ] ) : ''; ?>"
	<?php echo dht_parse_option_attributes( $field[ 'attr' ] ?? [] ); ?> <?php echo OptionsHelpers::liveOptionSelectors( $field[ 'live' ] ?? [], $values ); ?>>
	
	<?php if( !empty( $field[ 'title' ] ) ): ?>
        <div class="dht-title"><?php echo esc_html( $field[ 'title' ] ); ?></div>
	<?php endif; ?>

    <div class="dht-field-child-wrapper dht-field-child-rangeslider">
		
		<?php if( isset( $field[ 'range' ] ) && $field[ 'range' ] ): ?>

            <div class="dht-slider-group">

                <label
                    for="<?php echo esc_attr( $field[ 'id' ] ); ?>-1"><?php echo esc_html( $field[ 'title' ] ); ?></label>
                <input class="dht-range-slider dht-range-slider-1 dht-field"
                       id="<?php echo esc_attr( $field[ 'id' ] ); ?>-1"
                       type="number"
                       min="<?php echo esc_attr( $min ); ?>"
                       max="<?php echo esc_attr( $max ); ?>"
                       name="<?php echo esc_attr( $field[ 'id' ] ); ?>[]"
                       readonly
                       value="<?php echo !empty( $field[ 'value' ] ) ? $field[ 'value' ][ 0 ] : 0; ?>" />
                -
                <label
                    for="<?php echo esc_attr( $field[ 'id' ] ); ?>-2"><?php echo esc_html( $field[ 'title' ] ); ?></label>
                <input class="dht-range-slider dht-range-slider-2 dht-field"
                       id="<?php echo esc_attr( $field[ 'id' ] ); ?>-2"
                       type="number"
                       min="<?php echo esc_attr( $min ); ?>"
                       max="<?php echo esc_attr( $max ); ?>"
                       name="<?php echo esc_attr( $field[ 'id' ] ); ?>[]"
                       readonly
                       value="<?php echo !empty( $field[ 'value' ] ) ? $field[ 'value' ][ 1 ] : 0; ?>" />

            </div>

            <!--range slider -->
            <div class="dht-slider-slider"
                 data-range="yes"
                 data-values="<?php echo $values; ?>"
                 data-min="<?php echo esc_attr( $min ); ?>"
                 data-max="<?php echo esc_attr( $max ); ?>"
            >
            </div>
		
		<?php else: ?>
			
			<?php $value = !empty( $field[ 'value' ] ) ? $field[ 'value' ][ 0 ] : 0; ?>

            <label for="<?php echo esc_attr( $field[ 'id' ] ); ?>"><?php echo esc_html( $field[ 'title' ] ); ?></label>
            <input class="dht-slider dht-field"
                   id="<?php echo esc_attr( $field[ 'id' ] ); ?>"
                   type="number"
                   min="<?php echo esc_attr( $min ); ?>"
                   max="<?php echo esc_attr( $max ); ?>"
                   name="<?php echo esc_attr( $field[ 'id' ] ); ?>"
                   readonly
                   value="<?php echo $value; ?>" />

            <!--range slider -->
            <div class="dht-slider-slider"
                 data-range="no"
                 data-values="<?php echo $value; ?>"
                 data-min="<?php echo esc_attr( $min ); ?>"
                 data-max="<?php echo esc_attr( $max ); ?>"
            >
            </div>
		
		<?php endif; ?>
		
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

<?php do_action( 'dht:options:view:fields:range_slider_after_area' ); ?>
