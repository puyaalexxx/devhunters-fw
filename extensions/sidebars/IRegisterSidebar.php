<?php
declare( strict_types = 1 );

namespace DHT\Extensions\Sidebars;

if( !defined( 'DHT_MAIN' ) ) die( 'Forbidden' );

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