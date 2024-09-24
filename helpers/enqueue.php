<?php
declare( strict_types = 1 );

namespace DHT\Helpers;

if ( ! defined( 'DHT_MAIN' ) ) {
	die( 'Forbidden' );
}

/**
 * Make the fw.js file as a module instead of a simple script
 * because we can use import inside a module only
 *
 * @param string $tag
 * @param string $handle
 * @param string $fileId Enqueued file id
 *
 * @return string
 * @since     1.0.0
 */
if ( ! function_exists( 'dht_make_script_as_module_type' ) ) {
	//add_filter( 'script_loader_tag', 'dht_make_script_as_module_type', 10, 2 );
	function dht_make_script_as_module_type( string $tag, string $handle, string $fileId ) : string {
		
		if ( $handle === $fileId ) {
			return str_replace( 'src=', 'type="module" src=', $tag );
		}
		
		return $tag;
	}
}