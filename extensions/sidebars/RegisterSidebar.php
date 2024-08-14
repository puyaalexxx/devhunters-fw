<?php
declare( strict_types = 1 );

namespace DHT\Extensions\Sidebars;

if ( !defined( 'DHT_MAIN' ) ) die( 'Forbidden' );

/**
 * Class that is used to register plugin sidebars
 */
final class RegisterSidebar implements IRegisterSidebar {
    
    //extension name
    public string $ext_name = 'sidebars';
    
    //config array
    private array $_sidebar_config;
    
    /**
     * @param array $sidebar_config
     *
     * @since     1.0.0
     */
    public function __construct( array $sidebar_config ) {
        
        $this->_sidebar_config = $sidebar_config;
    }
    
    /**
     * External Method
     * register sidebars by receiving the plugin configurations
     *
     * @return void
     * @since     1.0.0
     */
    public function register() : void {
        
        add_action( 'widgets_init', function () {
            
            $this->registerSidebarsHook( $this->_sidebar_config );
        } );
    }
    
    /**
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