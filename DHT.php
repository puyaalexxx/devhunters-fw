<?php
declare( strict_types = 1 );

namespace DHT;

if ( ! defined( 'DHT_MAIN' ) ) {
	die( 'Forbidden' );
}

use DHT\Core\Cli\CLI;
use DHT\Core\Core;
use DHT\Core\Manifest;
use DHT\Extensions\Extensions;
use DHT\Helpers\Classes\Environment;
use DHT\helpers\classes\Translations;
use function DHT\Helpers\dht_make_script_as_module_type;

/**
 * Singleton Class that is used to include the core devhunters-fw functionality that should be used further up
 * (in a custom plugin)
 * Instantiate all DI containers
 */
final class DHT {
	
	//framework version
	public static string $version;
	
	//Extensions instance
	public Core $core;
	
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
		
		//load environment variables from the .env file
		Environment::loadEnv( DHT_DIR );
		
		//instantiate framework manifest info
		$this->manifest = Manifest::init();
		
		//instantiate framework core features
		$this->core = Core::init();
		
		//instantiate framework Extensions
		$this->extensions = Extensions::init();
		
		//instantiate framework cli commands
		$this->cli = CLI::init();
		
		//Enqueue framework general scripts and styles
		add_action( 'admin_enqueue_scripts', [ $this, '_enqueueFrameworkGeneralScripts' ] );
		
		// Load the text domain for localization
		add_action( 'plugins_loaded', [ Translations::class, 'loadTextdomain' ] );
		
		//register all the framework cli commands
		add_action( 'cli_init', function() {
			dht()->cli->registerCustomCliCommands();
		} );
	}
	
	/**
	 * Enqueue framework general scripts and styles
	 *
	 * @return void
	 * @since     1.0.0
	 */
	private function _enqueueFrameworkGeneralScripts() : void {
		
		//get localized data
		$localized_data = array_merge( [ 'ajax_url' => admin_url( 'admin-ajax.php' ) ], [ 'translations' => Translations::getTranslationStrings() ] );
		
		if ( Environment::isDevelopment() ) {
			wp_register_style( DHT_PREFIX_CSS . '-fw', DHT_ASSETS_URI . 'dist/css/fw.css', array(), dht()->manifest->get( 'version' ) );
			wp_enqueue_style( DHT_PREFIX_CSS . '-fw' );
			
			wp_enqueue_script( DHT_PREFIX_JS . '-fw', DHT_ASSETS_URI . 'dist/js/fw.js', array( 'jquery' ), dht()->manifest->get( 'version' ) );
			wp_localize_script( DHT_PREFIX_JS . '-fw', 'dht_framework_info', $localized_data );
			
		} else {
			wp_register_style( DHT_PREFIX_CSS . '-main-bundle', DHT_ASSETS_URI . 'dist/main.css', array(), dht()->manifest->get( 'version' ) );
			wp_enqueue_style( DHT_PREFIX_CSS . '-main-bundle' );
			
			//this bundle is loading the modules dynamically
			wp_enqueue_script( DHT_PREFIX_JS . '-main-bundle', DHT_ASSETS_URI . 'dist/main.js', array( 'jquery' ), dht()->manifest->get( 'version' ), true );
			wp_localize_script( DHT_PREFIX_JS . '-main-bundle', 'dht_framework_info', $localized_data );
		}
		
		//make main.js and fw.js as to load as a module
		add_filter( 'script_loader_tag', function( string $tag, string $handle ) : string {
			return dht_make_script_as_module_type( $tag, $handle, [
				DHT_PREFIX_JS . '-main-bundle',
				DHT_PREFIX_JS . '-fw'
			] );
		}, 10, 2 );
	}
	
	/**
	 * Magic method to allow calls to certain methods without exposing them directly
	 * When using dht() the methods won't be exposed
	 */
	public function __call( $method, $arguments ) {
		
		//$this->_loadTextdomain();
		
		// You can control which methods are callable here
		if ( $method === '_enqueueFrameworkGeneralScripts' ) {
			return call_user_func_array( [ $this, '_enqueueFrameworkGeneralScripts' ], $arguments );
		}
		
		return '';
	}
	
}

/**
 * @return DHT Framework instance (in case to expose the framework functionality to a plugin)
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