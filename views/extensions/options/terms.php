<?php
if ( ! defined( 'DHT_MAIN' ) ) {
	die( 'Forbidden' );
}

$args = $args ?? [];
?>
<div class="dht-terms-page-content <?php echo apply_filters( 'dht_options_view_terms_page_area', '' ); ?>">
    <div class="dht-wrapper <?php echo apply_filters( 'dht_options_view_wrapper_classes', '' ); ?>">
        <div class="dht-container">
			
			<?php do_action( 'dht_options_view_terms_before_content' ); ?>
			
			<?php wp_nonce_field( $args[ 'nonce' ][ 'action' ], $args[ 'nonce' ][ 'name' ] ); ?>

            <div class="dht-container-title">
                <h2><?php echo apply_filters( 'dht_options_term_template_container_title', _x( 'Custom Fields', 'options', DHT_PREFIX ) ); ?></h2>
                <div class="dht-divider"></div>
            </div>
			
			<?php if ( ! empty( $args[ 'options' ] ) ): ?>
				
				<?php echo do_shortcode( $args[ 'options' ] ); ?>
			
			<?php else: ?>
				
				<?php echo apply_filters( 'dht_options_no_options_found', _x( 'No options provided', 'options', DHT_PREFIX ) ); ?>
			
			<?php endif; ?>
			
			<?php do_action( 'dht_options_view_terms_after_content' ); ?>

        </div>
    </div>
</div>