<?php

namespace DHT\Extensions\Sidebars;

/**
 * Interface  that is used for the RegisterSidebar class.
 * used for return types to not couple the code to the actual class
 */
interface IRegisterSidebar {
    
    /**
     * register sidebars by receiving the plugin configurations
     *
     * @return void
     * @since     1.0.0
     */
    public function register() : void;
    
}