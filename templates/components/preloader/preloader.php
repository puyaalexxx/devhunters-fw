<?php
if ( !defined( 'DHT_MAIN' ) ) die( 'Forbidden' );


$args = $args ?? [];
?>
<div id="dht-preloader" data-delay="<?php echo esc_attr( $args[ 'delay' ] ); ?>">
    <div class="dht-spinner-loader"></div>
</div>
