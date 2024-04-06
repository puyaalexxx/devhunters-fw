<?php
declare(strict_types=1);

namespace DHT;

use DHT\pages\MenuPage;
use function DHT\Helpers\{dht_is_array_empty};

/**
 *
 * Static Class that is used to include the core devhunters_framework functionality that should be used further up
 * (in a custom plugin)
 */
final class Framework
{
    /**
     *
     * add some initialization settings here
     *
     * @return void
     */
    public static function init() : void {
        //some initialization settings
    }
    
    /**
     *
     * create dashboard menus with received plugin configurations
     *
     * @param mixed $configurations plugin configurations
     * @return void
     */
    public static function create_dashboard_menus(array $configurations): void
    {
        //create dashboard menu pages
        if(!dht_is_array_empty($configurations, 'menu_pages')){
            new MenuPage($configurations['menu_pages']);
        }
    }
    
    /**
     *
     * create plugin options with received plugin configurations
     *
     * @param mixed $configurations plugin configurations
     * @return void
     */
    public static function create_dashboard_options(array $configurations) : void{
        //TODO - create framework options
    }
}
