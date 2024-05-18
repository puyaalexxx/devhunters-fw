<?php
declare( strict_types = 1 );

namespace DHT\Extensions\Options\Options;

use function DHT\fw;

if ( !defined( 'DHT_MAIN' ) ) die( 'Forbidden' );

final class RadioImage extends BaseOption {
    
    //field type
    protected string $_field = 'radio-image';
    
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
        
        wp_enqueue_script( DHT_PREFIX . '-radio-image-option', DHT_ASSETS_URI . 'scripts/js/extensions/options/radio-image-script.js', array( 'jquery' ), fw()->manifest->get( 'version' ), true );
        
        // Register the style
        wp_register_style( DHT_PREFIX . '-radio-image-option', DHT_ASSETS_URI . 'styles/css/extensions/options/radio-image-style.css', array(), fw()->manifest->get( 'version' ) );
        // Enqueue the style
        wp_enqueue_style( DHT_PREFIX . '-radio-image-option' );
    }
    
}
