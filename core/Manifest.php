<?php
declare( strict_types = 1 );

namespace DHT\Core;

use DHT\Helpers\Traits\SingletonTrait;
use function DHT\Helpers\dht_get_variables_from_file;

if( !defined( 'DHT_MAIN' ) ) {
	die( 'Forbidden' );
}

/*
 * Class used to retrieve the framework manifest array of values
 */

final class Manifest {
	
	use SingletonTrait;
	
	//manifest array values
	private array $_manifest;
	
	/**
	 * @since     1.0.0
	 */
	private function __construct() {
		
		//set manifest args to use them through the class
		$this->_manifest = $this->_getManifestArgs();
	}
	
	/**
	 * retrieve the manifest value from the manifest array
	 *
	 * @param string $key - array key to retrieve
	 *
	 * @return mixed
	 * @since     1.0.0
	 */
	public function get( string $key ) : mixed {
		
		$no_value = _x( 'Value does not exist', 'manifest', DHT_PREFIX );
		
		if( empty( $this->_manifest ) ) {
			return $no_value;
		}
		
		if( array_key_exists( $key, $this->_manifest ) ) {
			
			return $this->_manifest[ $key ];
		}
		
		return $no_value;
	}
	
	/**
	 * retrieve all manifest values
	 *
	 * @return array
	 * @since     1.0.0
	 */
	public function getAllInfo() : array {
		return $this->_manifest;
	}
	
	/**
	 *
	 * retrieve the manifest args from the manifest.php file
	 *
	 * @return array
	 * @since     1.0.0
	 */
	private function _getManifestArgs() : array {
		
		return dht_get_variables_from_file( DHT_DIR . 'manifest.php', 'manifest' );
	}
	
}