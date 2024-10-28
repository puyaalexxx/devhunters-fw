<?php

if( !defined( 'DHT_MAIN' ) ) {
	die( 'Forbidden' );
}

use function DHT\Helpers\dht_fw_live_option_selectors;
use function DHT\Helpers\dht_fw_render_group;
use function DHT\Helpers\dht_parse_option_attributes;

$group = $args[ 'group' ] ?? [];
//used to call the render method on
$registered_options_classes = $args[ 'registered_options_classes' ] ?? [];
?>
<!-- field - group -->

<?php do_action( 'dht:options:view:groups:group_before_area' ); ?>

<div
    class="dht-field-wrapper dht-field-wrapper-groups dht-group-type <?php echo isset( $group[ 'attr' ][ 'class' ] ) ? esc_attr( $group[ 'attr' ][ 'class' ] ) : ''; ?>"
	<?php echo dht_parse_option_attributes( $group[ 'attr' ] ); ?> <?php echo dht_fw_live_option_selectors( $group[ 'live' ] ?? "" ); ?>>
	
	<?php if( !empty( $group[ 'title' ] ) ): ?>
        <div class="dht-title"><?php echo esc_html( $group[ 'title' ] ); ?></div>
	<?php endif; ?>

    <div class="dht-field-child-wrapper dht-field-child-groups">

        <div class="dht-field-groups">
			
			<?php
			foreach ( $group[ 'options' ] as $group_option ) {
				
				//get saved value
				$saved_value = $group[ 'value' ][ $group_option[ 'id' ] ] ?? [];
				
				echo dht_fw_render_group( $group[ 'id' ], $group_option, $saved_value, $registered_options_classes );
			}
			?>

        </div>
		
		<?php if( !empty( $group[ 'description' ] ) ): ?>
            <div class="dht-description"><?php echo esc_html( $group[ 'description' ] ); ?></div>
		<?php endif; ?>

    </div>
	
	<?php if( !empty( $group[ 'tooltip' ] ) ): ?>
        <div class="dht-info-help dashicons dashicons-info">
            <div class="dht-tooltips"><p class="OnLeft"><?php echo esc_html( $group[ 'tooltip' ] ); ?></p></div>
        </div>
	<?php endif; ?>

</div>

<?php if( isset( $group[ 'divider' ] ) && $group[ 'divider' ] ): ?>
    <div class="dht-divider"></div>
<?php endif; ?>

<?php do_action( 'dht:options:view:groups:group_after_area' ); ?>
