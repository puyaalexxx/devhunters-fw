<?php
declare( strict_types = 1 );

namespace DHT\Extensions\Options\Options;

use function DHT\fw;
use function DHT\Helpers\dht_print_r;

if ( !defined( 'DHT_MAIN' ) ) die( 'Forbidden' );

final class Radio extends BaseOption {
    
    //field type
    protected string $_field = 'radio';
    
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
        wp_register_style( 'dht-radio-option', DHT_ASSETS_URI . 'styles/css/options/radio-style.css', array(), fw()->manifest->get('version') );
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