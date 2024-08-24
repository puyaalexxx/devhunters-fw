<?php
declare( strict_types = 1 );

namespace DHT\Extensions\Options\Options\fields;

use DHT\Extensions\Options\Options\BaseOption;
use function DHT\fw;

if ( !defined( 'DHT_MAIN' ) ) die( 'Forbidden' );

final class ColorPicker extends BaseOption {
    
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
     * @param array $option
     *
     * @return void
     * @since     1.0.0
     */
    public function enqueueOptionScripts( array $option ) : void {
        
        wp_enqueue_style( 'wp-color-picker' );
        wp_enqueue_script( 'wp-color-picker' );
        
        // Register custom style
        wp_register_style( DHT_PREFIX . '-wp-color-picker-option', DHT_ASSETS_URI . 'styles/css/extensions/options/options/colorpicker-style.css', array(), fw()->manifest->get( 'version' ) );
        wp_enqueue_style( DHT_PREFIX . '-wp-color-picker-option' );
        
        
        //include this script only if the option type is rgba
        if ( $option[ 'subtype' ] == 'rgba' ) {
            
            wp_enqueue_script( DHT_PREFIX . '-wp-color-picker-option-alpha', DHT_ASSETS_URI . 'scripts/libraries/wp-color-picker-alpha.min.js', array( 'jquery', 'wp-color-picker' ), fw()->manifest->get( 'version' ), true );
            wp_enqueue_script( DHT_PREFIX . '-wp-color-picker-option', DHT_ASSETS_URI . 'scripts/js/extensions/options/options/colorpicker-script.js', array( 'jquery', 'wp-color-picker', DHT_PREFIX . '-wp-color-picker-option-alpha' ), fw()->manifest->get( 'version' ), true );
        } else {
            wp_enqueue_script( DHT_PREFIX . '-wp-color-picker-option', DHT_ASSETS_URI . 'scripts/js/extensions/options/options/colorpicker-script.js', array( 'jquery', 'wp-color-picker' ), fw()->manifest->get( 'version' ), true );
        }
    }
    
}