<?php
declare( strict_types = 1 );

namespace DHT\Extensions\Options\Options;

use function DHT\fw;

if ( !defined( 'DHT_MAIN' ) ) die( 'Forbidden' );

final class MultiInput extends BaseOption {
    
    //field type
    protected string $_field = 'multi-input';
    
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
        
        wp_enqueue_script( DHT_PREFIX . '-multiinput-option', DHT_ASSETS_URI . 'scripts/js/options/multiinput-script.js', array( 'jquery' ), fw()->manifest->get( 'version' ), true );
        
        // Register the style
        wp_register_style( DHT_PREFIX . '-multiinput-option', DHT_ASSETS_URI . 'styles/css/options/multiinput-style.css', array(), fw()->manifest->get( 'version' ) );
        // Enqueue the style
        wp_enqueue_style( DHT_PREFIX . '-multiinput-option' );
    }
    
    /**
     *
     * merge the field value with the saved value if exists
     *
     * @param array $option      - option field
     * @param mixed $saved_value - saved values
     *
     * @return mixed
     * @since     1.0.0
     */
    public function mergeValues( array $option, mixed $saved_value ) : array {
        
        if ( !empty( $saved_value ) ) {
            
            foreach ( $saved_value as $key => $value ) {
                
                //remove empty values as they are not needed
                if ( empty( $value ) ) unset( $saved_value[ $key ] );
            }
            
            $option[ 'value' ] = $saved_value;
        }
        
        return $option;
    }
    
    /**
     *
     *  In this method you receive $option_value (from form submit or whatever)
     *  and must return correct and safe value that will be stored in database.
     *
     *  $option_value can be null.
     *  In this case you should return default value from $option['value']
     *
     * @param array $option       - option field
     * @param mixed $option_value - saved option value
     *
     * @return mixed - changed option value
     * @since     1.0.0
     */
    public function saveValue( array $option, mixed $option_value ) : mixed {
        
        if ( empty( $option_value ) ) {
            return $option[ 'value' ];
        }
        
        $sanitized_values = [];
        foreach ( $option_value as $key => $value ) {
            
            $sanitized_values[] = sanitize_text_field( $value );
        }
        
        return $sanitized_values;
    }
    
}