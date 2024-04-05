<?php
declare(strict_types=1);

namespace RHT\Src\Core;

use RHT\Src\Core\Pages\MenuPage;
use function RHT\Src\Helpers\{rht_is_array_empty, rht_print_r};

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
        if(!rht_is_array_empty($configurations, 'menu_pages')){
            new MenuPage($configurations['menu_pages']);
        }
        
    }
}