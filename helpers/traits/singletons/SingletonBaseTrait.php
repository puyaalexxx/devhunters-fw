<?php
declare( strict_types = 1 );

namespace DHT\Helpers\Traits\Singletons;

if( !defined( 'DHT_MAIN' ) ) {
	die( 'Forbidden' );
}

use Exception;

trait SingletonBaseTrait {
	
	/**
	 * Holds the single instance of the class.
	 *
	 * @var array
	 */
	private static array $_instances = [];
	
	/**
	 * Prevents cloning of the instance.
	 *
	 * @since     1.0.0
	 */
	protected function __clone() : void {}
	
	/**
	 * Prevents unserializing of the instance.
	 *
	 * @throws Exception
	 * @since     1.0.0
	 */
	public function __wakeup() {
		
		throw new Exception( _x( 'Cannot unserialize singleton', 'traits', 'dht' ) );
	}
	
}
