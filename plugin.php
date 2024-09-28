<?php
declare( strict_types = 1 );
/**
 * Plugin Name: DevHunters
 * Description: Plugin version is used only for development
 * Requires at least: 6.5
 * Text Domain: dht
 */

namespace DHT;

if ( ! defined( 'ABSPATH' ) ) {
	die( 'Forbidden' );
}

/**
 * Check if this plugin was not already loaded (maybe as another plugin with different directory name)
 */
if ( ! defined( 'DHT_MAIN' ) ) {
	
	//require autoload to load all the framework classes
	require_once( plugin_dir_path( __FILE__ ) . "vendor/autoload.php" );
	
	//initialize plugin functionality
	add_action( 'after_setup_theme', 'DHT\initPlugin', 99 );
	function initPlugin() : void {
		
		//maybe it will be needed
		// FW::init();
	}
}

