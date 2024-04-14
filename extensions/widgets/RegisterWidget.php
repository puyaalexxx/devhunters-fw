<?php
declare(strict_types=1);

namespace DHT\Extensions\Widgets;

use function DHT\Helpers\dht_print_r;

if (!defined('DHT_MAIN')) die('Forbidden');

/**
 *
 * Class that is used to register plugin widgets
 */
class RegisterWidget implements IRegisterWidget
{
    /**
     * @param array $widgets - array of widgets to be registered
     */
    public function __construct(array $widgets)
    {
        add_action('widgets_init', function () use ($widgets) {
            $this->registerWidgets($widgets);
        });
    }
    
    /**
     *
     * register all widgets passed into the method
     *
     * @param array $widgets - array of widgets names to register
     * @return void
     */
    public function registerWidgets(array $widgets) : void {
        
        foreach ($widgets as $widget){
            register_widget( $widget );
        }
    }
}