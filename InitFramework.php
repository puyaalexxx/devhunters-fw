<?php
declare(strict_types=1);

namespace DHT\Core;

use DHT\Core\Pages\MenuPage;
use function DHT\Helpers\{dht_is_array_empty, dht_print_r};

/**
 *
 * Class that is used to include the core devhunters_framework functionality that should be used further up
 * (in a custom plugin)
 */
class InitFramework
{
    public function __construct(){
    }
    
    /**
     *
     * initialize devhunters_framework functionality
     *
     * @param array $configurations - configurations array from the /config folder area
     * @return void
     */
    public static function init(array $configurations) : void {
        //create dashboard menu pages
        if(!dht_is_array_empty($configurations, 'menu_pages')){
            new MenuPage($configurations['menu_pages']);
        }
        
    }
}