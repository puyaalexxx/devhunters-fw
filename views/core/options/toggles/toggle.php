<?php

use function DHT\Helpers\dht_fw_live_option_selectors;
use function DHT\Helpers\dht_fw_render_field_if_exists;
use function DHT\Helpers\dht_parse_option_attributes;

if( !defined( 'DHT_MAIN' ) ) {
	die( 'Forbidden' );
}

$toggle = $args[ 'toggle' ] ?? [];
//used to call the render method on
$registered_fields = $args[ 'registered_fields' ] ?? [];
//saved values
$saved_values = $args[ 'saved_values' ] ?? [];

$on_off_class = in_array( $toggle[ 'value' ], $toggle[ 'left-choice' ] ) ? 'dht-slider-on' : 'dht-slider-off';
$size         = $toggle[ 'size' ] ?? '';

$left_choice  = $toggle[ 'left-choice' ];
$right_choice = $toggle[ 'right-choice' ];
?>
<!-- field - toggle  -->

<?php do_action( 'dht:options:view:toggles:toggle_before_area' ); ?>

<div
    class="dht-field-wrapper dht-field-wrapper-toggle dht-toggle-type <?php echo isset( $toggle[ 'attr' ][ 'class' ] ) ? esc_attr( $toggle[ 'attr' ][ 'class' ] ) : ''; ?>"
	<?php echo dht_parse_option_attributes( $toggle[ 'attr' ] ); ?>>

    <div class="dht-title"><?php echo esc_html( $toggle[ 'title' ] ); ?></div>

    <div class="dht-field-child-wrapper dht-field-child-toggle">

        <label
            class="dht-toggle <?php echo !empty( $size ) ? 'dht-toggle-btn-' . $size : ''; ?> <?php echo esc_attr( $on_off_class ); ?>"
            for="<?php echo esc_attr( $toggle[ 'id' ] ); ?>">

            <input type="hidden" name="<?php echo esc_attr( $toggle[ 'id' ] ); ?>[value]"
                   value="<?php echo esc_attr( $toggle[ 'value' ] ); ?>" />

            <span class="dht-slider">
                <span class="dht-slider-yes"
                      data-value="<?php echo esc_attr( $left_choice[ 'value' ] ); ?>"
                      <?php echo dht_fw_live_option_selectors( $left_choice[ 'live' ] ?? "" ); ?>>
                    <?php echo esc_attr( $left_choice[ 'label' ] ); ?>
                </span>
                <span class="dht-slider-no"
                      data-value="<?php echo esc_attr( $right_choice[ 'value' ] ); ?>"
                      <?php echo dht_fw_live_option_selectors( $right_choice[ 'live' ] ?? "" ); ?>>
                    <?php echo esc_attr( $right_choice[ 'label' ] ); ?>
                </span>
            </span>

        </label>
		
		<?php if( !empty( $left_choice[ 'options' ] ) ): ?>

            <div
                class="dht-toggle-content dht-toggle-left-choice <?php echo $left_choice[ 'value' ] == $toggle[ 'value' ] ? 'dht-toggle-show' : ''; ?>"
                data-toggle-value="<?php echo esc_attr( $left_choice[ 'value' ] ); ?>">
				<?php
				foreach ( $left_choice[ 'options' ] as $toggle_option ) {
					
					//get saved value
					$saved_value = $saved_values[ 'left-choice' ][ $toggle_option[ 'id' ] ] ?? [];
					
					//render the specific option type
					echo dht_fw_render_field_if_exists( $toggle_option, $saved_value, $toggle[ 'id' ] . '[left-choice]', $registered_fields );
				}
				?>
            </div>
		
		<?php endif; ?>
		
		<?php if( !empty( $right_choice[ 'options' ] ) ): ?>

            <div
                class="dht-toggle-content dht-toggle-right-choice <?php echo $right_choice[ 'value' ] == $toggle[ 'value' ] ? 'dht-toggle-show' : ''; ?>"
                data-toggle-value="<?php echo esc_attr( $right_choice[ 'value' ] ); ?>">
				<?php
				foreach ( $right_choice[ 'options' ] as $toggle_option ) {
					
					//get saved value
					$saved_value = $saved_values[ 'right-choice' ][ $toggle_option[ 'id' ] ] ?? [];
					
					//render the specific option type
					echo dht_fw_render_field_if_exists( $toggle_option, $saved_value, $toggle[ 'id' ] . '[right-choice]', $registered_fields );
				}
				?>
            </div>
		
		<?php endif; ?>
		
		<?php if( !empty( $toggle[ 'description' ] ) ): ?>
            <div class="dht-description"><?php echo esc_html( $toggle[ 'description' ] ); ?></div>
		<?php endif; ?>

    </div>
	
	<?php if( !empty( $toggle[ 'tooltip' ] ) ): ?>
        <div class="dht-info-help dashicons dashicons-info">
            <div class="dht-tooltips"><p class="OnLeft"><?php echo esc_html( $toggle[ 'tooltip' ] ); ?></p></div>
        </div>
	<?php endif; ?>

</div>

<?php if( isset( $toggle[ 'divider' ] ) && $toggle[ 'divider' ] ): ?>
    <div class="dht-divider"></div>
<?php endif; ?>

<?php do_action( 'dht:options:view:toggles:toggle_after_area' ); ?>
