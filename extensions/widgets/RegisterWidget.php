<?php
declare( strict_types = 1 );

namespace DHT\Extensions\Widgets;

if( !defined( 'DHT_MAIN' ) ) die( 'Forbidden' );

/**
 * Class that is used to register plugin widgets
 */
final class RegisterWidget implements IRegisterWidget {
    
    //extension name
    public string $ext_name = 'widgets';
    
    //config array
    private array $_widgets_config;
    
    /**
     * @param array $widgets_config
     *
     * @since     1.0.0
     */
    public function __construct( array $widgets_config ) {
        
        $this->_widgets_config = $widgets_config;
    }
    
    /**
     * External Method
     * register widgets by receiving the plugin configurations
     *
     * @return void
     * @since     1.0.0
     */
    public function register() : void {
        
        add_action( 'widgets_init', function () {
            
            $this->registerWidgetsHook( $this->_widgets_config );
        } );
    }
    
    /**
     * register widgets method used in widgets_init hook
     *
     * @param array $widgets - array of widgets names to register
     *
     * @return void
     * @since     1.0.0
     */
    public function registerWidgetsHook( array $widgets ) : void {
        
        foreach( $widgets as $widget ) {
            register_widget( $widget );
        }
    }
    
}