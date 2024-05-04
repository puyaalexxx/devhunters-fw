<?php
declare( strict_types = 1 );

namespace DHT\Extensions\Options;

if ( !defined( 'DHT_MAIN' ) ) die( 'Forbidden' );

use DHT\Extensions\Options\Options\BaseOption;
use DHT\Extensions\Options\Options\Checkbox;
use DHT\Extensions\Options\Options\Input;
use DHT\Extensions\Options\Options\Option;
use DHT\Extensions\Options\Options\Textarea;
use DHT\Helpers\Exceptions\ConfigExceptions\EmptyOptionsConfigurationsException;
use function DHT\Helpers\dht_load_view;

//TODO: at the end to add CSS styles in post css folder as sass
//TODO: at the end to add js as typescript code
//TODO: for performance reason to merge CSS and Js code somehow for options used in one file
final class Options implements IOptions {
    
    private array $_options = [];
    
    /**
     * @since     1.0.0
     */
    public function __construct() {
        
        //register framework Option Types
        $this->_registerFWOptionTypes();
    }
    
    /**
     *
     * create custom option types located outside the framework
     *
     * @param BaseOption $optionClass
     *
     * @return void
     * @since     1.0.0
     */
    public function registerOptionType( BaseOption $optionClass ) : void {
        
        $this->_options[ $optionClass::init()->getField() ] = $optionClass::init();
    }
    
    
    /**
     *
     * render options passed from the plugin
     *
     * @param array  $options   - option fields
     * @param array  $saved_values
     * @param string $prefix_id - options prefix id
     *
     * @return void
     * @throws EmptyOptionsConfigurationsException
     * @since     1.0.0
     */
    public function renderOptions( array $options, array $saved_values, string $prefix_id = '' ) : void {
        
        $options = $this->_validateOptionsConfigurations( $options );
        
        //render the passed option types
        foreach ( $options as $option ) {
            
            if ( array_key_exists( $option[ 'type' ], $this->_options ) ) {
                
                //pass needed args to the Option Type Class
                $this->_options[ $option[ 'type' ] ]->getFieldOptions( $option, $saved_values, $prefix_id );
                
                //render the respective option type class
                echo $this->_options[ $option[ 'type' ] ]->render();
                
            } else {
                
                //display no option template if no match
                echo dht_load_view( DHT_TEMPLATES_DIR . 'options/', 'no-option.php' );
            }
        }
    }
    
    /**----------------------------- helper methods -------------------------------*/
    
    /**
     *
     * register framework option types
     *
     * @return void
     * @since     1.0.0
     */
    private function _registerFWOptionTypes() : void {
        
        $this->_options[ Input::init()->getField() ] = Input::init();
        $this->_options[ Textarea::init()->getField() ] = Textarea::init();
        $this->_options[ Checkbox::init()->getField() ] = Checkbox::init();
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