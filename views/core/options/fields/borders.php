<?php
if( !defined( 'DHT_MAIN' ) ) {
	die( 'Forbidden' );
}

use function DHT\Helpers\dht_fw_get_css_units;
use function DHT\Helpers\dht_fw_live_option_selectors;
use function DHT\Helpers\dht_parse_option_attributes;

$field = $args[ 'field' ] ?? [];

$size  = $field[ 'size' ] ?? true;
$style = $field[ 'style' ] ?? true;
$color = $field[ 'color' ] ?? true;

$columns = "";
if( !$size && !$style ) {
	$columns = "dht-field-borders-group-col-4";
}
elseif( $size && $style ) {
	$columns = "dht-field-borders-group-col-6";
}

//border styles
$styles = [
	"none"   => _x( 'None', 'options', DHT_PREFIX ),
	"solid"  => _x( 'Solid', 'options', DHT_PREFIX ),
	"dashed" => _x( 'Dashed', 'options', DHT_PREFIX ),
	"dotted" => _x( 'Dotted', 'options', DHT_PREFIX ),
	"double" => _x( 'Double', 'options', DHT_PREFIX ),
	"groove" => _x( 'Groove', 'options', DHT_PREFIX ),
	"ridge"  => _x( 'Ridge', 'options', DHT_PREFIX ),
	"inset"  => _x( 'Inset', 'options', DHT_PREFIX ),
	"outset" => _x( 'Outset', 'options', DHT_PREFIX ),
];
?>
<!-- field - borders -->

<?php do_action( 'dht:options:view:fields:borders_before_area' ); ?>

<div
    class="dht-field-wrapper dht-field-wrapper-borders <?php echo isset( $field[ 'attr' ][ 'class' ] ) ? esc_attr( $field[ 'attr' ][ 'class' ] ) : ''; ?>"
	<?php echo dht_parse_option_attributes( $field[ 'attr' ] ?? [] ); ?> <?php echo dht_fw_live_option_selectors( $field[ 'live' ] ?? [] ); ?>>
	
	<?php if( !empty( $field[ 'title' ] ) ): ?>
        <div class="dht-title"><?php echo esc_html( $field[ 'title' ] ); ?></div>
	<?php endif; ?>

    <div class="dht-field-child-wrapper dht-field-child-borders">

        <div class="dht-field-borders-group <?php echo esc_attr( $columns ); ?>">

            <div class="dht-field-borders-input">
                <label
                    for="<?php echo esc_attr( $field[ 'id' ] ); ?>-top"><?php echo _x( 'Top', 'options', DHT_PREFIX ) ?></label>

                <span class="dht-borders-top"></span>

                <input class="dht-borders dht-field"
                       id="<?php echo esc_attr( $field[ 'id' ] ); ?>-top"
                       type="number"
                       min="0"
                       name="<?php echo esc_attr( $field[ 'id' ] ); ?>[top]"
                       value="<?php echo esc_attr( $field[ 'value' ][ 'top' ] ); ?>" />
            </div>

            <div class="dht-field-borders-input">
                <label
                    for="<?php echo esc_attr( $field[ 'id' ] ); ?>-right"><?php echo _x( 'Right', 'options', DHT_PREFIX ) ?></label>

                <span class="dht-borders-right"></span>

                <input class="dht-borders dht-field"
                       id="<?php echo esc_attr( $field[ 'id' ] ); ?>-right"
                       type="number"
                       min="0"
                       name="<?php echo esc_attr( $field[ 'id' ] ); ?>[right]"
                       value="<?php echo esc_attr( $field[ 'value' ][ 'right' ] ); ?>" />
            </div>

            <div class="dht-field-borders-input">
                <label
                    for="<?php echo esc_attr( $field[ 'id' ] ); ?>-bottom"><?php echo _x( 'Bottom', 'options', DHT_PREFIX ) ?></label>

                <span class="dht-borders-bottom"></span>

                <input class="dht-borders dht-field"
                       id="<?php echo esc_attr( $field[ 'id' ] ); ?>-bottom"
                       type="number"
                       min="0"
                       name="<?php echo esc_attr( $field[ 'id' ] ); ?>[bottom]"
                       value="<?php echo esc_attr( $field[ 'value' ][ 'bottom' ] ); ?>" />
            </div>

            <div class="dht-field-borders-input">
                <label
                    for="<?php echo esc_attr( $field[ 'id' ] ); ?>-left"><?php echo _x( 'Left', 'options', DHT_PREFIX ) ?></label>

                <span class="dht-borders-left"></span>

                <input class="dht-borders dht-field"
                       id="<?php echo esc_attr( $field[ 'id' ] ); ?>-left"
                       type="number"
                       min="0"
                       name="<?php echo esc_attr( $field[ 'id' ] ); ?>[left]"
                       value="<?php echo esc_attr( $field[ 'value' ][ 'left' ] ); ?>" />
            </div>
			
			<?php if( !empty( $size ) ): ?>
                <div class="dht-field-borders-input">
                    <label
                        for="<?php echo esc_attr( $field[ 'id' ] ); ?>-sizes"><?php echo _x( 'Sizes', 'options', DHT_PREFIX ); ?></label>

                    <select class="dht-borders-dropdown dht-field"
                            name="<?php echo esc_attr( $field[ 'id' ] ); ?>[size]"
                            id="<?php echo esc_attr( $field[ 'id' ] ); ?>-sizes">
						
						<?php foreach ( dht_fw_get_css_units() as $key => $size ): ?>
                            <option
                                value="<?php echo esc_attr( $key ); ?>" <?php echo $field[ 'value' ][ 'size' ] == $key ? 'selected' : ''; ?>><?php echo esc_html( $size ); ?></option>
						<?php endforeach; ?>

                    </select>
                </div>
			<?php endif; ?>
			
			<?php if( !empty( $style ) ): ?>
                <div class="dht-field-borders-input">
                    <label
                        for="<?php echo esc_attr( $field[ 'id' ] ); ?>-style"><?php echo _x( 'Style', 'options', DHT_PREFIX ) ?></label>

                    <select class="dht-borders-dropdown dht-field"
                            name="<?php echo esc_attr( $field[ 'id' ] ); ?>[style]"
                            id="<?php echo esc_attr( $field[ 'id' ] ); ?>-style">
						
						<?php foreach ( $styles as $key => $style ): ?>
                            <option
                                value="<?php echo esc_attr( $key ); ?>" <?php echo $field[ 'value' ][ 'style' ] == $key ? 'selected' : ''; ?>><?php echo esc_html( $style ); ?></option>
						<?php endforeach; ?>

                    </select>
                </div>
			<?php endif; ?>
        </div>
		
		<?php if( !empty( $color ) ): ?>
            <div class="dht-field-borders-group-colorpicker">

                <label for="<?php echo esc_attr( $field[ 'id' ] ); ?>-color"></label>

                <input class="dht-colorpicker dht-field"
                       id="<?php echo esc_attr( $field[ 'id' ] ); ?>-color"
                       type="text"
                       name="<?php echo esc_attr( $field[ 'id' ] ); ?>[color]"
                       value="<?php echo esc_html( $field[ 'value' ][ 'color' ] ); ?>"
                       data-alpha="false" data-alpha-enabled="false"
                       data-palette='<?php echo !empty( $field[ 'palettes' ] ) ? json_encode( $field[ 'palettes' ] ) : ''; ?>' />

                <input type="button" id="<?php echo esc_attr( $field[ 'id' ] ) . '-btn'; ?>"
                       class="dht-default-color-btn button button-small"
                       data-default-value="<?php echo esc_html( $field[ 'value' ][ 'color' ] ); ?>"
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

<?php do_action( 'dht:options:view:fields:borders_after_area' ); ?>
