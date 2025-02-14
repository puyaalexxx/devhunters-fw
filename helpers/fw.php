<?php
declare( strict_types = 1 );

namespace DHT\Helpers;

use DHT\Core\Manifest;

if( !defined( 'DHT_MAIN' ) ) {
	die( 'Forbidden' );
}


if( !function_exists( 'dht_fw_get_manifest_info_by_key' ) ) {
	/**
	 * Get FW manifest info by key
	 *
	 * @param string $key - info key to retrieve
	 *
	 * @return mixed
	 * @since     1.0.0
	 */
	function dht_fw_get_manifest_info_by_key( string $key ) {
		
		return Manifest::init()->get( $key );
	}
}

if( !function_exists( 'dht_fw_get_manifest_info' ) ) {
	/**
	 * Get all FW manifest info
	 *
	 * @return array
	 * @since     1.0.0
	 */
	function dht_fw_get_manifest_info() : array {
		
		return Manifest::init()->getAllInfo();
	}
}