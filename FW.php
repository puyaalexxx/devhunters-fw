<?php
declare( strict_types = 1 );

namespace DHT;

if ( !defined( 'DHT_MAIN' ) ) die( 'Forbidden' );

use DHT\Core\DI\DIInit;
use DHT\Core\Manifest;
use DHT\Extensions\Extensions;

/**
 *
 * Singleton Class that is used to include the core devhunters-fw functionality that should be used further up
 * (in a custom plugin)
 * Instantiate all DI containers
 */
final class FW {
    
    //framework version
    public static string $version;
    
    //class instances for Singleton Pattern
    private static array $_instances = [];
    
    //DI container reference
    private DIInit $_diInit;
    
    //dash menu class reference
    public Extensions $extensions;
    
    //framework manifest info
    public Manifest $manifest;
    
    /**
     * @since     1.0.0
     */
    public function __construct() {
        
        do_action( 'dht_before_fw_init' );
        
        //di registration
        $this->_initDI();
        
        //instantiate framework Extensions
        $this->extensions = Extensions::init( $this->_diInit );
        
        //instantiate framework manifest info
        $this->manifest = Manifest::init();
        
        //other initializations
        //include the test file to test different things quickly (remove at the end)
        require_once( plugin_dir_path( __FILE__ ) . "test.php" );
    }
    
    /**
     * Register the PHP-DI containers
     *
     * @return void
     * @since     1.0.0
     */
    private function _initDI() : void {
        
        do_action( 'dht_before_di_init' );
        
        $this->_diInit = new DIInit();
        
        do_action( 'dht_after_di_init' );
    }
    
}

/**
 * @return FW Framework instance
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
