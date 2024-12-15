<?php

if( !defined( 'DHT_MAIN' ) ) {
	die( 'Forbidden' );
}

use DHT\Helpers\Classes\OptionsHelpers;

$container = $args[ 'container' ] ?? [];
//get saved values
$saved_values = $container[ 'value' ] ?? [];
//used to call the render method on
$registered_options_classes = $args[ 'registered_options_classes' ] ?? [];
?>
<!-- container - simple -->

<?php do_action( 'dht:options:view:container:simple_before_area' ); ?>

<div
    class="dht-simple-container <?php echo isset( $container[ 'attr' ][ 'class' ] ) && !isset( $container[ 'area' ] ) ? esc_attr( $container[ 'attr' ][ 'class' ] ) : ''; ?>">
	
	<?php if( !empty( $container[ 'options' ] ) ): ?>
		
		<?php $saved_values = $saved_values[ $container[ 'id' ] ] ?? []; ?>
		
		<?php echo OptionsHelpers::renderOptions( $container[ 'options' ], $container[ 'id' ], $saved_values, $registered_options_classes ); ?>
	
	<?php endif; ?>

</div>

<?php do_action( 'dht:options:view:container:simple_after_area' ); ?>
