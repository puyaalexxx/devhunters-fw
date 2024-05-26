<?php
declare( strict_types = 1 );

namespace DHT\Extensions\Options\Options;

use function DHT\fw;

if ( !defined( 'DHT_MAIN' ) ) die( 'Forbidden' );

final class MultiOptions extends BaseOption {
    
    //field type
    protected string $_field = 'multi-options';
    
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
        
        wp_register_style( DHT_PREFIX . '-select2-option', DHT_ASSETS_URI . 'styles/libraries/select2.min.css', array(), fw()->manifest->get( 'version' ) );
        wp_enqueue_style( DHT_PREFIX . '-select2-option' );
        
        //custom option styles
        wp_register_style( DHT_PREFIX . '-multi-options-option', DHT_ASSETS_URI . 'styles/css/extensions/options/multi-options-style.css', array(), fw()->manifest->get( 'version' ) );
        wp_enqueue_style( DHT_PREFIX . '-multi-options-option' );
        
        wp_enqueue_script( DHT_PREFIX . '-select2-option', DHT_ASSETS_URI . 'scripts/libraries/select2.full.min.js', array( 'jquery' ), fw()->manifest->get( 'version' ), true );
        
        //custom option script
        wp_enqueue_script( DHT_PREFIX . '-multi-options-option', DHT_ASSETS_URI . 'scripts/js/extensions/options/multi-options-script.js', array( 'jquery', DHT_PREFIX . '-select2-option' ), fw()->manifest->get( 'version' ), true );
        wp_localize_script( DHT_PREFIX . '-multi-options-option', 'dht_multioptions_ajax', array( 'ajax_url' => admin_url( 'admin-ajax.php' ) ) );
    }
    
}