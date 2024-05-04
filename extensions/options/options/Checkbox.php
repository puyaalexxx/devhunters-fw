<?php
declare( strict_types = 1 );

namespace DHT\Extensions\Options\Options;

use function DHT\fw;
use function DHT\Helpers\dht_print_r;

if ( !defined( 'DHT_MAIN' ) ) die( 'Forbidden' );

//TODO:  if I set a checkbox to be checked by default and then uncheck it and send via POSt it will always be checked
// need to find a fix for this.
final class Checkbox extends BaseOption {
    
    //field type
    protected string $_field = 'checkbox';
    
    public function __construct() {
        
        parent::__construct();
    }
    
    /**
     * Enqueue the checkbox css file
     *
     * @param string $hook
     *
     * @return void
     * @since     1.0.0
     */
    public function enqueueOptionScripts( string $hook ) : void {
        
        // Register the style
        wp_register_style( 'dht-checkbox-option', DHT_ASSETS_URI . 'styles/css/options/checkbox-style.css', array(), fw()->manifest->get('version') );
        // Enqueue the style
        wp_enqueue_style( 'dht-checkbox-option' );
    }
    
    /**
     *
     * return field type
     *
     * @return string
     * @since     1.0.0
     */
    public function getField() : string {
        
        return $this->_field;
    }
    
    /**
     *
     * return field template
     *
     * @return string
     * @since     1.0.0
     */
    public function render() : string {
        
        return parent::render();
    }
    
    /**
     *
     * merge the field value with the saved value if exists for the checkboxes
     *
     * @param array $option       - option field
     * @param array $saved_values - saved values
     *
     * @return array
     * @since     1.0.0
     */
    protected function _mergeOptionValues( array $option, array $saved_values ) : array {
        
        //if saved value exists
        if ( isset( $saved_values[ $option[ 'id' ] ] ) ) {
            
            foreach ($option['choices'] as $key => $checkbox) {
                
                //if checkbox id exists in saved_values array, make it checked
                if(array_key_exists($checkbox['id'], $saved_values[ $option[ 'id' ] ])) {
                    $option['choices'][$key]['checked'] = true;
                }
                else{
                    $option['choices'][$key]['checked'] = false;
                }
            }
        }
        
        return $option;
    }
}