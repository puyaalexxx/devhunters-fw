<?php
if ( ! defined( 'DHT_MAIN' ) ) {
	die( 'Forbidden' );
}

$args = $args ?? [];
?>
<div class="dht-wrapper <?php echo apply_filters( 'dht_vb_view_wrapper_classes', '' ); ?>">
	<?php do_action( 'dht_vb_view_before_modal_content' ); ?>
	
	<?php if ( ! empty( $args[ 'options' ] ) ): ?>
		
		<?php echo do_shortcode( $args[ 'options' ] ); ?>
	
	<?php else: ?>
		
		<?php echo apply_filters( 'dht_options_no_options_found', _x( 'No options provided', 'options', DHT_PREFIX ) ); ?>
	
	<?php endif; ?>
	
	<?php do_action( 'dht_vb_view_after_modal_content' ); ?>
</div>
