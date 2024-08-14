<?php
declare( strict_types = 1 );

namespace DHT\Extensions\Options\Options\fields;

use DHT\Extensions\Options\Options\BaseOption;
use function DHT\fw;

if ( !defined( 'DHT_MAIN' ) ) die( 'Forbidden' );

final class RangeSlider extends BaseOption {
    
    //field type
    protected string $_field = 'range-slider';
    
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
        
        wp_register_style( DHT_PREFIX . '-jquery-ui-rangeslider', DHT_ASSETS_URI . 'styles/libraries/jquery-ui-rangeslider.min.css', array(), fw()->manifest->get( 'version' ) );
        wp_enqueue_style( DHT_PREFIX . '-jquery-ui-rangeslider' );
        
        wp_register_style( DHT_PREFIX . '-rangeslider-option', DHT_ASSETS_URI . 'styles/css/extensions/options/options/rangeslider-style.css', array(), fw()->manifest->get( 'version' ) );
        wp_enqueue_style( DHT_PREFIX . '-rangeslider-option' );
        
        //WordPress comes with the slider option
        wp_enqueue_script( 'jquery-ui-slider' );
        
        wp_enqueue_script( DHT_PREFIX . '-rangeslider-option', DHT_ASSETS_URI . 'scripts/js/extensions/options/options/rangeslider-script.js', array( 'jquery-ui-slider' ), fw()->manifest->get( 'version' ), true );
        
    }
    
    /**
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
            return (int)$option[ 'value' ];
        }
        
        //for the range field
        if ( is_array( $option_value ) ) {
            
            $option_vals = [];
            foreach ( $option_value as $value ) {
                $option_vals[] = absint( sanitize_text_field( $value ) );
            }
            
            $option_value = $option_vals;
            
        } //for the slider field
        else {
            
            $option_value = absint( sanitize_text_field( $option_value ) );
        }
        
        return $option_value;
    }
    
}