<?php

namespace DHT\Extensions\Widgets;

/**
 * Interface  that is used for the RegisterWidget class.
 * used for return types to not couple the code to the actual class
 */
interface IRegisterWidget {
    
    /**
     * register widgets by receiving the plugin configurations
     *
     * @return void
     * @since     1.0.0
     */
    public function register() : void;
    
}