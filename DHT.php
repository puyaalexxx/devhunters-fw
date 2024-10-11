<?php
declare( strict_types = 1 );

namespace DHT;

if ( ! defined( 'DHT_MAIN' ) ) {
	die( 'Forbidden' );
}

use DHT\Core\Core;
use DHT\Extensions\Extensions;
use DHT\Helpers\Classes\Environment;
use DHT\helpers\classes\Translations;
use DHT\Helpers\Traits\SingletonTrait;
use function DHT\Helpers\dht_fw_manifest;
use function DHT\Helpers\dht_make_script_as_module_type;
use function DHT\Helpers\dht_print_r;

/**
 * Singleton Class that is used to include the core devhunters-fw functionality that should be used further up
 * (in a custom plugin)
 * Instantiate all DI containers
 */
final class DHT {
	
	use SingletonTrait;
	
	//framework version
	public static string $version;
	
	/**
	 * @since     1.0.0
	 */
	private function __construct() {
		
		do_action( 'dht_fw_before_fw_init' );
		
		{
			//set plugin version
			self::$version = dht_fw_manifest( 'version' );
			
			//load environment variables from the .env file
			Environment::loadEnv( DHT_DIR );
		}
		
		{
			//Enqueue framework general scripts and styles
			add_action( 'admin_enqueue_scripts', [ $this, '_enqueueFrameworkGeneralScripts' ] );
			
			// Load the text domain for localization
			add_action( 'plugins_loaded', [ Translations::class, 'loadTextdomain' ] );
		}
		
		//instantiate all framework features
		$this->_registerFrameworkFeatures( Core::init(), Extensions::init() );
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
			wp_register_style( DHT_PREFIX_CSS . '-fw', DHT_ASSETS_URI . 'dist/css/fw.css', array(), DHT::$version );
			wp_enqueue_style( DHT_PREFIX_CSS . '-fw' );
			
			wp_enqueue_script( DHT_PREFIX_JS . '-fw', DHT_ASSETS_URI . 'dist/js/fw.js', array( 'jquery' ), DHT::$version );
			wp_localize_script( DHT_PREFIX_JS . '-fw', 'dht_framework_info', $localized_data );
			
		}
		else {
			wp_register_style( DHT_PREFIX_CSS . '-main-bundle', DHT_ASSETS_URI . 'dist/main.css', array(), DHT::$version );
			wp_enqueue_style( DHT_PREFIX_CSS . '-main-bundle' );
			
			//this bundle is loading the modules dynamically
			wp_enqueue_script( DHT_PREFIX_JS . '-main-bundle', DHT_ASSETS_URI . 'dist/main.js', array( 'jquery' ), DHT::$version, true );
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
	 * register framework core features, extensions...
	 *
	 * @param Core       $core
	 * @param Extensions $extensions
	 *
	 * @return void
	 * @since     1.0.0
	 */
	private function _registerFrameworkFeatures( Core $core, Extensions $extensions ) : void {
		
		//////////////////////////////////////////
		//// register framework core features ////
		//////////////////////////////////////////
		
		//register framework options
		add_action( 'current_screen', function() use ( $core ) {
			//Config::get_configurations_by_name( PPHT_CONFIG_DIR . 'extensions/options/terms/popup_group_tax.php', 'options' );
			$dashboardPagesOptions = apply_filters( 'dht_options_dashboard_pages_options', [] );
			$postTypeOptions       = apply_filters( 'dht_options_post_types_options', [] );
			
			dht_print_r( $dashboardPagesOptions );
			
			$core->options( $dashboardPagesOptions, $postTypeOptions )?->register();
		} );
		
		//enable the visual builder on these post types
		$core->vb( apply_filters( 'dht_core_vb_post_types', [] ) )->enable();
		
		//register framework cli commands
		add_action( 'cli_init', function() use ( $core ) {
			$core->cli()->registerCustomCliCommands();
		} );
		
		////////////////////////////////////////
		//// register framework extensions /////
		////////////////////////////////////////
		
		//create dashboard menus with plugin configurations
		$extensions->dashMenus( apply_filters( 'dht_extensions_dash_menus_configurations', [] ) )?->register();
		
		//create custom post types with plugin cpt configurations
		$extensions->cpts( apply_filters( 'dht_extensions_cpts_configurations', [] ) )?->create();
		
		//register widgets with plugin configurations
		$extensions->widgets( apply_filters( 'dht_extensions_widgets_configurations', [] ) )?->register();
		
		//register sidebars with plugin sidebar configurations
		$extensions->sidebars( apply_filters( 'dht_extensions_sidebars_configurations', [] ) )?->register();
		
		//enable dynamic sidebars form with plugin sidebar configurations
		$extensions->dynamicSidebars( apply_filters( 'dht_extensions_dynamic_sidebars_configurations', false ) )?->enable();
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