<?php
declare( strict_types = 1 );

namespace DHT;

if ( !defined( 'DHT_MAIN' ) ) die( 'Forbidden' );

use DHT\Core\DI\DIInit;
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
        
        //other initializations
        //include the test file to test different things quickly (remove at the end)
        require_once( plugin_dir_path( __FILE__ ) . "test.php" );
    }
    
}

/**
 * @return FW Framework instance (in case to expose the framework functionality to plugin)
 */
function fw() : FW {
    
    static $FW = null; // cache
    
    if ( $FW === null ) {
        $FW = new Fw();
        
        //framework is loaded
        do_action( 'dht_fw_init' );
    }
    
    return $FW;
}
