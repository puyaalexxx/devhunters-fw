<?php
declare( strict_types = 1 );

namespace DHT\Extensions\DashPages;

if ( !defined( 'DHT_MAIN' ) ) die( 'Forbidden' );

use DHT\Helpers\Exceptions\ConfigExceptions\EmptyMenuConfigurationsException;
use DHT\Helpers\Traits\ValidateConfigurations;
use function DHT\Helpers\{dht_array_key_exists, dht_load_view};

/**
 *
 * Class that is used to create dashboard menus and submenus dynamically
 */
class DashMenuPage implements IDashMenuPage {
    
    use ValidateConfigurations;
    
    //config array passed from the plugin
    private array $_dashMenusConfig = [];
    
    /**
     * @since     1.0.0
     */
    public function __construct() {
        
        if ( is_admin() ) {
            //add dashboard pages hook
            add_action( 'admin_menu', array( $this, "registerMenuPagesAction" ), 99 );
        }
    }
    
    /**
     * External Method
     * create the dashboard menu items and submenu items by receiving the plugin configurations
     *
     * @param array $dash_menus_config
     *
     * @return void
     * @since     1.0.0
     */
    public function registerDashboardMenuPages( array $dash_menus_config ) : void {
        
        $this->_dashMenusConfig = $this->_validateConfigurations( $dash_menus_config, 'menu_pages',
            'dash_menus_configurations', EmptyMenuConfigurationsException::class,
            'Empty dashboard menu configurations array provided' );
    }
    
    /**
     *
     * create the dashboard menu items  and submenu items hook
     *
     * @return void
     * @since     1.0.0
     */
    public function registerMenuPagesAction() : void {
        
        //create main dashboard page
        if ( !dht_array_key_exists( $this->_dashMenusConfig, 'main_menu_values' ) ) {
            $this->_createMainMenuPage( $this->_dashMenusConfig[ 'main_menu_values' ] );
        }
        
        //create submenu dashboard pages
        if ( !dht_array_key_exists( $this->_dashMenusConfig, 'submenu_values' ) ) {
            
            foreach ( $this->_dashMenusConfig[ 'submenu_values' ] as $submenu_values ) {
                $this->_createSubmenuPage( $submenu_values );
            }
        }
    }
    
    /**
     *
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
     *
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
     *
     * utility method to build the menu callback function with passed arguments
     *
     * @param string $callback
     * @param string $template_path
     * @param array  $additional_options
     *
     * @return callable
     * @since     1.0.0
     */
    private function _mergeCallbackArguments( string $callback, string $template_path, array $additional_options ) : callable {
        
        $func_args = [ 'template_path' => $template_path, 'additional_options' => $additional_options ];
        
        return function () use ( $callback, $func_args ) {
            
            $this->$callback( $func_args );
        };
    }
    
    /**
     *
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
    
    /**
     *
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