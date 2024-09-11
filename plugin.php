<?php
declare( strict_types = 1 );
/**
 * Plugin Name: DevHunters
 * Description: Framework for DevHunters plugins
 * Version: 1.0.0
 * Requires at least: 6.5
 * Requires PHP: 8.0
 * Author: DevHunters
 * Author URI: https://devhunters.dev
 * Text Domain: dht
 */

namespace DHT;

if( !defined( 'ABSPATH' ) ) die( 'Forbidden' );

/**
 * Check if this plugin was not already loaded (maybe as another plugin with different directory name)
 */
if( !defined( 'DHT_MAIN' ) ) {
    //require autoload to load all the plugin classes
    require_once( plugin_dir_path( __FILE__ ) . "vendor/autoload.php" );
    
    
    //initialize plugin functionality
    add_action( 'after_setup_theme', 'DHT\initPlugin', 99 );
    function initPlugin() : void {
        
        //maybe it will be needed
        // FW::init();
    }
    
}
