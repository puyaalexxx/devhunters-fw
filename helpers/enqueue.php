<?php
declare( strict_types = 1 );

namespace DHT\Helpers;

if ( ! defined( 'DHT_MAIN' ) ) {
	die( 'Forbidden' );
}


if ( ! function_exists( 'dht_make_script_as_module_type' ) ) {
	/**
	 * Make the fw.js file as a module instead of a simple script
	 * because we can use import inside a module only
	 *
	 * @param string $tag
	 * @param string $handle
	 * @param array  $file_ids Enqueued file ids
	 *
	 * @return string
	 * @since     1.0.0
	 */
	//add_filter( 'script_loader_tag', 'dht_make_script_as_module_type', 10, 2 );
	function dht_make_script_as_module_type( string $tag, string $handle, array $file_ids ) : string {
		
		$moduleAttribute = str_replace( 'src=', 'type="module" src=', $tag );
		
		if ( in_array( $handle, $file_ids, true ) ) {
			return $moduleAttribute;
		}
		
		return $tag;
	}
}