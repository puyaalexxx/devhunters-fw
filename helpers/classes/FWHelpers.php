<?php
declare( strict_types = 1 );

namespace DHT\Helpers\Classes;

use DHT\Core\Manifest;

if( !defined( 'DHT_MAIN' ) ) {
	die( 'Forbidden' );
}

/**
 * Helper methods for framework use only
 */
final class FWHelpers {
	
	/**
	 * Get FW manifest settings
	 *
	 * @return bool The processed value to be saved.
	 * @since     1.0.0
	 */
	public static function getFwManifestByKey( string $key ) : mixed {
		
		return Manifest::init()->get( $key );
	}
	
	/**
	 * Grab composer info to use in framework manifest
	 *
	 * @param string $composer_path
	 *
	 * @return array composer info
	 * @since     1.0.0
	 */
	public static function getComposerInfo( string $composer_path = DHT_DIR . 'composer.json' ) : array {
		$composer_file = DHT_DIR . '/composer.json'; // Adjust the path if necessary
		
		$composer_info = [ 'version' => '1.0.0' ];
		if( file_exists( $composer_path ) ) {
			$composer_data = file_get_contents( $composer_file );
			$composer_json = json_decode( $composer_data, true );
			
			if( isset( $composer_json[ 'version' ] ) ) {
				$composer_info[ 'version' ] = $composer_json[ 'version' ];
			}
			if( isset( $composer_json[ 'name' ] ) ) {
				$composer_info[ 'package_name' ] = $composer_json[ 'name' ];
			}
			if( isset( $composer_json[ 'description' ] ) ) {
				$composer_info[ 'description' ] = $composer_json[ 'description' ];
			}
			if( isset( $composer_json[ 'license' ] ) ) {
				$composer_info[ 'license' ] = $composer_json[ 'license' ];
			}
			if( isset( $composer_json[ 'author' ] ) ) {
				$composer_info[ 'author' ] = $composer_json[ 'author' ];
			}
			if( isset( $composer_json[ 'extra' ] ) ) {
				$composer_info[ 'extra' ] = $composer_json[ 'extra' ];
			}
			if( isset( $composer_json[ 'support' ] ) ) {
				$composer_info[ 'support' ] = $composer_json[ 'support' ];
			}
			if( isset( $composer_json[ 'require' ] ) ) {
				$composer_info[ 'require' ] = $composer_json[ 'require' ];
			}
		}
		
		return $composer_info;
	}
	
}