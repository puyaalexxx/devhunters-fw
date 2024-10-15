<?php
if ( ! defined( 'DHT_MAIN' ) ) {
	die( 'Forbidden' );
}

use function DHT\Helpers\dht_parse_option_attributes;

$field = $args[ 'field' ] ?? [];

//border styles
$styles = [
	"solid"  => 'Solid',
	"dashed" => 'Dashed',
	"dotted" => 'Dotted',
	"double" => 'Double',
	"none"   => 'None'
];
?>
<!-- field - borders -->

<?php do_action( 'dht:options:view:fields:borders_before_area' ); ?>

<div
    class="dht-field-wrapper <?php echo isset( $field[ 'attr' ][ 'class' ] ) ? esc_attr( $field[ 'attr' ][ 'class' ] ) : ''; ?>" <?php echo dht_parse_option_attributes( $field[ 'attr' ] ?? [] ); ?>>

    <div class="dht-title"><?php echo esc_html( $field[ 'title' ] ); ?></div>

    <div class="dht-field-child-wrapper dht-field-child-borders">

        <div class="dht-field-borders-group">

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
        </div>

        <div class="dht-field-borders-group-colorpicker">

            <label for="<?php echo esc_attr( $field[ 'id' ] ); ?>-color"></label>

            <input class="dht-colorpicker dht-field"
                   id="<?php echo esc_attr( $field[ 'id' ] ); ?>-color"
                   type="text"
                   name="<?php echo esc_attr( $field[ 'id' ] ); ?>[color]"
                   value="<?php echo esc_html( $field[ 'value' ][ 'color' ] ); ?>"
                   data-alpha="false" data-alpha-enabled="false"
                   data-palette='<?php echo ! empty( $field[ 'palettes' ] ) ? json_encode( $field[ 'palettes' ] ) : ''; ?>' />

            <input type="button" id="<?php echo esc_attr( $field[ 'id' ] ) . '-btn'; ?>"
                   class="dht-default-color-btn button button-small"
                   data-default-value="<?php echo esc_html( $field[ 'value' ][ 'color' ] ); ?>"
                   value="<?php echo _x( 'Default', 'options', DHT_PREFIX ) ?>">

        </div>
		
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

<?php do_action( 'dht:options:view:fields:borders_after_area' ); ?>
