<?php
declare( strict_types = 1 );

namespace DHT\Features\Preloader;

use function DHT\fw;
use function DHT\Helpers\dht_load_view;

if ( !defined( 'DHT_MAIN' ) ) die( 'Forbidden' );

final class Preloader implements IPreloader {
    
    /**
     * @since     1.0.0
     */
    public function __construct() {}
    
    /**
     * Enqueue preloader scripts and styles
     *
     * @return void
     * @since     1.0.0
     */
    public function init() : void {
        
        add_action( 'admin_enqueue_scripts', [ $this, 'enqueuePreloaderScripts' ] );
    }
    
    /**
     * Enqueue preloader scripts and styles
     *
     * @return void
     * @since     1.0.0
     */
    public function enqueuePreloaderScripts() : void {
        
        wp_enqueue_script( DHT_PREFIX . '-preloader-feature', DHT_ASSETS_URI . 'scripts/js/components/preloader/preloader-script.js', array( 'jquery' ), fw()->manifest->get( 'version' ), true );
        
        wp_register_style( DHT_PREFIX . '-preloader-feature', DHT_ASSETS_URI . 'styles/css/components/preloader/preloader-style.css', array(), fw()->manifest->get( 'version' ) );
        wp_enqueue_style( DHT_PREFIX . '-preloader-feature' );
    }
    
    /**
     * render preloader
     *
     * @param int $delay - hide it after this delay
     *
     * @return void
     * @since     1.0.0
     */
    public function render( int $delay = 500 ) : void {
        
        echo dht_load_view( DHT_TEMPLATES_DIR . 'components/preloader/', 'preloader.php', array( 'delay' => $delay ) );
    }
    
}