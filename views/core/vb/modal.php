<?php
if( !defined( 'DHT_MAIN' ) ) {
	die( 'Forbidden' );
}

$args = $args ?? [];
?>
<div class="dht-wrapper <?php echo apply_filters( 'dht:vb:view:modal:wrapper_classes', '' ); ?>">

    <form action="" method="post" enctype="multipart/form-data">
		
		<?php do_action( 'dht:vb:view:before_modal_content' ); ?>
		
		<?php if( !empty( $args[ 'options' ] ) ): ?>
			
			<?php echo do_shortcode( $args[ 'options' ] ); ?>
		
		<?php else: ?>
			
			<?php echo apply_filters( 'dht:vb:view:modal:no_options_found', _x( 'No options provided', 'options', 'dht' ) ); ?>
		
		<?php endif; ?>
		
		<?php do_action( 'dht:vb:view:after_modal_content' ); ?>

    </form>
</div>
