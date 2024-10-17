<?php
declare( strict_types = 1 );

namespace DHT\Helpers;

if( !defined( 'DHT_MAIN' ) ) {
	die( 'Forbidden' );
}


if( !function_exists( 'dht_enable_vb_editor_area' ) ) {
	/**
	 * Enable the Visual Builder editor area by adding this
	 * method to an HTML tag. The attribute will do the rest
	 *
	 * @param string $modal_name Modal Name to retrieve its options
	 *
	 * @return void
	 * @since     1.0.0
	 */
	function dht_enable_vb_editor_area( string $modal_name ) : void {
		
		echo 'data-dht-vb-editor="true" data-dht-vb-modal-name="' . $modal_name . '"';
	}
}
