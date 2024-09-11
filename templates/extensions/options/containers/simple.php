<?php

if( !defined( 'DHT_MAIN' ) ) die( 'Forbidden' );

use function DHT\Helpers\dht_render_options;

$container = $args[ 'container' ] ?? [];
//get saved values
$saved_values = $args[ 'saved_values' ] ?? [];
//used to call the render method on
$registered_options_classes = $args[ 'registered_options_classes' ] ?? [];
?>
<!-- container - simple -->

<?php do_action( 'dht_template_container_simple_before_area' ); ?>

<div class="dht-simple-container <?php echo isset( $container[ 'attr' ][ 'class' ] ) ? esc_attr( $container[ 'attr' ][ 'class' ] ) : ''; ?>">
    
    <?php if( !empty( $container[ 'options' ] ) ): ?>
        
        <?php $saved_values = $saved_values[ $container[ 'id' ] ] ?? []; ?>
        
        <?php echo dht_render_options( $container[ 'options' ], $container[ 'id' ], $saved_values, $registered_options_classes ); ?>
    
    <?php endif; ?>

</div>

<?php do_action( 'dht_template_container_simple_after_area' ); ?>
