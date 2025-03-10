<?php
declare( strict_types = 1 );

namespace DHT;

if( !defined( 'DHT_MAIN' ) ) {
	die( 'Forbidden' );
}

use DHT\Config\Config;
use DHT\Core\Core;
use DHT\Extensions\Extensions;
use DHT\Helpers\Classes\Environment;
use DHT\Helpers\Classes\Translations;
use DHT\Helpers\Traits\DHTTrait;
use DHT\Helpers\Traits\Singletons\SingletonTraitWithArrayParam;
use function DHT\Helpers\dht_fw_get_manifest_info_by_key;
use function DHT\Helpers\dht_make_script_as_module_type;

/**
 * Singleton Class that is used to include the core devhunters-fw functionality that should be used further up
 * (in a custom plugin)
 * Instantiate all DI containers
 */
final class DHT {
	
	use SingletonTraitWithArrayParam, DHTTrait;
	
	//framework version
	public static string $version;
	
	/**
	 * @param array $plugin_settings Plugin settings to register framework features
	 *
	 * @since     1.0.0
	 */
	private function __construct( array $plugin_settings = [] ) {
		
		do_action( 'dht:fw:before_fw_init' );
		
		{
			//set plugin version
			self::$version = dht_fw_get_manifest_info_by_key( 'version' );
			
			//load environment variables from the .env file
			Environment::loadEnv( DHT_DIR );
		}
		
		{
			//Enqueue framework general scripts and styles
			add_action( 'admin_enqueue_scripts', function() {
				$this->_enqueueFrameworkGeneralScripts();
			} );
			
			// Load the text domain for localization
			Translations::loadTextdomain();
		}
		
		//instantiate all framework features
		$this->_registerFrameworkFeatures( $plugin_settings );
	}
	
	/**
	 * Enqueue framework general scripts and styles
	 *
	 * @return void
	 * @since     1.0.0
	 */
	private function _enqueueFrameworkGeneralScripts() : void {
		
		//script name to change it in one place only
		$fw_script_name = "fw";
		
		//get localized data
		$localized_data = array_merge( [ 'ajax_url' => admin_url( 'admin-ajax.php' ) ]/*, [ 'translations' => Translations::getTranslationStrings() ]*/ );
		
		if( Environment::isDevelopment() ) {
			wp_register_style( DHT_PREFIX_CSS . '-' . $fw_script_name, DHT_ASSETS_URI . 'dist/css/' . $fw_script_name . '.css', array(), DHT::$version );
			wp_enqueue_style( DHT_PREFIX_CSS . '-' . $fw_script_name );
			
			wp_enqueue_script( DHT_PREFIX_JS . '-' . $fw_script_name, DHT_ASSETS_URI . 'dist/js/' . $fw_script_name . '.js', array( 'jquery' ), DHT::$version );
			wp_localize_script( DHT_PREFIX_JS . '-' . $fw_script_name, 'dht_framework_info', $localized_data );
		}
		else {
			wp_register_style( DHT_PREFIX_CSS . '-main-bundle', DHT_ASSETS_URI . 'dist/main.css', array(), DHT::$version );
			wp_enqueue_style( DHT_PREFIX_CSS . '-main-bundle' );
			
			//this bundle is loading the modules dynamically
			wp_enqueue_script( DHT_MAIN_SCRIPT_HANDLE, DHT_ASSETS_URI . 'dist/main.js', array( 'jquery' ), DHT::$version, true );
			wp_localize_script( DHT_MAIN_SCRIPT_HANDLE, 'dht_framework_info', $localized_data );
			wp_localize_script( DHT_MAIN_SCRIPT_HANDLE, 'dht_framework_dynamic_modules_info', apply_filters( 'dht:enqueue:fw_dynamic_modules', [ $fw_script_name ] ) );
		}
		
		//make main.js and fw.js to load as modules
		add_filter( 'script_loader_tag', function( string $tag, string $handle ) use ( $fw_script_name ) : string {
			return dht_make_script_as_module_type( $tag, $handle, [
				DHT_MAIN_SCRIPT_HANDLE,
				DHT_PREFIX_JS . '-' . $fw_script_name
			] );
		}, 10, 2 );
	}
	
	/**
	 * register framework core features, extensions...
	 *
	 * @param array $plugin_settings Plugin settings to register framework features
	 *
	 * @return void
	 * @since     1.0.0
	 */
	private function _registerFrameworkFeatures( array $plugin_settings = [] ) : void {
		
		$core       = Core::init();
		$extensions = Extensions::init();
		
		[
			"dashboard_pages_options_folder_path" => $dashboard_pages_options_folder_path,
			"post_types_options_folder_path"      => $post_types_options_folder_path,
			"terms_options_folder_path"           => $terms_options_folder_path,
			"vb_modal_options_folder_path"        => $vb_modal_options_folder_path,
			"dash_menus_settings_file"            => $dash_menus_settings_file,
			"cpts_settings_file"                  => $cpts_settings_file,
			"sidebars_settings_file"              => $sidebars_settings_file,
			"vb_register_on_post_types"           => $vb_register_on_post_types,
			"enable_dynamic_sidebars"             => $enable_dynamic_sidebars
		] = $this->_getPreparedPluginSettings( $plugin_settings );
		
		//////////////////////////////////////////
		//// register framework core features ////
		//////////////////////////////////////////
		
		//register framework options
		add_action( 'init', function() use (
			$core, $dashboard_pages_options_folder_path,
			$post_types_options_folder_path, $terms_options_folder_path,
			$vb_modal_options_folder_path, $vb_register_on_post_types
		) {
			$dashboardPagesOptions = Config::getDashboardPagesOptions( $dashboard_pages_options_folder_path );
			$postTypeOptions       = Config::getPostTypeOptions( $post_types_options_folder_path );
			$termOptions           = Config::getTermsOptions( $terms_options_folder_path );
			$vbOptions             = Config::getVbOptions( $vb_modal_options_folder_path, $vb_register_on_post_types );
			
			$options = $core->options( $dashboardPagesOptions, $postTypeOptions, $termOptions, $vbOptions );
			if( $options !== NULL ) {
				$options->register();
			}
		} );
		
		//register framework cli commands
		add_action( 'cli_init', function() use ( $core ) {
			$core->cli()->registerCustomCliCommands();
		} );
		
		////////////////////////////////////////
		//// register framework extensions /////
		////////////////////////////////////////
		
		//create dashboard menus with plugin configurations
		$dashMenus = $extensions->dashMenus( Config::getConfigurations( $dash_menus_settings_file ) );
		if( $dashMenus !== NULL ) {
			$dashMenus->register();
		}
		
		//create custom post types with plugin cpt configurations
		$cpts = $extensions->cpts( Config::getConfigurations( $cpts_settings_file ) );
		if( $cpts !== NULL ) {
			$cpts->create();
		}
		
		//register sidebars with plugin sidebar configurations
		$sidebars = $extensions->sidebars( Config::getConfigurations( $sidebars_settings_file ) );
		if( $sidebars !== NULL ) {
			$sidebars->register();
		}
		
		//enable dynamic sidebars form with plugin sidebar configurations
		$dynamicSidebars = $extensions->dynamicSidebars( $enable_dynamic_sidebars );
		if( $dynamicSidebars !== NULL ) {
			$dynamicSidebars->enable();
		}
		
		//enable the visual builder on these post types
		$vb = $extensions->vb( $vb_register_on_post_types );
		if( $vb !== NULL ) {
			$vb->enable();
		}
	}
	
}

