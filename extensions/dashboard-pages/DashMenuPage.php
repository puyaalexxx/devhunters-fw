<?php
declare( strict_types = 1 );

namespace DHT\Extensions\DashPages;

if ( ! defined( 'DHT_MAIN' ) ) {
	die( 'Forbidden' );
}

use DHT\Helpers\Traits\DashMenusHelpers;
use function DHT\Helpers\{dht_array_key_exists};

/**
 *
 * Class that is used to create dashboard menus and submenus dynamically
 */
final class DashMenuPage implements IDashMenuPage {
	
	use DashMenusHelpers;
	
	//extension name
	public string $ext_name = 'dashboard-pages';
	
	/**
	 * @param array $dash_menus_config
	 *
	 * @since     1.0.0
	 */
	public function __construct( array $dash_menus_config ) {
		
		//add dashboard pages hook
		add_action( 'admin_menu', function() use ( $dash_menus_config ) {
			$this->registerMenuPagesAction( $dash_menus_config );
		}, 99 );
	}
	
	/**
	 * External Method
	 * create the dashboard menu items and submenu items by receiving the plugin configurations
	 * This method does nothing, it is added for convenience
	 *
	 * @return void
	 * @since     1.0.0
	 */
	public function register() : void {}
	
	/**
	 * create the dashboard menu items  and submenu items hook
	 *
	 * @param array $dash_menus_config
	 *
	 * @return void
	 * @since     1.0.0
	 */
	public function registerMenuPagesAction( array $dash_menus_config ) : void {
		
		//create main dashboard page
		if ( ! dht_array_key_exists( $dash_menus_config, 'main_menu' ) ) {
			$this->_createMainMenuPage( $dash_menus_config[ 'main_menu' ] );
		}
		
		//create submenu dashboard pages
		if ( ! dht_array_key_exists( $dash_menus_config, 'submenus' ) ) {
			
			foreach ( $dash_menus_config[ 'submenus' ] as $submenu_values ) {
				$this->_createSubmenuPage( $submenu_values );
			}
		}
	}
	
	/**
	 * Create the dashboard main menu item (top level dashboard menu item)
	 *
	 * @param array $main_menu_values
	 *
	 * @return void
	 * @since 1.0.0
	 */
	private function _createMainMenuPage( array $main_menu_values ) : void {
		$this->_createMenuPage( $main_menu_values );
	}
	
	/**
	 * Create the dashboard submenu menu item (under the main menu item)
	 *
	 * @param array $submenu_values
	 *
	 * @return void
	 * @since 1.0.0
	 */
	private function _createSubmenuPage( array $submenu_values ) : void {
		$this->_createMenuPage( $submenu_values, true );
	}
	
	/**
	 * Common method to create a menu or submenu page
	 *
	 * @param array $menu_values
	 * @param bool  $is_submenu
	 *
	 * @return void
	 * @since 1.0.0
	 */
	private function _createMenuPage( array $menu_values, bool $is_submenu = false ) : void {
		// Common destructuring for menu items
		[
			'page_title'      => $page_title,
			'menu_title'      => $menu_title,
			'capability'      => $capability,
			'menu_slug'       => $menu_slug,
			'callback'        => $callback,
			'template_path'   => $template_path,
			'additional_args' => $additional_args,
		] = $menu_values;
		
		$callback_func = $callback ? $this->_mergeCallbackArguments( $callback, $template_path, $additional_args ) : '';
		
		// If it's a submenu, destructure the parent_slug
		if ( $is_submenu ) {
			//submenu menu item specific options
			[
				'parent_slug' => $parent_slug
			] = $menu_values;
			
			add_submenu_page( $parent_slug, $page_title, $menu_title, $capability, $menu_slug, $callback_func );
		}
		else {
			//main menu item specific options
			[
				'icon_url' => $icon_url,
				'position' => $position
			] = $menu_values;
			
			add_menu_page( $page_title, $menu_title, $capability, $menu_slug, $callback_func, $icon_url, $position );
		}
	}
	
	/**
	 * dynamically create menu callbacks passed to add_menu_page and add_submenu_page hooks
	 *
	 * @param string $func_name       - function name to be created
	 * @param array  $additional_args - function arguments to be used
	 *
	 * @return void
	 * @since     1.0.0
	 */
	public function __call( string $func_name, array $additional_args ) {
		
		echo $this->_getMenuTemplate( $additional_args[ 0 ][ 'template_path' ], $func_name . '.php', $additional_args[ 0 ][ 'additional_args' ] );
	}
	
}