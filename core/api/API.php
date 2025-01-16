<?php
declare( strict_types = 1 );

namespace DHT\Core\Api;

use DHT\Core\Api\Api\DashMenusAPI;
use DHT\Helpers\Traits\Singletons\SingletonTraitNoParam;

if( !defined( 'DHT_MAIN' ) ) {
	die( 'Forbidden' );
}

/**
 * Singleton Class that is used to register all framework API endpoints
 */
final class API {
	
	use SingletonTraitNoParam;
	
	//dashboard menus
	public DashMenusAPI $dashmenus;
	
	/**
	 * @since     1.0.0
	 */
	public function __construct() {
		
		//get dashboard menus api instance
		$this->dashmenus = new DashMenusAPI();
	}
	
}