<?php
declare(strict_types=1);

namespace DHT\Pages;

use function DHT\Helpers\{dht_print_r, dht_is_array_empty};

/**
 *
 * Class that is used to create dashboard menus and submenus dynamically
 */
class MenuPage
{
    private array $dashboard_menus_values;
    
    public function __construct(array $dashboard_menus_values)
    {
       // dht_print_r($dashboard_menus_values);
        //initialize variable with dashboard menu configurations
        $this->dashboard_menus_values = $dashboard_menus_values;
        
        //add dashboard pages hook
        add_action( 'admin_menu', array( $this, "create_menu_pages" ), 99 );
    }
    
    /**
     *
     * create the dashboard menu items  and submenu items
     *
     * @return void
     */
    public function create_menu_pages(): void{
        
        //create main dashboard page
        if(!dht_is_array_empty($this->dashboard_menus_values, 'main_menu_values')){
            $this->create_main_menu_page($this->dashboard_menus_values['main_menu_values']);
        }
        
        //create submenu dashboard pages
        if(!dht_is_array_empty($this->dashboard_menus_values, 'submenu_values')){
            
            foreach ($this->dashboard_menus_values['submenu_values'] as $submenu_values) {
                $this->create_submenu_page($submenu_values);
            }
        }
    }
    
    /**
     *
     * create the dashboard main menu item (top level dashboard menu item)
     *
     * @param array $menu_values
     * @return void
     */
    private function create_main_menu_page( array $menu_values): void{
        
        //destructuring the $menu_values array
        [
            'page_title' => $page_title, 'menu_title' => $menu_title,
            'capability' => $capability, 'menu_slug' => $menu_slug,
            'callback' => $callback, 'icon_url' => $icon_url,
            'position' => $position
        ] = $menu_values;
        
        add_menu_page( $page_title, $menu_title, $capability, $menu_slug, array( $this, $callback), $icon_url, $position );
    }
    
    /**
     *
     * create the dashboard submenu menu item (under the main menu item)
     *
     * @param array $menu_values
     * @return void
     */
    private  function create_submenu_page( array $menu_values ): void{
        
        //destructuring the $menu_values array
        [
            'parent_slug' => $parent_slug, 'page_title' => $page_title,
            'menu_title' => $menu_title, 'capability' => $capability,
            'menu_slug' => $menu_slug, 'callback' => $callback
        ] = $menu_values;
        
        add_submenu_page( $parent_slug, $page_title, $menu_title, $capability, $menu_slug, array( $this, $callback) );
    }
    
    /**
     *
     * dynamically create menu callbacks passed to add_menu_page and add_submenu_page hooks
     *
     * @param string $func_name - function name to be created
     * @param array $arguments - function arguments to be used
     * @return void
     */
    public function __call(string $func_name, array $arguments)
    {
        require_once(DHT_TEMPLATES_DIR . "dashboard-menus/template.php");
    }
}