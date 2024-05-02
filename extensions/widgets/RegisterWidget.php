<?php
declare( strict_types = 1 );

namespace DHT\Extensions\Widgets;

use DHT\Helpers\Exceptions\ConfigExceptions\EmptyWidgetNamesException;

if ( !defined( 'DHT_MAIN' ) ) die( 'Forbidden' );

/**
 *
 * Class that is used to register plugin widgets
 */
class RegisterWidget implements IRegisterWidget {
    
    /**
     * @since     1.0.0
     */
    public function __construct() {}
    
    /**
     * External Method
     * register widgets by receiving the plugin configurations
     *
     * @param array $widgets
     *
     * @return void
     * @throws EmptyWidgetNamesException
     * @since     1.0.0
     */
    public function registerWidgets( array $widgets ) : void {
        
        $widgets_conf = $this->_validateWidgetsConfigurations( $widgets );
        
        add_action( 'widgets_init', function () use ( $widgets_conf ) {
            
            $this->registerWidgetsHook( $widgets_conf );
        } );
    }
    
    /**
     *
     * register widgets method used in widgets_init hook
     *
     * @param array $widgets - array of widgets names to register
     *
     * @return void
     * @since     1.0.0
     */
    public function registerWidgetsHook( array $widgets ) : void {
        
        foreach ( $widgets as $widget ) {
            register_widget( $widget );
        }
    }
    
    /**
     *
     * validate the widgets configurations received from plugin
     *
     * @param array $widgets
     *
     * @return array
     * @throws EmptyWidgetNamesException
     * @since     1.0.0
     */
    private function _validateWidgetsConfigurations( array $widgets ) : array {
        
        if ( !empty( $widgets ) ) {
            
            return apply_filters( 'widgets_configurations', $widgets );
        } else {
            
            throw new EmptyWidgetNamesException( _x( 'Empty widgets configurations array provided', 'exceptions', DHT_PREFIX ) );
        }
    }
    
}