<?php
if ( !defined( 'DHT_MAIN' ) ) die( 'Forbidden' );

$args = $args ?? [];
?>
<div class="dht-terms-page-content">
    <div class="dht-wrapper">
        <div class="dht-container">

            <?php wp_nonce_field( $args[ 'nonce' ][ 'action' ], $args[ 'nonce' ][ 'name' ] ); ?>

            <div class="dht-container-title">
                <h2><?php echo apply_filters( 'dht_term_options_template_container_title', _x( 'Custom Fields', 'options', DHT_PREFIX ) ); ?></h2>
                <div class="dht-divider"></div>
            </div>

            <?php if ( !empty( $args[ 'options' ] ) ): ?>

                <?php echo do_shortcode( $args[ 'options' ] ); ?>

            <?php else: ?>

                <?php echo _x( 'No options provided', 'options', DHT_PREFIX ); ?>

            <?php endif; ?>

        </div>
    </div>
</div>