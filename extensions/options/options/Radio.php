<?php
declare( strict_types = 1 );

namespace DHT\Extensions\Options\Options;

use function DHT\fw;

if ( !defined( 'DHT_MAIN' ) ) die( 'Forbidden' );

final class Radio extends BaseOption {
    
    //field type
    protected string $_field = 'radio';
    
    /**
     * @param array $option - option array
     *
     * @since     1.0.0
     */
    public function __construct( array $option ) {
        
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
        
        // Register the style
        wp_register_style( 'dht-radio-option', DHT_ASSETS_URI . 'styles/css/options/radio-style.css', array(), fw()->manifest->get( 'version' ) );
        // Enqueue the style
        wp_enqueue_style( 'dht-radio-option' );
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
    
}