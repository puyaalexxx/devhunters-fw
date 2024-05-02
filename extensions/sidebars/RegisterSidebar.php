<?php
declare( strict_types = 1 );

namespace DHT\Extensions\Sidebars;

use DHT\Helpers\Exceptions\ConfigExceptions\EmptySidebarConfigurationsException;
use function DHT\Helpers\dht_print_r;

if ( !defined( 'DHT_MAIN' ) ) die( 'Forbidden' );

/**
 *
 * Class that is used to register plugin sidebars
 */
class RegisterSidebar implements IRegisterSidebar {
    
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
     * @throws EmptySidebarConfigurationsException
     * @since     1.0.0
     */
    public function registerSidebars( array $sidebar_config ) : void {
        
        $sidebar_config = $this->_validateSidebarsConfigurations( $sidebar_config );
        
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
    
    /**
     *
     * validate the sidebars configurations received from plugin
     *
     * @param array $sidebar_config
     *
     * @return array
     * @throws EmptySidebarConfigurationsException
     * @since     1.0.0
     */
    private function _validateSidebarsConfigurations( array $sidebar_config ) : array {
        
        if ( !empty( $sidebar_config[ 'sidebars' ] ) ) {
            
            return apply_filters( 'sidebars_configurations', $sidebar_config[ 'sidebars' ] );
        } else {
            
            throw new EmptySidebarConfigurationsException( _x( 'Empty configurations array provided', 'exceptions', DHT_PREFIX ) );
        }
    }
    
}