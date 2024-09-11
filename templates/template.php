<?php

if( !defined( 'DHT_MAIN' ) ) die( 'Forbidden' );

$hook_name = 'dht_render_dashboard_page_content';
?>
<div class="dht-wrapper <?php echo apply_filters( 'dht_template_wrapper_classes', '' ); ?>">

    <div class="dht-container">
        
        <?php //echo dht_load_preloader(); ?>
        
        <?php if( has_action( $hook_name ) ): ?>
            
            <?php do_action( $hook_name ); ?>
        
        <?php else: ?>

            <div class="dht-no-content-found"><?php echo apply_filters( 'dht_template_no_content_found', _x( 'No Content found', 'options', DHT_PREFIX ) ); ?></div>
        
        <?php endif; ?>

    </div>
</div>
