<?php
if( !defined( 'DHT_MAIN' ) ) {
	die( 'Forbidden' );
}

use function DHT\Helpers\dht_fw_border_styles;
use function DHT\Helpers\dht_fw_live_option_selectors;
use function DHT\Helpers\dht_parse_option_attributes;

$field = $args[ 'field' ] ?? [];

$units_values = $field[ 'units-values' ] ?? "";
$units        = $field[ 'units' ] ?? true;
$border_style = $field[ 'border-styles' ] ?? true;
$color        = $field[ 'color' ] ?? true;

$columns = "";
if( !$units && !$border_style ) {
	$columns = "dht-field-dimension-group-col-4";
}
elseif( $units && $border_style ) {
	$columns = "dht-field-dimension-group-col-6";
}
?>
<!-- field - dimension -->

<?php do_action( 'dht:options:view:fields:dimension_before_area' ); ?>

<div
    class="dht-field-wrapper dht-field-wrapper-dimension <?php echo isset( $field[ 'attr' ][ 'class' ] ) ? esc_attr( $field[ 'attr' ][ 'class' ] ) : ''; ?>"
	<?php echo dht_parse_option_attributes( $field[ 'attr' ] ?? [] ); ?> <?php echo dht_fw_live_option_selectors( $field[ 'live' ] ?? [] ); ?>>
	
	<?php if( !empty( $field[ 'title' ] ) ): ?>
        <div class="dht-title"><?php echo esc_html( $field[ 'title' ] ); ?></div>
	<?php endif; ?>

    <div class="dht-field-child-wrapper dht-field-child-dimension">

        <div class="dht-field-dimension-group <?php echo esc_attr( $columns ); ?>">

            <div class="dht-field-dimension-input">
                <label
                    for="<?php echo esc_attr( $field[ 'id' ] ); ?>-top"><?php echo _x( 'Top', 'options', DHT_PREFIX ) ?></label>

                <span class="dht-dimension-top"></span>

                <input class="dht-dimension dht-dimension-input-top dht-field"
                       id="<?php echo esc_attr( $field[ 'id' ] ); ?>-top"
                       type="number"
                       min="0"
                       name="<?php echo esc_attr( $field[ 'id' ] ); ?>[top]"
                       value="<?php echo esc_attr( $field[ 'value' ][ 'top' ] ); ?>" />
            </div>

            <div class="dht-field-dimension-input">
                <label
                    for="<?php echo esc_attr( $field[ 'id' ] ); ?>-right"><?php echo _x( 'Right', 'options', DHT_PREFIX ) ?></label>

                <span class="dht-dimension-right"></span>

                <input class="dht-dimension dht-dimension-input-right dht-field"
                       id="<?php echo esc_attr( $field[ 'id' ] ); ?>-right"
                       type="number"
                       min="0"
                       name="<?php echo esc_attr( $field[ 'id' ] ); ?>[right]"
                       value="<?php echo esc_attr( $field[ 'value' ][ 'right' ] ); ?>" />
            </div>

            <div class="dht-field-dimension-input">
                <label
                    for="<?php echo esc_attr( $field[ 'id' ] ); ?>-bottom"><?php echo _x( 'Bottom', 'options', DHT_PREFIX ) ?></label>

                <span class="dht-dimension-bottom"></span>

                <input class="dht-dimension dht-dimension-input-bottom dht-field"
                       id="<?php echo esc_attr( $field[ 'id' ] ); ?>-bottom"
                       type="number"
                       min="0"
                       name="<?php echo esc_attr( $field[ 'id' ] ); ?>[bottom]"
                       value="<?php echo esc_attr( $field[ 'value' ][ 'bottom' ] ); ?>" />
            </div>

            <div class="dht-field-dimension-input">
                <label
                    for="<?php echo esc_attr( $field[ 'id' ] ); ?>-left"><?php echo _x( 'Left', 'options', DHT_PREFIX ) ?></label>

                <span class="dht-dimension-left"></span>

                <input class="dht-dimension dht-dimension-input-left dht-field"
                       id="<?php echo esc_attr( $field[ 'id' ] ); ?>-left"
                       type="number"
                       min="0"
                       name="<?php echo esc_attr( $field[ 'id' ] ); ?>[left]"
                       value="<?php echo esc_attr( $field[ 'value' ][ 'left' ] ); ?>" />
            </div>
			
			<?php if( $units && !empty( $units_values ) ): ?>
				<?php $units_value = $field[ 'value' ][ 'unit' ] ?? ""; ?>
                <div class="dht-field-dimension-input">
                    <label
                        for="<?php echo esc_attr( $field[ 'id' ] ); ?>-units"><?php echo _x( 'Units', 'options', DHT_PREFIX ); ?></label>

                    <select class="dht-dimension-dropdown dht-dimension-unit dht-field"
                            name="<?php echo esc_attr( $field[ 'id' ] ); ?>[unit]"
                            id="<?php echo esc_attr( $field[ 'id' ] ); ?>-units">
						
						<?php foreach ( apply_filters( 'dht:options:dimension:units_dropdown_values', $units_values ) as $key => $units ): ?>
                            <option
                                value="<?php echo esc_attr( $key ); ?>" <?php echo $units_value == $key ? 'selected' : ''; ?>><?php echo esc_html( $units ); ?></option>
						<?php endforeach; ?>

                    </select>
                </div>
			<?php endif; ?>
			
			<?php if( $border_style ): ?>
				<?php $border_style_value = $field[ 'value' ][ 'border-style' ] ?? ""; ?>
                <div class="dht-field-dimension-input">
                    <label
                        for="<?php echo esc_attr( $field[ 'id' ] ); ?>-border-style"><?php echo _x( 'Border Style', 'options', DHT_PREFIX ) ?></label>

                    <select class="dht-dimension-dropdown dht-dimension-border-style dht-field"
                            name="<?php echo esc_attr( $field[ 'id' ] ); ?>[border-style]"
                            id="<?php echo esc_attr( $field[ 'id' ] ); ?>-border-style">
						
						<?php foreach ( dht_fw_border_styles() as $key => $border_style ): ?>
                            <option
                                value="<?php echo esc_attr( $key ); ?>" <?php echo $border_style_value == $key ? 'selected' : ''; ?>><?php echo esc_html( $border_style ); ?></option>
						<?php endforeach; ?>

                    </select>
                </div>
			<?php endif; ?>
        </div>
		
		<?php if( $color ): ?>
			<?php $color_value = $field[ 'value' ][ 'color' ] ?? "#ffffff"; ?>
            <div class="dht-field-dimension-group-colorpicker dht-dimension-colorpicker">
                <label for="<?php echo esc_attr( $field[ 'id' ] ); ?>-color"></label>

                <input class="dht-colorpicker dht-field"
                       id="<?php echo esc_attr( $field[ 'id' ] ); ?>-color"
                       type="text"
                       name="<?php echo esc_attr( $field[ 'id' ] ); ?>[color]"
                       value="<?php echo esc_html( $color_value ); ?>"
                       data-alpha="false" data-alpha-enabled="false"
                       data-palette='<?php echo !empty( $field[ 'palettes' ] ) ? json_encode( $field[ 'palettes' ] ) : ''; ?>' />

                <input type="button" id="<?php echo esc_attr( $field[ 'id' ] ) . '-btn'; ?>"
                       class="dht-default-color-btn button button-small"
                       data-default-value="<?php echo esc_html( $color_value ); ?>"
                       value="<?php echo _x( 'Default', 'options', DHT_PREFIX ) ?>">

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

<?php do_action( 'dht:options:view:fields:dimension_after_area' ); ?>
