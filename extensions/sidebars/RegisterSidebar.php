<?php
declare(strict_types=1);

namespace DHT\Extensions\Sidebars;

if (!defined('DHT_MAIN')) die('Forbidden');

/**
 *
 * Class that is used to register plugin sidebars
 */
class RegisterSidebar implements IRegisterSidebar
{
    /**
     * @param array $sidebar_config - array of sidebars to be registered
     * @since     1.0.0
     */
    public function __construct(array $sidebar_config)
    {
        add_action('widgets_init', function () use ($sidebar_config) {
            $this->registerSidebars($sidebar_config);
        });
    }
    
    /**
     *
     * register all sidebars passed into the method via config array
     *
     * @param array $sidebar_config - array of sidebar config
     * @return void
     * @since     1.0.0
     */
    public function registerSidebars(array $sidebar_config) : void {
    
        foreach ($sidebar_config as $sidebar){
            register_sidebar($sidebar);
        }
    }
}