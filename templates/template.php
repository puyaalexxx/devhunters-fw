<?php
if ( !defined( 'DHT_MAIN' ) ) die( 'Forbidden' );

?>
<div class="dht-wrapper">

    <div class="dht-container">

        <?php do_action( 'dht_render_dashboard_page_content' ); ?>

    </div>
</div>

<style>
    .dht-wrapper {
        height: 90vh;
        margin: 30px 30px 0 10px;
        overflow: hidden;
        position: relative
    }

    .dht-wrapper .dht-container {
        background: #fff;
        border-radius: 8px;
        box-shadow: 0 5px 30px rgba(0, 0, 0, .1);
        box-sizing: border-box;
        height: 100%;
        overflow: auto;
        transform-origin: 0 0
    }

    .dht-wrapper .dht-no-content-found {
        font-size: 25px;
        margin: 50px
    }
</style>
