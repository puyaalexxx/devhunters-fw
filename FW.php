<?php
declare( strict_types = 1 );

namespace DHT;

if( !defined( 'DHT_MAIN' ) ) die( 'Forbidden' );

use DHT\Core\Manifest;
use DHT\Extensions\Extensions;

/**
 * Singleton Class that is used to include the core devhunters-fw functionality that should be used further up
 * (in a custom plugin)
 * Instantiate all DI containers
 */
final class FW {
    
    //framework version
    public static string $version;
    
    //Extensions instance
    public Extensions $extensions;
    
    //framework manifest info
    public Manifest $manifest;
    
    /**
     * @since     1.0.0
     */
    public function __construct() {
        
        do_action( 'dht_before_fw_init' );
        
        //instantiate framework manifest info
        $this->manifest = Manifest::init();
        
        //instantiate framework Extensions
        $this->extensions = Extensions::init();
        
        //Enqueue framework general scripts and styles
        add_action( 'admin_enqueue_scripts', [
            $this,
            'enqueueFrameworkGeneralScripts'
        ] );
        
        // Load the text domain for localization
        add_action( 'plugins_loaded', [
            $this,
            'loadTextdomain'
        ] );
    }
    
    /**
     * Enqueue framework general scripts and styles
     *
     * @return void
     * @since     1.0.0
     */
    public function enqueueFrameworkGeneralScripts() : void {
        
        wp_enqueue_script( DHT_PREFIX_JS . '-fw', DHT_ASSETS_URI . 'scripts/js/fw-js.js', array( 'jquery' ), fw()->manifest->get( 'version' ), true );
        
        wp_register_style( DHT_PREFIX_CSS . '-fw', DHT_ASSETS_URI . 'styles/css/fw.css', array(), fw()->manifest->get( 'version' ) );
        wp_enqueue_style( DHT_PREFIX_CSS . '-fw' );
    }
    
    
    /**
     * Load Text Domain for translation
     *
     * @return void
     * @since     1.0.0
     */
    public function loadTextdomain() : void {
        
        load_plugin_textdomain( DHT_PREFIX, false, DHT_DIR . '/lang' );
    }
    
}

/**
 * @return FW Framework instance (in case to expose the framework functionality to plugin)
 */
function fw() : FW {
    
    static $FW = NULL; // cache
    
    if( $FW === NULL ) {
        $FW = new Fw();
        
        //framework is loaded
        do_action( 'dht_fw_init' );
    }
    
    return $FW;
}
