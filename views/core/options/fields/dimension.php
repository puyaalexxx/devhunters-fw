<?php
if( !defined( 'DHT_MAIN' ) ) {
	die( 'Forbidden' );
}

use function DHT\Helpers\dht_border_styles;
use DHT\Helpers\Classes\OptionsHelpers;
use function DHT\Helpers\dht_parse_option_attributes;

$field = $args[ 'field' ] ?? [];

$units_values = $field[ 'units-values' ] ?? "";

$size2        = $field[ 'size-2' ] ?? true;
$size3        = $field[ 'size-3' ] ?? true;
$size4        = $field[ 'size-4' ] ?? true;
$units        = $field[ 'units' ] ?? true;
$border_style = $field[ 'border-styles' ] ?? true;
$color        = $field[ 'color' ] ?? true;
$input_icons  = $field[ 'input-icons' ] ?? true;
?>
<!-- field - dimension -->

<?php do_action( 'dht:options:view:fields:dimension_before_area' ); ?>

<div
    class="dht-field-wrapper dht-field-wrapper-dimension <?php echo isset( $field[ 'attr' ][ 'class' ] ) ? esc_attr( $field[ 'attr' ][ 'class' ] ) : ''; ?>"
	<?php echo dht_parse_option_attributes( $field[ 'attr' ] ?? [] ); ?> <?php echo OptionsHelpers::liveOptionSelectors( $field[ 'live' ] ?? [] ); ?>>
	
	<?php if( !empty( $field[ 'title' ] ) ): ?>
        <div class="dht-title"><?php echo esc_html( $field[ 'title' ] ); ?></div>
	<?php endif; ?>

    <div class="dht-field-child-wrapper dht-field-child-dimension">

        <div
            class="dht-field-dimension-group <?php echo $input_icons ? "dht-field-dimension-group-icons" : ""; ?>">

            <div class="dht-field-dimension-input">
                <label
                    for="<?php echo esc_attr( $field[ 'id' ] ); ?>-size-1"><?php echo _x( 'Size 1', 'options', DHT_PREFIX ) ?></label>
				
				<?php if( $input_icons ): ?>
                    <span class="dht-dimension-size-1"></span>
				<?php endif; ?>

                <input class="dht-dimension dht-dimension-input-size-1 dht-field"
                       id="<?php echo esc_attr( $field[ 'id' ] ); ?>-size-1"
                       type="number"
                       min="0"
                       name="<?php echo esc_attr( $field[ 'id' ] ); ?>[size-1]"
                       value="<?php echo isset( $field[ 'value' ][ 'size-1' ] ) ? esc_attr( $field[ 'value' ][ 'size-1' ] ) : 0; ?>" />
            </div>
			
			<?php if( $size2 ): ?>
                <div class="dht-field-dimension-input">
                    <label
                        for="<?php echo esc_attr( $field[ 'id' ] ); ?>-size-2"><?php echo _x( 'Size 2', 'options', DHT_PREFIX ) ?></label>
					
					<?php if( $input_icons ): ?>
                        <span class="dht-dimension-size-2"></span>
					<?php endif; ?>

                    <input class="dht-dimension dht-dimension-input-size-2 dht-field"
                           id="<?php echo esc_attr( $field[ 'id' ] ); ?>-size-2"
                           type="number"
                           min="0"
                           name="<?php echo esc_attr( $field[ 'id' ] ); ?>[size-2]"
                           value="<?php echo isset( $field[ 'value' ][ 'size-2' ] ) ? esc_attr( $field[ 'value' ][ 'size-2' ] ) : 0; ?>" />
                </div>
			<?php endif; ?>
			
			<?php if( $size3 ): ?>
                <div class="dht-field-dimension-input">
                    <label
                        for="<?php echo esc_attr( $field[ 'id' ] ); ?>-size-3"><?php echo _x( 'Size 3', 'options', DHT_PREFIX ) ?></label>
					
					<?php if( $input_icons ): ?>
                        <span class="dht-dimension-size-3"></span>
					<?php endif; ?>

                    <input class="dht-dimension dht-dimension-input-size-3 dht-field"
                           id="<?php echo esc_attr( $field[ 'id' ] ); ?>-size-3"
                           type="number"
                           min="0"
                           name="<?php echo esc_attr( $field[ 'id' ] ); ?>[size-3]"
                           value="<?php echo isset( $field[ 'value' ][ 'size-3' ] ) ? esc_attr( $field[ 'value' ][ 'size-3' ] ) : 0; ?>" />
                </div>
			<?php endif; ?>
			
			<?php if( $size4 ): ?>
                <div class="dht-field-dimension-input">
                    <label
                        for="<?php echo esc_attr( $field[ 'id' ] ); ?>-size-4"><?php echo _x( 'Size 4', 'options', DHT_PREFIX ) ?></label>
					
					<?php if( $input_icons ): ?>
                        <span class="dht-dimension-size-4"></span>
					<?php endif; ?>

                    <input class="dht-dimension dht-dimension-input-size-4 dht-field"
                           id="<?php echo esc_attr( $field[ 'id' ] ); ?>-size-4"
                           type="number"
                           min="0"
                           name="<?php echo esc_attr( $field[ 'id' ] ); ?>[size-4]"
                           value="<?php echo isset( $field[ 'value' ][ 'size-4' ] ) ? esc_attr( $field[ 'value' ][ 'size-4' ] ) : 0; ?>" />
                </div>
			<?php endif; ?>
			
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
						
						<?php foreach ( dht_border_styles() as $key => $border_style ): ?>
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
