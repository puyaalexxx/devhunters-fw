<?php
declare( strict_types = 1 );

namespace DHT\Helpers;

if ( ! defined( 'DHT_MAIN' ) ) {
	die( 'Forbidden' );
}


if ( ! function_exists( 'dht_enable_vb_on_element' ) ) {
	/**
	 * Enable the Visual Builder on a specific element
	 *
	 * It will add the element HTML inside VB HTML to activate it
	 *
	 * @return string
	 * @since     1.0.0
	 */
	function dht_enable_vb_on_element() : string {}
}
