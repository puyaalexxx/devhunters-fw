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
        wp_register_style( 'dht-checkbox-option', DHT_ASSETS_URI . 'styles/css/options/checkbox-style.css', array(), fw()->manifest->get( 'version' ) );
        // Enqueue the style
        wp_enqueue_style( 'dht-checkbox-option' );
    }
    
    /**
     *
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