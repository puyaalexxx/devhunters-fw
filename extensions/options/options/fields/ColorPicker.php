<?php
declare( strict_types = 1 );

namespace DHT\Extensions\Options\Options\Fields;

use DHT\Extensions\Options\Options\BaseField;
use DHT\Helpers\Classes\Environment;
use function DHT\fw;
use function DHT\Helpers\dht_print_r;

if( !defined( 'DHT_MAIN' ) ) die( 'Forbidden' );

final class ColorPicker extends BaseField {
    
    //field type
    protected string $_field = 'colorpicker';
    
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
        
        wp_enqueue_style( 'wp-color-picker' );
        wp_enqueue_script( 'wp-color-picker' );
        
        if( Environment::isDevelopment() ) {
            wp_register_style( DHT_PREFIX_CSS . '-wp-color-picker-field', DHT_ASSETS_URI . 'dist/css/colorpicker.css', array(), fw()->manifest->get( 'version' ) );
            wp_enqueue_style( DHT_PREFIX_CSS . '-wp-color-picker-field' );
        }
        
        //include this script only if the option type is rgba
        if( $field[ 'subtype' ] == 'rgba' ) {
            //library js
            wp_enqueue_script( DHT_PREFIX_JS . '-wp-color-picker-option-alpha-field', DHT_ASSETS_URI . 'scripts/libraries/wp-color-picker-alpha.min.js', array(
                'jquery',
                'wp-color-picker'
            ), fw()->manifest->get( 'version' ), true );
            
            if( Environment::isDevelopment() ) {
                wp_enqueue_script( DHT_PREFIX_JS . '-wp-color-picker-field', DHT_ASSETS_URI . 'dist/js/colorpicker.js', array(
                    'jquery',
                    'wp-color-picker',
                    DHT_PREFIX_JS . '-wp-color-picker-option-alpha-field'
                ), fw()->manifest->get( 'version' ), true );
            }
        }
        else {
            
            if( Environment::isDevelopment() ) {
                wp_enqueue_script( DHT_PREFIX_JS . '-wp-color-picker-field', DHT_ASSETS_URI . 'dist/js/colorpicker.js', array(
                    'jquery',
                    'wp-color-picker'
                ), fw()->manifest->get( 'version' ), true );
            }
        }
    }
    
}