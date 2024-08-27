<?php
declare( strict_types = 1 );

namespace DHT\Extensions\Options\Options\fields;

use DHT\Extensions\Options\Options\BaseField;
use function DHT\fw;

if ( !defined( 'DHT_MAIN' ) ) die( 'Forbidden' );

final class RangeSlider extends BaseField {
    
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
     * @param array $field
     *
     * @return void
     * @since     1.0.0
     */
    public function enqueueOptionScripts( array $field ) : void {
        
        wp_register_style( DHT_PREFIX . '-jquery-ui-rangeslider', DHT_ASSETS_URI . 'styles/libraries/jquery-ui-rangeslider.min.css', array(), fw()->manifest->get( 'version' ) );
        wp_enqueue_style( DHT_PREFIX . '-jquery-ui-rangeslider' );
        
        wp_register_style( DHT_PREFIX . '-rangeslider-field', DHT_ASSETS_URI . 'styles/css/extensions/options/fields/rangeslider-style.css', array(), fw()->manifest->get( 'version' ) );
        wp_enqueue_style( DHT_PREFIX . '-rangeslider-field' );
        
        //WordPress comes with the slider option
        wp_enqueue_script( 'jquery-ui-slider' );
        
        wp_enqueue_script( DHT_PREFIX . '-rangeslider-field', DHT_ASSETS_URI . 'scripts/js/extensions/options/fields/rangeslider-script.js', array( 'jquery-ui-slider' ), fw()->manifest->get( 'version' ), true );
        
    }
    
    /**
     *  In this method you receive $field_post_value (from form submit or whatever)
     *  and must return correct and safe value that will be stored in database.
     *
     *  $field_post_value can be null.
     *  In this case you should return default value from $field['value']
     *
     * @param array $field            - field
     * @param mixed $field_post_value - field $_POST value passed on save
     *
     * @return mixed - changed field value
     * @since     1.0.0
     */
    public function saveValue( array $field, mixed $field_post_value ) : mixed {
        
        if ( empty( $field_post_value ) ) {
            return (int)$field[ 'value' ];
        }
        
        //for the range field
        if ( is_array( $field_post_value ) ) {
            
            $field_vals = [];
            foreach ( $field_post_value as $value ) {
                $field_vals[] = absint( sanitize_text_field( $value ) );
            }
            
            $field_post_value = $field_vals;
            
        } //for the slider field
        else {
            
            $field_post_value = absint( sanitize_text_field( $field_post_value ) );
        }
        
        return $field_post_value;
    }
    
}