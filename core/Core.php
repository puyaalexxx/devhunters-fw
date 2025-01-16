<?php
declare( strict_types = 1 );

namespace DHT\Core;

if( !defined( 'DHT_MAIN' ) ) {
	die( 'Forbidden' );
}

use DHT\Core\Cli\CLI;
use DHT\Core\Options\IOptions;
use DHT\Core\Options\Options;
use DHT\Helpers\Traits\{ValidateConfigurationsTrait};
use DHT\Helpers\Traits\Singletons\SingletonTraitNoParam;

/**
 * Singleton Class that is used to include all the framework core features
 */
final class Core {
	
	use ValidateConfigurationsTrait;
	use SingletonTraitNoParam;
	
	/**
	 * @since     1.0.0
	 */
	private function __construct() {
		
		do_action( 'dht:fw:before_core_init' );
	}
	
	/**
	 * get options class instance
	 *
	 * @param array $dashboardPagesOptions
	 * @param array $postTypeOptions
	 * @param array $termOptions
	 * @param array $vbOptions
	 *
	 * @return ?IOptions - options instance
	 * @since     1.0.0
	 */
	public function options( array $dashboardPagesOptions, array $postTypeOptions, array $termOptions, array $vbOptions ) : ?IOptions {
		
		if( wp_doing_ajax() || !( empty( $dashboardPagesOptions ) && empty( $postTypeOptions ) && empty( $termOptions ) && empty( $vbOptions ) ) ) {
			return new Options( $dashboardPagesOptions, $postTypeOptions, $termOptions, $vbOptions );
		}
		
		return NULL;
	}
	
	/**
	 * get cli class instance
	 *
	 * @return CLI - cli instance
	 * @since     1.0.0
	 */
	public function cli() : CLI {
		
		return new CLI();
	}
	
}