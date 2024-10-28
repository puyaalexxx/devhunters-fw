<?php
if( !defined( 'DHT_MAIN' ) ) {
	die( 'Forbidden' );
}

use function DHT\Helpers\dht_fw_live_option_selectors;
use function DHT\Helpers\dht_parse_option_attributes;

$field = $args[ 'field' ] ?? [];

//spacing sizes
$sizes = [
	"px"         => 'px',
	"percentage" => '%',
	"em"         => 'em',
	"rem"        => 'rem',
	"vw"         => 'vw',
	"vh"         => 'vh'
];
?>
<!-- field - spacing -->

<?php do_action( 'dht:options:view:fields:spacing_before_area' ); ?>

<div
    class="dht-field-wrapper dht-field-wrapper-spacing <?php echo isset( $field[ 'attr' ][ 'class' ] ) ? esc_attr( $field[ 'attr' ][ 'class' ] ) : ''; ?>"
	<?php echo dht_parse_option_attributes( $field[ 'attr' ] ?? [] ); ?> <?php echo dht_fw_live_option_selectors( $field[ 'live' ] ?? "" ); ?>>
	
	<?php if( !empty( $field[ 'title' ] ) ): ?>
        <div class="dht-title"><?php echo esc_html( $field[ 'title' ] ); ?></div>
	<?php endif; ?>

    <div class="dht-field-child-wrapper dht-field-child-spacing">

        <div class="dht-field-spacing-group">

            <div class="dht-field-spacing-input">

                <label
                    for="<?php echo esc_attr( $field[ 'id' ] ); ?>-top"><?php echo _x( 'Top', 'options', DHT_PREFIX ); ?></label>

                <span class="dht-spacing-top"></span>

                <input class="dht-spacing dht-field"
                       id="<?php echo esc_attr( $field[ 'id' ] ); ?>-top"
                       type="number"
                       name="<?php echo esc_attr( $field[ 'id' ] ); ?>[top]"
                       value="<?php echo esc_attr( $field[ 'value' ][ 'top' ] ); ?>" />

            </div>

            <div class="dht-field-spacing-input">

                <label
                    for="<?php echo esc_attr( $field[ 'id' ] ); ?>-right"><?php echo _x( 'Right', 'options', DHT_PREFIX ); ?></label>

                <span class="dht-spacing-right"></span>

                <input class="dht-spacing dht-field"
                       id="<?php echo esc_attr( $field[ 'id' ] ); ?>-right"
                       type="number"
                       name="<?php echo esc_attr( $field[ 'id' ] ); ?>[right]"
                       value="<?php echo esc_attr( $field[ 'value' ][ 'right' ] ); ?>" />

            </div>

            <div class="dht-field-spacing-input">

                <label
                    for="<?php echo esc_attr( $field[ 'id' ] ); ?>-bottom"><?php echo _x( 'Bottom', 'options', DHT_PREFIX ); ?></label>

                <span class="dht-spacing-bottom"></span>

                <input class="dht-spacing dht-field"
                       id="<?php echo esc_attr( $field[ 'id' ] ); ?>-bottom"
                       type="number"
                       name="<?php echo esc_attr( $field[ 'id' ] ); ?>[bottom]"
                       value="<?php echo esc_attr( $field[ 'value' ][ 'bottom' ] ); ?>" />

            </div>

            <div class="dht-field-spacing-input">

                <label
                    for="<?php echo esc_attr( $field[ 'id' ] ); ?>-left"><?php echo _x( 'Left', 'options', DHT_PREFIX ); ?></label>

                <span class="dht-spacing-left"></span>

                <input class="dht-spacing dht-field"
                       id="<?php echo esc_attr( $field[ 'id' ] ); ?>-left"
                       type="number"
                       name="<?php echo esc_attr( $field[ 'id' ] ); ?>[left]"
                       value="<?php echo esc_attr( $field[ 'value' ][ 'left' ] ); ?>" />

            </div>

            <div class="dht-field-spacing-input">

                <label
                    for="<?php echo esc_attr( $field[ 'id' ] ); ?>-sizes"><?php echo _x( 'Sizes', 'options', DHT_PREFIX ); ?></label>

                <select class="dht-spacing-dropdown dht-field"
                        name="<?php echo esc_attr( $field[ 'id' ] ); ?>[size]"
                        id="<?php echo esc_attr( $field[ 'id' ] ); ?>-sizes">
					
					<?php foreach ( $sizes as $key => $size ): ?>
                        <option
                            value="<?php echo esc_attr( $key ); ?>" <?php echo $field[ 'value' ][ 'size' ] == $key ? 'selected' : ''; ?>><?php echo esc_html( $size ); ?></option>
					<?php endforeach; ?>

                </select>

            </div>
        </div>
		
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

<?php do_action( 'dht:options:view:fields:spacing_after_area' ); ?>
