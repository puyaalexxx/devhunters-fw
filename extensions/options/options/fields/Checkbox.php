<?php
declare( strict_types = 1 );

namespace DHT\Extensions\Options\Options\fields;

use DHT\Extensions\Options\Options\BaseOption;
use function DHT\fw;

if ( !defined( 'DHT_MAIN' ) ) die( 'Forbidden' );

//TODO:  if I set a checkbox to be checked by default and then uncheck it and send via POSt it will always be checked
// need to find a fix for this.
final class Checkbox extends BaseOption {
    
    //field type
    protected string $_field = 'checkbox';
    
    /**
     * @since     1.0.0
     */
    public function __construct() {
        
        parent::__construct();
    }
    
    /**
     * Enqueue input scripts and styles
     *
     * @param array $option
     *
     * @return void
     * @since     1.0.0
     */
    public function enqueueOptionScripts( array $option ) : void {
        
        wp_register_style( DHT_PREFIX . '-checkbox-option', DHT_ASSETS_URI . 'styles/css/extensions/options/options/checkbox-style.css', array(), fw()->manifest->get( 'version' ) );
        wp_enqueue_style( DHT_PREFIX . '-checkbox-option' );
    }
    
    /**
     * merge the field value with the saved value if exists
     *
     * @param array $option      - option field
     * @param       $saved_value $saved_value - saved values
     *
     * @return array
     * @since     1.0.0
     */
    public function mergeValues( array $option, mixed $saved_value ) : array {
        
        //if saved value exists
        if ( !empty( $saved_value ) ) {
            
            $values = [];
            foreach ( $option[ 'choices' ] as $checkbox ) {
                
                //if checkbox id exists in saved_values array, save it as checked value
                if ( array_key_exists( $checkbox[ 'id' ], $saved_value ) ) {
                    $values[] = $checkbox[ 'id' ];
                }
            }
            
            $option[ 'value' ] = $values;
            
        } /*elseif ( empty($saved_value) && $option['id'] ) {
            $option[ 'value' ] = [];
        }*/
        
        return $option;
    }
    
}