<?php

if ( ! defined( 'DHT_MAIN' ) ) {
	die( 'Forbidden' );
}

$hook_name = 'dht_render_dashboard_page_content';
?>
<div class="dht-wrapper <?php echo apply_filters( 'dht_options_view_wrapper_classes', '' ); ?>">

    <div class="dht-container">
		
		<?php do_action( 'dht_options_view_before_content' ); ?>
		
		<?php if ( has_action( $hook_name ) ): ?>
			
			<?php do_action( $hook_name ); ?>
		
		<?php else: ?>

            <div
                class="dht-no-content-found"><?php echo apply_filters( 'dht_options_view_no_content_found', _x( 'No Content found', 'options', DHT_PREFIX ) ); ?></div>
		
		<?php endif; ?>
		
		<?php do_action( 'dht_options_view_after_content' ); ?>

    </div>
</div>
