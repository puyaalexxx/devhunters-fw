<?php
declare( strict_types = 1 );

namespace DHT\Core;

if ( ! defined( 'DHT_MAIN' ) ) {
	die( 'Forbidden' );
}

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
		
		do_action( 'dht_fw_before_core_init' );
	}
	
	/**
	 * get visual builder class instance
	 *
	 * @param array $custom_post_types - custom posts types
	 *
	 * @return IVB - vb instance
	 * @since     1.0.0
	 */
	public function vb( array $custom_post_types ) : IVB {
		
		$custom_post_types = $this->_validateConfigurations( $custom_post_types, '', 'dht_vb_post_types_to_be_enabled', EmptyVbPostTypesConfigurationsException::class, _x( 'No post types provided', 'exceptions', DHT_PREFIX ) );
		
		return new VB( $custom_post_types );
	}
	
}