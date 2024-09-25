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
	
	/**
	 * If Framework installed as a plugin, no packages will be available.
	 * Register the CLI commands to be able to install everything from wp cli
	 */
	$fw_autoload = plugin_dir_path( __FILE__ ) . "vendor/autoload.php";
	if ( file_exists( $fw_autoload ) ) {
		require_once( $fw_autoload );
	} else {
		//register all the framework cli commands
		if ( class_exists( 'WP_CLI' ) ) {
			add_action( 'cli_init', function() {
				require_once( "constants.php" );
				require_once( "core/cli/Commands.php" );
				
				\WP_CLI::add_command( 'dht', 'DHT\Core\Cli\Commands' );
			} );
		}
	}
	
	//initialize plugin functionality
	add_action( 'after_setup_theme', 'DHT\initPlugin', 99 );
	function initPlugin() : void {
		
		//maybe it will be needed
		// FW::init();
	}
}

