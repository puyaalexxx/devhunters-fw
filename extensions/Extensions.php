<?php
declare( strict_types = 1 );

namespace DHT\Extensions;

if ( ! defined( 'DHT_MAIN' ) ) {
	die( 'Forbidden' );
}

use DHT\Extensions\CPT\{CPT, ICPT};
use DHT\Extensions\DashPages\{DashMenuPage, IDashMenuPage};
use DHT\Extensions\Options\{IOptions, Options};
use DHT\Extensions\Sidebars\{CreateDynamicSidebars, ICreateDynamicSidebars, IRegisterSidebar, RegisterSidebar};
use DHT\Extensions\Widgets\{IRegisterWidget, RegisterWidget};
use DHT\Helpers\Exceptions\ConfigExceptions\{EmptyCPTConfigurationsException,
	EmptyMenuConfigurationsException,
	EmptySidebarConfigurationsException,
	EmptyWidgetNamesException};
use DHT\Helpers\Traits\{SingletonTrait, ValidateConfigurations};

/**
 * Singleton Class that is used to include all the framework extensions and initialise them
 */
final class Extensions {
	
	use ValidateConfigurations;
	use SingletonTrait;
	
	/**
	 * @since     1.0.0
	 */
	private function __construct() {
		
		do_action( 'dht_before_extensions_init' );
	}
	
	/**
	 * get dashboard menus extension class instance
	 *
	 * @param array $dash_menus_config - dashboard menus configurations
	 *
	 * @return IDashMenuPage - menu instance
	 * @since     1.0.0
	 */
	public function dashmenus( array $dash_menus_config ) : IDashMenuPage {
		
		$dash_menus_config = $this->_validateConfigurations( $dash_menus_config, '', 'dht_dash_menus_configurations', EmptyMenuConfigurationsException::class, _x( 'Empty dashboard menu configurations array provided', 'exceptions', DHT_PREFIX ) );
		
		return new DashMenuPage( $dash_menus_config );
	}
	
	/**
	 * get custom post types extension class instance
	 *
	 * @param array $cpt_config
	 *
	 * @return ICPT - cpt instance
	 * @since     1.0.0
	 */
	public function cpts( array $cpt_config ) : ICPT {
		
		$cpt_config = $this->_validateConfigurations( $cpt_config, '', 'dht_cpts_configurations', EmptyCPTConfigurationsException::class, _x( 'Empty cpt configurations array provided', 'exceptions', DHT_PREFIX ) );
		
		return new CPT( $cpt_config );
	}
	
	/**
	 * get options extension class instance
	 *
	 * @param array $options
	 *
	 * @return IOptions|null - options instance
	 * @since     1.0.0
	 */
	public function options( array $options ) : ?IOptions {
		
		$options = $this->_validateConfigurations( $options, '', 'dht_options_configurations' );
		
		//if the options exists or if it is an ajax request
		// (needed for the options that use ajax specifically)
		if ( ! ( ! empty( $options ) || wp_doing_ajax() ) ) {
			return NULL;
		}
		
		return new Options( $options );
	}
	
	/**
	 * get widgets extension class instance
	 *
	 * @param array $widgets_config
	 *
	 * @return IRegisterWidget - register widgets class instance
	 * @since     1.0.0
	 */
	public function widgets( array $widgets_config ) : IRegisterWidget {
		
		$widgets_config = $this->_validateConfigurations( $widgets_config, '', 'dht_widgets_configurations', EmptyWidgetNamesException::class, _x( 'Empty widgets configurations array provided', 'exceptions', DHT_PREFIX ) );
		
		return new RegisterWidget( $widgets_config );
	}
	
	/**
	 * get sidebars extension class instance
	 *
	 * @param array $sidebar_config
	 *
	 * @return IRegisterSidebar - register sidebar class instance
	 * @since     1.0.0
	 */
	public function sidebars( array $sidebar_config ) : IRegisterSidebar {
		
		$sidebar_config = $this->_validateConfigurations( $sidebar_config, '', 'dht_sidebars_configurations', EmptySidebarConfigurationsException::class, _x( 'Empty configurations array provided', 'exceptions', DHT_PREFIX ) );
		
		return new RegisterSidebar( $sidebar_config );
	}
	
	/**
	 * get dynamic sidebars extension class instance
	 *
	 * @return ICreateDynamicSidebars - create sidebar class instance
	 * @since     1.0.0
	 */
	public function dynamicSidebars() : ICreateDynamicSidebars {
		
		return new CreateDynamicSidebars();
	}
	
}