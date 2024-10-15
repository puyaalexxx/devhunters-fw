<?php
if ( ! defined( 'DHT_MAIN' ) ) {
	die( 'Forbidden' );
}

$args = $args ?? [];
?>
<div class="dht-meta-box-content <?php echo apply_filters( 'dht:options:view:metabox_area', '' ); ?>">
    <div class="dht-wrapper <?php echo apply_filters( 'dht:options:view:wrapper_classes', '' ); ?>">
        <div class="dht-container">
			
			<?php do_action( 'dht:options:view:metabox_before_content', $args[ 'metabox_id' ] ); ?>
			
			<?php wp_nonce_field( $args[ 'nonce' ][ 'action' ], $args[ 'nonce' ][ 'name' ] ); ?>
			
			<?php if ( ! empty( $args[ 'options' ] ) ): ?>
				
				<?php echo do_shortcode( $args[ 'options' ] ); ?>
			
			<?php else: ?>
				
				<?php echo apply_filters( 'dht:options:view:no_options_found', _x( 'No options provided', 'options', DHT_PREFIX ) ); ?>
			
			<?php endif; ?>
			
			<?php do_action( 'dht:options:view:metabox_after_content', $args[ 'metabox_id' ] ); ?>

        </div>
    </div>
</div>