<?php
declare(strict_types=1);

namespace DHT\Extensions\DashPages;

use function DHT\Helpers\{dht_array_key_exists, dht_load_view, dht_print_r};

/**
 *
 * Class that is used to create dashboard menus and submenus dynamically
 */
class DashMenuPage implements IDashMenuPage
{
    //config array passed from the plugin
    private array $_dashMenusConfig;
    
    public function __construct(array $dash_menus_config)
    {
        do_action('dht_before_dashboard_menus_init');
        
        //get DI injected dashboard menu configurations from plugin
        $this->_dashMenusConfig = apply_filters('dash_menus_configurations', $dash_menus_config);
        
        if ( is_admin() ) {
            //add dashboard pages hook
            add_action('admin_menu', array($this, "registerMenuPages"), 99);
        }
    }
    
    /**
     *
     * create the dashboard menu items  and submenu items
     *
     * @return void
     */
    public function registerMenuPages(): void {
        
        //create main dashboard page
        if(!dht_array_key_exists($this->_dashMenusConfig, 'main_menu_values')){
            $this->_createMainMenuPage($this->_dashMenusConfig['main_menu_values']);
        }
        
        //create submenu dashboard pages
        if(!dht_array_key_exists($this->_dashMenusConfig, 'submenu_values')){
            
            foreach ($this->_dashMenusConfig['submenu_values'] as $submenu_values) {
                $this->_createSubmenuPage($submenu_values);
            }
        }
        
        do_action('dht_after_dashboard_menus_init');
    }
    
    /**
     *
     * create the dashboard main menu item (top level dashboard menu item)
     *
     * @param array $main_menu_values
     * @return void
     */
    private function _createMainMenuPage( array $main_menu_values): void {
        
        //destructuring the $menu_values array
        [
            'page_title' => $page_title, 'menu_title' => $menu_title,
            'capability' => $capability, 'menu_slug' => $menu_slug,
            'callback' => $callback, 'icon_url' => $icon_url,
            'position' => $position, 'template_path' => $template_path,
            'additional_options' => $additional_options
        ] = $main_menu_values;
        
        $callback_func = $this->_mergeCallbackArguments( $callback, $template_path, $additional_options);
        
        add_menu_page( $page_title, $menu_title, $capability, $menu_slug, $callback_func, $icon_url, $position );
    }
    
    /**
     *
     * create the dashboard submenu menu item (under the main menu item)
     *
     * @param array $submenu_values
     * @return void
     */
    private  function _createSubmenuPage( array $submenu_values ): void{
        
        //destructuring the $menu_values array
        [
            'parent_slug' => $parent_slug, 'page_title' => $page_title,
            'menu_title' => $menu_title, 'capability' => $capability,
            'menu_slug' => $menu_slug, 'callback' => $callback,
            'template_path' => $template_path, 'additional_options' => $additional_options
        ] = $submenu_values;
        
        
        $callback_func = $this->_mergeCallbackArguments( $callback, $template_path, $additional_options);
        
        add_submenu_page( $parent_slug, $page_title, $menu_title, $capability, $menu_slug, $callback_func );
    }
    
    /**
     *
     * get needed menu template
     *
     * @param string $template_path
     * @param string $file
     * @param array $args
     * @return string
     */
    private function _getMenuTemplate( string $template_path, string $file, array $args ): string
    {
        return dht_load_view( $template_path, $file , $args);
    }
    
    /**
     *
     * dynamically create menu callbacks passed to add_menu_page and add_submenu_page hooks
     *
     * @param string $func_name - function name to be created
     * @param array $args - function arguments to be used
     * @return void
     */
    public function __call(string $func_name, array $args)
    {
        echo $this->_getMenuTemplate($args[0]['template_path'], $func_name . '.php', $args[0]['additional_options'] );
    }
    
    /**
     *
     * utility method to build the menu callback function with passed arguments
     *
     * @param string $callback
     * @param string $template_path
     * @param array $additional_options
     * @return callable
     */
    private function _mergeCallbackArguments(string $callback, string $template_path, array $additional_options) : callable {
        
        $func_args = ['template_path' => $template_path, 'additional_options' => $additional_options];
        
        return function() use($callback, $func_args) { $this->$callback($func_args); };
    }
}