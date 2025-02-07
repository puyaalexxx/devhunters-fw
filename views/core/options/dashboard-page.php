<?php
if( !defined( 'DHT_MAIN' ) ) die( 'Forbidden' );

$args = $args ?? [];
?>
<form action="" method="post" enctype="multipart/form-data">
	
	<?php wp_nonce_field( $args[ 'nonce' ][ 'action' ], $args[ 'nonce' ][ 'name' ] ); ?>

    <div class="dht-field-wrapper-main">
        <button class="dht-button dht-btn-big dht-submit">
            <span><?php echo _x( 'Save Changes', 'options', 'dht' ) ?></span></button>
    </div>

    <div class="dht-divider"></div>

    <!-------------------------------------------------------------------------------------->

    <div class="dht-container-form">

        <!--this wrapper will be used for ajax to load content inside-->
        <div class="dht-container-options">
			
			<?php if( !empty( $args[ 'options' ] ) ): ?>
				
				<?php echo do_shortcode( $args[ 'options' ] ); ?>
			
			<?php else: ?>
				
				<?php echo apply_filters( 'dht:options:view:no_options_found', _x( 'No options provided', 'options', 'dht' ) ); ?>
			
			<?php endif; ?>

        </div>
    </div>

    <!-------------------------------------------------------------------------------------->
    <div class="dht-divider"></div>
    <div class="dht-field-wrapper-main">
        <button class="dht-button dht-btn-big dht-submit">
            <span><?php echo _x( 'Save Changes', 'options', 'dht' ) ?></span></button>
    </div>

</form>
