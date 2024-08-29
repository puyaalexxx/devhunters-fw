<?php
if ( !defined( 'DHT_MAIN' ) ) die( 'Forbidden' );

$args = $args ?? [];
?>
<div class="dht-meta-box-content">
    <div class="dht-wrapper">
        <div class="dht-container">

            <?php wp_nonce_field( $args[ 'nonce' ][ 'action' ], $args[ 'nonce' ][ 'name' ] ); ?>

            <!--this wrapper will be used for ajax to load content inside-->

            <?php if ( !empty( $args[ 'options' ] ) ): ?>

                <?php echo do_shortcode( $args[ 'options' ] ); ?>

            <?php else: ?>

                <?php echo _x( 'No options provided', 'options', DHT_PREFIX ); ?>

            <?php endif; ?>

        </div>
    </div>
</div>