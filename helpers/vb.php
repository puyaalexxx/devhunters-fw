<?php
declare( strict_types = 1 );

namespace DHT\Helpers;

if ( ! defined( 'DHT_MAIN' ) ) {
	die( 'Forbidden' );
}


if ( ! function_exists( 'dht_enable_vb_editor_area' ) ) {
	/**
	 * Enable the Visual Builder editor area by adding this
	 * method to an HTML tag. The attribute will do the rest
	 *
	 * @return void
	 * @since     1.0.0
	 */
	function dht_enable_vb_editor_area() : void {
		
		echo 'data-dht-vb-editor="true"';
	}
}
