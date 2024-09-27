<?php
declare( strict_types = 1 );

namespace DHT\Helpers\Classes;

use josegonzalez\Dotenv\Loader;

if ( ! defined( 'DHT_MAIN' ) ) {
	die( 'Forbidden' );
}

/**
 * Load .env file variables
 */
class Environment {
	
	/**
	 * Load all environment variables from the .env file
	 *
	 * @param string $path .env file path
	 *
	 * @return void
	 * @since     1.0.0
	 */
	public static function loadEnv( string $path ) : void {
		$loader = new Loader( $path . '.env' );
		$loader->parse();
		$envVariables = $loader->toArray();
		
		// After loading, convert the values
		self::convertEnvValues( $envVariables );
	}
	
	/**
	 * Convert specific environment variables to boolean-friendly strings
	 *
	 * @param array $const_names All .env file constants
	 *
	 * @return void
	 * @since     1.0.0
	 */
	protected static function convertEnvValues( array $const_names ) : void {
		
		foreach ( $const_names as $key => $value ) {
			//is is for the variables that have true or false values
			//getenv is converting them to 1 and 0 and not true and false
			if ( $value ) {
				putenv( "$key=true" );
			} else {
				putenv( "$key=false" );
			}
		}
	}
	
	/**
	 * Check if the environment is development by using the getenv function
	 *
	 * @return bool
	 * @since     1.0.0
	 */
	public static function isDevelopment() : bool {
		return getenv( 'DHT_IS_DEV_ENVIRONMENT' ) === 'true';
	}
	
	/**
	 * Check if the environment is production by using the getenv function
	 *
	 * @return bool
	 * @since     1.0.0
	 */
	public static function isProduction() : bool {
		return getenv( 'DHT_IS_DEV_ENVIRONMENT' ) === 'false';
	}
	
}

