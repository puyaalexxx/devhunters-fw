<?php
declare( strict_types = 1 );

namespace DHT\Extensions\Options\Options;

use function DHT\fw;

if ( !defined( 'DHT_MAIN' ) ) die( 'Forbidden' );

final class SwitchField extends BaseOption {
    
    //field type
    protected string $_field = 'switch';
    
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
        
        wp_enqueue_script( 'dht-switch-option', DHT_ASSETS_URI . 'scripts/js/options/switch-script.js', array( 'jquery' ), fw()->manifest->get( 'version' ), true );
        
        // Register the style
        wp_register_style( 'dht-switch-option', DHT_ASSETS_URI . 'styles/css/options/switch-style.css', array(), fw()->manifest->get( 'version' ) );
        // Enqueue the style
        wp_enqueue_style( 'dht-switch-option' );
    }
    
}