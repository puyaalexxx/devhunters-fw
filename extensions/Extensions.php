<?php
declare( strict_types = 1 );

namespace DHT\Extensions;

if( !defined( 'DHT_MAIN' ) ) {
	die( 'Forbidden' );
}

use DHT\Extensions\CPT\{CPT, ICPT};
use DHT\Extensions\DashPages\{DashMenuPage, IDashMenuPage};
use DHT\Extensions\Sidebars\{CreateDynamicSidebars, ICreateDynamicSidebars, IRegisterSidebar, RegisterSidebar};
use DHT\Extensions\VB\{IVB, VB};
use DHT\Helpers\Traits\{ValidateConfigurationsTrait};
use DHT\Helpers\Traits\Singletons\SingletonTraitNoParam;

/**
 * Singleton Class that is used to include all the framework extensions and initialise them
 */
final class Extensions {
	
	use ValidateConfigurationsTrait;
	use SingletonTraitNoParam;
	
	/**
	 * @since     1.0.0
	 */
	private function __construct() {
		
		do_action( 'dht:fw:before_extensions_init' );
	}
	
	/**
	 * get dashboard menus extension class instance
	 *
	 * @param array $dash_menus_config - dashboard menus configurations
	 *
	 * @return ?IDashMenuPage - menu instance
	 * @since     1.0.0
	 */
	public function dashmenus( array $dash_menus_config ) : ?IDashMenuPage {
		
		if( empty( $dash_menus_config ) ) return NULL;
		
		return new DashMenuPage( $dash_menus_config );
	}
	
	/**
	 * get custom post types extension class instance
	 *
	 * @param array $cpt_config
	 *
	 * @return ?ICPT - cpt instance
	 * @since     1.0.0
	 */
	public function cpts( array $cpt_config ) : ?ICPT {
		
		if( empty( $cpt_config ) ) return NULL;
		
		return new CPT( $cpt_config );
	}
	
	/**
	 * get sidebars extension class instance
	 *
	 * @param array $sidebar_config
	 *
	 * @return ?IRegisterSidebar - register sidebar class instance
	 * @since     1.0.0
	 */
	public function sidebars( array $sidebar_config ) : ?IRegisterSidebar {
		
		if( empty( $sidebar_config ) ) return NULL;
		
		return new RegisterSidebar( $sidebar_config );
	}
	
	/**
	 * get dynamic sidebars extension class instance
	 *
	 * @param bool $dynamic_sidebars_config
	 *
	 * @return ?ICreateDynamicSidebars - create sidebar class instance
	 * @since     1.0.0
	 */
	public function dynamicSidebars( bool $dynamic_sidebars_config ) : ?ICreateDynamicSidebars {
		
		if( !$dynamic_sidebars_config ) return NULL;
		
		return new CreateDynamicSidebars();
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
	
}