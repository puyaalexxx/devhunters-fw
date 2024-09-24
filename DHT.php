<?php
declare( strict_types = 1 );

namespace DHT;

if ( ! defined( 'DHT_MAIN' ) ) {
	die( 'Forbidden' );
}

use DHT\Core\Cli\CLI;
use DHT\Core\Manifest;
use DHT\Extensions\Extensions;
use DHT\Helpers\Classes\Environment;

/**
 * Singleton Class that is used to include the core devhunters-fw functionality that should be used further up
 * (in a custom plugin)
 * Instantiate all DI containers
 */
final class DHT {
	
	//framework version
	public static string $version;
	
	//Extensions instance
	public Extensions $extensions;
	
	//framework manifest info
	public Manifest $manifest;
	
	//CLI instance
	public CLI $cli;
	
	/**
	 * @since     1.0.0
	 */
	public function __construct() {
		
		do_action( 'dht_before_fw_init' );
		
		//instantiate framework manifest info
		$this->manifest = Manifest::init();
		
		//instantiate framework Extensions
		$this->extensions = Extensions::init();
		
		//instantiate framework cli commands
		$this->cli = CLI::init();
		
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
		
		//register all the framework cli commands
		add_action( 'cli_init', function() {
			dht()->cli->registerCustomCliCommands();
		} );
	}
	
	/**
	 * Magic method to allow calls to certain methods without exposing them directly
	 * When using dht() the methods won't be exposed
	 */
	public function __call( $method, $arguments ) {
		
		$this->loadTextdomain();
		
		// You can control which methods are callable here
		if ( $method === 'enqueueFrameworkGeneralScripts' ) {
			return call_user_func_array( [ $this, 'enqueueFrameworkGeneralScripts' ], $arguments );
		} elseif ( $method === 'loadTextdomain' ) {
			return call_user_func_array( [ $this, 'loadTextdomain' ], $arguments );
		}
		
		return '';
	}
	
	/**
	 * Enqueue framework general scripts and styles
	 *
	 * @return void
	 * @since     1.0.0
	 */
	private function enqueueFrameworkGeneralScripts() : void {
		
		if ( Environment::isDevelopment() ) {
			wp_register_style( DHT_PREFIX_CSS . '-fw', DHT_ASSETS_URI . 'dist/css/fw.css', array(), dht()->manifest->get( 'version' ) );
			wp_enqueue_style( DHT_PREFIX_CSS . '-fw' );
			
			wp_enqueue_script( DHT_PREFIX_JS . '-fw', DHT_ASSETS_URI . 'dist/js/fw.js', array( 'jquery' ), dht()->manifest->get( 'version' ) );
			wp_localize_script( DHT_PREFIX_JS . '-fw', 'dht_framework_ajax_info', array( 'ajax_url' => admin_url( 'admin-ajax.php' ) ) );
		} else {
			wp_register_style( DHT_PREFIX_CSS . '-main-bundle', DHT_ASSETS_URI . 'dist/main.css', array(), dht()->manifest->get( 'version' ) );
			
			wp_enqueue_style( DHT_PREFIX_CSS . '-main-bundle' );
			//this bundle is loading the modules dynamically
			wp_enqueue_script( DHT_PREFIX_JS . '-main-bundle', DHT_ASSETS_URI . 'dist/main.js', array( 'jquery' ), dht()->manifest->get( 'version' ), true );
			wp_localize_script( DHT_PREFIX_JS . '-main-bundle', 'dht_framework_ajax_info', array( 'ajax_url' => admin_url( 'admin-ajax.php' ) ) );
		}
	}
	
	/**
	 * Load Text Domain for translation
	 *
	 * @return void
	 * @since     1.0.0
	 */
	private function loadTextdomain() : void {
		
		load_plugin_textdomain( DHT_PREFIX, false, DHT_DIR . '/lang' );
	}
	
}

/**
 * @return DHT Framework instance (in case to expose the framework functionality to plugin)
 */
function dht() : DHT {
	
	static $DHT = NULL; // cache
	
	if ( $DHT === NULL ) {
		$DHT = new DHT();
		
		//framework is loaded
		do_action( 'dht_fw_init' );
	}
	
	return $DHT;
}