<?php
if( !defined( 'DHT_MAIN' ) ) die( 'Forbidden' );

$args = $args ?? [];
?>
<div class="dht-meta-box-content <?php echo apply_filters( 'dht_template_metabox_area', '' ); ?>">
    <div class="dht-wrapper <?php echo apply_filters( 'dht_template_wrapper_classes', '' ); ?>">
        <div class="dht-container">
            
            <?php wp_nonce_field( $args[ 'nonce' ][ 'action' ], $args[ 'nonce' ][ 'name' ] ); ?>
            
            <?php if( !empty( $args[ 'options' ] ) ): ?>
                
                <?php echo do_shortcode( $args[ 'options' ] ); ?>
            
            <?php else: ?>
                
                <?php echo apply_filters( 'dht_options_no_options_found', _x( 'No options provided', 'options', DHT_PREFIX ) ); ?>
            
            <?php endif; ?>

        </div>
    </div>
</div>