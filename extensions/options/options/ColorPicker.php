<?php
declare( strict_types = 1 );

namespace DHT\Extensions\Options\Options;

use function DHT\fw;

if ( !defined( 'DHT_MAIN' ) ) die( 'Forbidden' );

final class ColorPicker extends BaseOption {
    
    //field type
    protected string $_field = 'colorpicker';
    
    /**
     * @param array $option - option array
     *
     * @since     1.0.0
     */
    protected function __construct( array $option ) {
        
        parent::__construct( $option );
    }
    
    /**
     * Enqueue input scripts and styles
     *
     * @param string $hook
     * @param array  $option
     *
     * @return void
     * @since     1.0.0
     */
    public function enqueueOptionScripts( string $hook, array $option ) : void {
        
        wp_enqueue_style( 'wp-color-picker' );
        wp_enqueue_script( 'wp-color-picker' );
        
        //include this script only if the option type is rgba
        if ( $option[ 'subtype' ] == 'rgba' ) {
            
            wp_enqueue_script( 'dht-wp-color-picker-alpha', DHT_ASSETS_URI . 'scripts/libraries/wp-color-picker-alpha.min.js', array( 'wp-color-picker' ), fw()->manifest->get( 'version' ), true );
        }
        
        wp_enqueue_script( 'dht-wp-color-picker', DHT_ASSETS_URI . 'scripts/js/options/colorpicker-script.js', array( 'jquery', 'wp-color-picker' ), fw()->manifest->get( 'version' ), true );
    }
    
}