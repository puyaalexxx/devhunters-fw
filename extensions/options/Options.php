<?php
declare( strict_types = 1 );

namespace DHT\Extensions\Options;

if ( !defined( 'DHT_MAIN' ) ) die( 'Forbidden' );

use DHT\Extensions\Options\Options\Input;
use DHT\Extensions\Options\Options\Option;
use DHT\Helpers\Exceptions\ConfigExceptions\EmptyOptionsConfigurationsException;

class Options implements IOptions {
    
    /**
     * @since     1.0.0
     */
    public function __construct() {}
    
    /**
     *
     * render options passed from the plugin
     *
     * @param array $options_config - option fields
     *
     * @return void
     * @since     1.0.0
     */
    public function renderOptions( array $options_config ) : void {
        
        $options = $this->_validateOptionsConfigurations( $options_config );
        
        foreach ( $options as $options_key => $option ) {
            
            switch ( $option[ 'type' ] ) {
                case Input::init()->getField():
                    
                    //display option view
                    echo Input::init()->getTemplate( $option );
                    break;
                
                default:
                    echo _x( 'There is no such a field type with option id of' . ' ' . $option[ 'id' ], 'options', PPHT_PREFIX );
                    break;
                
            }
        }
    }
    
    /**
     *
     * validate the options configurations received from plugin
     *
     * @param array $options_config
     *
     * @return array
     * @throws EmptyOptionsConfigurationsException
     * @since     1.0.0
     */
    private function _validateOptionsConfigurations( array $options_config ) : array {
        
        if ( !empty( $options_config ) ) {
            
            return apply_filters( 'options_configurations', $options_config );
        } else {
            
            throw new EmptyOptionsConfigurationsException( _x( 'Empty options configurations array', 'exceptions', DHT_PREFIX ) );
        }
    }
    
}