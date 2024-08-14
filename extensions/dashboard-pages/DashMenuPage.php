<?php
declare( strict_types = 1 );

namespace DHT\Extensions\DashPages;

if ( !defined( 'DHT_MAIN' ) ) die( 'Forbidden' );

use DHT\Core\Api\API;
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
        add_action( 'admin_menu', function () use ( $dash_menus_config ) {
            
            $this->registerMenuPagesAction( $dash_menus_config );
            
        }, 99 );
        
        //register menus as rest api endpoints (testing purposes)
        add_action( 'rest_api_init', function () use ( $dash_menus_config ) {
            
            API::init()->dashmenus->registerAPIEndpoints( $dash_menus_config );
        } );
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
        if ( !dht_array_key_exists( $dash_menus_config, 'main_menu' ) ) {
            $this->_createMainMenuPage( $dash_menus_config[ 'main_menu' ] );
        }
        
        //create submenu dashboard pages
        if ( !dht_array_key_exists( $dash_menus_config, 'submenus' ) ) {
            
            foreach ( $dash_menus_config[ 'submenus' ] as $submenu_values ) {
                $this->_createSubmenuPage( $submenu_values );
            }
        }
    }
    
    /**
     * create the dashboard main menu item (top level dashboard menu item)
     *
     * @param array $main_menu_values
     *
     * @return void
     * @since     1.0.0
     */
    private function _createMainMenuPage( array $main_menu_values ) : void {
        
        //destructuring the $menu_values array
        [
            'page_title' => $page_title, 'menu_title' => $menu_title,
            'capability' => $capability, 'menu_slug' => $menu_slug,
            'callback' => $callback, 'icon_url' => $icon_url,
            'position' => $position, 'template_path' => $template_path,
            'additional_options' => $additional_options
        ] = $main_menu_values;
        
        $callback_func = $callback ? $this->_mergeCallbackArguments( $callback, $template_path, $additional_options ) : '';
        
        add_menu_page( $page_title, $menu_title, $capability, $menu_slug, $callback_func, $icon_url, $position );
    }
    
    /**
     * create the dashboard submenu menu item (under the main menu item)
     *
     * @param array $submenu_values
     *
     * @return void
     * @since     1.0.0
     */
    private function _createSubmenuPage( array $submenu_values ) : void {
        
        //destructuring the $menu_values array
        [
            'parent_slug' => $parent_slug, 'page_title' => $page_title,
            'menu_title' => $menu_title, 'capability' => $capability,
            'menu_slug' => $menu_slug, 'callback' => $callback,
            'template_path' => $template_path, 'additional_options' => $additional_options
        ] = $submenu_values;
        
        $callback_func = $callback ? $this->_mergeCallbackArguments( $callback, $template_path, $additional_options ) : '';
        
        add_submenu_page( $parent_slug, $page_title, $menu_title, $capability, $menu_slug, $callback_func );
    }
    
    /**
     * dynamically create menu callbacks passed to add_menu_page and add_submenu_page hooks
     *
     * @param string $func_name - function name to be created
     * @param array  $args      - function arguments to be used
     *
     * @return void
     * @since     1.0.0
     */
    public function __call( string $func_name, array $args ) {
        
        echo $this->_getMenuTemplate( $args[ 0 ][ 'template_path' ], $func_name . '.php', $args[ 0 ][ 'additional_options' ] );
    }
    
}