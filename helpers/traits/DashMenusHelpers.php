<?php
declare( strict_types = 1 );

namespace DHT\Helpers\Traits;

if ( ! defined( 'DHT_MAIN' ) ) die( 'Forbidden' );

use function DHT\Helpers\dht_load_view;

trait DashMenusHelpers {
	
	/**
	 * utility method to build the menu callback function with passed arguments
	 *
	 * @param string $callback
	 * @param string $template_path
	 * @param array  $additional_args
	 *
	 * @return callable
	 * @since     1.0.0
	 */
	private function _mergeCallbackArguments( string $callback, string $template_path, array $additional_args ) : callable {
		
		$func_args = [
			'template_path'   => $template_path,
			'additional_args' => $additional_args
		];
		
		return function() use ( $callback, $func_args ) {
			
			$this->$callback( $func_args );
		};
	}
	
	/**
	 * get needed menu template
	 *
	 * @param string $template_path
	 * @param string $file
	 * @param array  $args - additional options to pass to the view options
	 *
	 * @return string
	 * @since     1.0.0
	 */
	private function _getMenuTemplate( string $template_path, string $file, array $args ) : string {
		
		return dht_load_view( $template_path, $file, $args );
	}
	
}