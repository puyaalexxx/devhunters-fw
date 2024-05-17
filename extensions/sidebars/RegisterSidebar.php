<?php
declare( strict_types = 1 );

namespace DHT\Extensions\Sidebars;

use DHT\Helpers\Exceptions\ConfigExceptions\EmptySidebarConfigurationsException;
use DHT\Helpers\Traits\ValidateConfigurations;

if ( !defined( 'DHT_MAIN' ) ) die( 'Forbidden' );

/**
 *
 * Class that is used to register plugin sidebars
 */
class RegisterSidebar implements IRegisterSidebar {
    
    use ValidateConfigurations;
    
    /**
     * @since     1.0.0
     */
    public function __construct() {}
    
    /**
     * External Method
     * register sidebars by receiving the plugin configurations
     *
     * @param array $sidebar_config
     *
     * @return void
     * @since     1.0.0
     */
    public function registerSidebars( array $sidebar_config ) : void {
        
        $sidebar_config = $this->_validateConfigurations( $sidebar_config, 'sidebars',
            'sidebars_configurations', EmptySidebarConfigurationsException::class,
            'Empty configurations array provided' );
        
        add_action( 'widgets_init', function () use ( $sidebar_config ) {
            
            $this->registerSidebarsHook( $sidebar_config );
        } );
    }
    
    /**
     *
     * register all sidebars passed into the method via config array
     *
     * @param array $sidebar_config - array of sidebar config
     *
     * @return void
     * @since     1.0.0
     */
    public function registerSidebarsHook( array $sidebar_config ) : void {
        
        foreach ( $sidebar_config as $sidebar ) {
            register_sidebar( $sidebar );
        }
    }
    
}