<?php
declare( strict_types = 1 );

namespace DHT\Helpers\Traits\Singletons;

if( !defined( 'DHT_MAIN' ) ) {
	die( 'Forbidden' );
}

trait SingletonTraitWithArrayParam {
	
	use SingletonBaseTrait;
	
	/**
	 * This is the static method that controls the access to the singleton
	 * instance. On the first run, it creates a singleton object and places it
	 * into the static field. On subsequent runs, it returns the existing
	 * object stored in the static field.
	 *
	 * @return self - current class
	 * @since     1.0.0
	 */
	public static function init( array $args = [] ) : self {
		
		$cls = static::class;
		if( !isset( self::$_instances[ $cls ] ) ) {
			self::$_instances[ $cls ] = new static( $args );
		}
		
		return self::$_instances[ $cls ];
	}
	
}
