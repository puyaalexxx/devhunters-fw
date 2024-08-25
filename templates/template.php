<?php

use function DHT\Helpers\dht_load_preloader;

if ( !defined( 'DHT_MAIN' ) ) die( 'Forbidden' );

$hook_name = 'dht_render_dashboard_page_content';
?>
<div class="dht-wrapper">

    <div class="dht-container">

        <?php echo dht_load_preloader(); ?>

        <?php if ( has_action( $hook_name ) ): ?>

            <?php do_action( 'dht_render_dashboard_page_content' ); ?>

        <?php else: ?>

            <div class="dht-no-content-found"><?php echo _x( 'No Content found', 'options', DHT_PREFIX ); ?></div>

        <?php endif; ?>

    </div>
</div>
