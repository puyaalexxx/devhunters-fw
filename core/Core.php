<?php
declare( strict_types = 1 );

namespace DHT\Core;

if( !defined( 'DHT_MAIN' ) ) {
	die( 'Forbidden' );
}

use DHT\Core\Cli\CLI;
use DHT\Core\Options\IOptions;
use DHT\Core\Options\Options;
use DHT\Core\Vb\{IVB, VB};
use DHT\Helpers\Exceptions\ConfigExceptions\EmptyVbPostTypesConfigurationsException;
use DHT\Helpers\Traits\{SingletonTrait, ValidateConfigurations};

/**
 * Singleton Class that is used to include all the framework core features
 */
final class Core {
	
	use ValidateConfigurations;
	use SingletonTrait;
	
	/**
	 * @since     1.0.0
	 */
	private function __construct() {
		
		do_action( 'dht:fw:before_core_init' );
	}
	
	/**
	 * get visual builder class instance
	 *
	 * @param array $custom_post_types - custom posts types
	 *
	 * @return ?IVB - vb instance
	 * @since     1.0.0
	 */
	public function vb( array $custom_post_types ) : ?IVB {
		
		if( empty( $custom_post_types ) ) return NULL;
		
		return new VB( $custom_post_types );
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