<?php
declare( strict_types = 1 );

namespace DHT\Helpers\Traits;

if( !defined( 'DHT_MAIN' ) ) {
	die( 'Forbidden' );
}

trait ValidateConfigurationsTrait {
	
	/**
	 * validate the configurations received from plugin
	 *
	 * @param array  $config
	 * @param string $config_key
	 * @param string $exception_class
	 * @param string $exception_message
	 *
	 * @return array
	 * @since     1.0.0
	 */
	private function _validateConfigurations( array $config, string $config_key, string $exception_class = '', string $exception_message = '' ) : array {
		
		if( empty( $config_key ) ) {
			if( !empty( $config ) || empty( $exception_class ) ) {
				return $config;
			}
			else {
				throw new $exception_class( sprintf( _x( '%s', 'exceptions', 'dht' ), $exception_message ) );
			}
		}
		else {
			if( !empty( $config[ $config_key ] ) ) {
				return $config[ $config_key ];
			}
			else {
				throw new $exception_class( sprintf( _x( '%s', 'exceptions', 'dht' ), $exception_message ) );
			}
		}
	}
	
}