<?php
declare( strict_types = 1 );

namespace DHT\Helpers;

if ( ! defined( 'DHT_MAIN' ) ) {
	die( 'Forbidden' );
}

/**
 *
 * load the preloader
 *
 * @param int $delay - milliseconds delay
 *
 * @return string
 * @since     1.0.0
 */
if ( ! function_exists( 'dht_load_preloader' ) ) {
	function dht_load_preloader( int $delay = 500 ) : string {
		
		ob_start(); ?>

        <div class="dht-preloader" data-delay="<?php echo esc_attr( $delay ); ?>">
            <div class="dht-spinner-loader"></div>
        </div>
		
		<?php
		
		return ob_get_clean();
	}
}