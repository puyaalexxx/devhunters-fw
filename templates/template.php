<?php

if ( !defined( 'DHT_MAIN' ) ) die( 'Forbidden' );

?>
<div class="dht-wrapper">

    <div class="dht-container">

        <?php //echo dht_load_preloader(); ?>

        <?php do_action( 'dht_render_dashboard_page_content' ); ?>

    </div>
</div>
