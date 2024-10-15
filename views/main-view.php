<?php

if ( ! defined( 'DHT_MAIN' ) ) {
	die( 'Forbidden' );
}

$hook_name = 'dht:options:view:render_dashboard_page_content';
?>
<div class="dht-wrapper <?php echo apply_filters( 'dht:options:view:wrapper_classes', '' ); ?>">

    <div class="dht-container">
		
		<?php do_action( 'dht:options:view:before_content' ); ?>
		
		<?php if ( has_action( $hook_name ) ): ?>
			
			<?php do_action( $hook_name ); ?>
		
		<?php else: ?>

            <div
                class="dht-no-content-found"><?php echo apply_filters( 'dht:options:view:no_content_found', _x( 'No Content found', 'options', DHT_PREFIX ) ); ?></div>
		
		<?php endif; ?>
		
		<?php do_action( 'dht:options:view:after_content' ); ?>

    </div>
</div>
