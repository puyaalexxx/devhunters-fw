<?php
declare( strict_types = 1 );

namespace DHT\Extensions\VB;

use DHT\DHT;
use DHT\Extensions\VB\Components\ButtonsGroup;
use DHT\Extensions\VB\Components\DisableEnableBuilder;
use DHT\Extensions\VB\Components\Modal;
use DHT\Helpers\Classes\Environment;
use DHT\Helpers\Classes\Translations;
use function DHT\Helpers\dht_get_current_admin_post_type_from_url;
use function DHT\Helpers\dht_make_script_as_module_type;

if( !defined( 'DHT_MAIN' ) ) {
	die( 'Forbidden' );
}

/**
 * Visual Builder component
 *
 * @since     1.0.0
 */
final class VB implements IVB {
	
	//extension name
	public string $ext_name = 'vb';
	
	private array $_custom_post_types;
	
	/**
	 * @since     1.0.0
	 */
	public function __construct( array $custom_post_types ) {
		
		$this->_custom_post_types = $custom_post_types;
	}
	
	/**
	 * Enable Visual Builder
	 *
	 * @return void
	 */
	public function enable() : void {
		
		//get current editing post type
		$current_post_type = dht_get_current_admin_post_type_from_url();
		
		if( in_array( $current_post_type, $this->_custom_post_types, true ) ) {
			
			//script name to change it in one place only
			$vb_script_name = "vb";
			
			//enqueue the vb scripts
			add_action( 'admin_enqueue_scripts', function() use ( $vb_script_name ) {
				$this->_enqueueScripts( $vb_script_name );
			} );
			
			// add vb modules for dynamic module loading
			add_filter( 'dht:enqueue:fw_dynamic_modules', function( $all_modules ) use ( $vb_script_name ) {
				return array_merge( $all_modules, [ $vb_script_name ] );
			} );
			
			//enable the vb by adding the respective class to the body tag
			add_filter( 'admin_body_class', function( $classes ) {
				return $this->_addVBEnabledBodyClass( $classes );
			} );
			
			//load all VB components
			$this->_includeVBComponents( $current_post_type );
		}
	}
	
	/**
	 * Enqueue vb scripts and styles
	 *
	 * @param string $vb_script_name Script name
	 *
	 * @return void
	 * @since     1.0.0
	 */
	private function _enqueueScripts( string $vb_script_name ) : void {
		
		if( Environment::isDevelopment() ) {
			wp_register_style( DHT_PREFIX_CSS . '-' . $vb_script_name, DHT_ASSETS_URI . 'dist/css/' . $vb_script_name . '.css', array(), DHT::$version );
			wp_enqueue_style( DHT_PREFIX_CSS . '-' . $vb_script_name );
			
			wp_enqueue_script( DHT_PREFIX_JS . '-' . $vb_script_name, DHT_ASSETS_URI . 'dist/js/' . $vb_script_name . '.js', array( 'jquery' ), DHT::$version );
			wp_localize_script( DHT_PREFIX_JS . '-' . $vb_script_name, 'dht_framework_vb_info', [ 'translations' => Translations::getVBTranslationStrings() ] );
			
			//make main.js and fw.js to load as modules
			add_filter( 'script_loader_tag', function( string $tag, string $handle ) use ( $vb_script_name ) : string {
				return dht_make_script_as_module_type( $tag, $handle, [ DHT_PREFIX_JS . '-' . $vb_script_name ] );
			}, 10, 2 );
		}
		else {
			wp_localize_script( DHT_MAIN_SCRIPT_HANDLE, 'dht_framework_vb_info', [ 'translations' => Translations::getVBTranslationStrings() ] );
		}
	}
	
	/**
	 * include all VB components
	 *
	 * @param string $current_post_type Current post type page
	 *
	 * @return void
	 * @since     1.0.0
	 */
	private function _includeVBComponents( string $current_post_type ) : void {
		
		DisableEnableBuilder::init( $current_post_type );
		
		Modal::init();
		
		ButtonsGroup::init();
	}
	
	/**
	 * Add dht-vb-enabled to the post type body tag area
	 *
	 * This class is used to enable the visual builder on elements
	 *
	 * @param string $classes Body tag classes
	 *
	 * @return string
	 * @since     1.0.0
	 */
	private function _addVBEnabledBodyClass( string $classes ) : string {
		
		$classes .= apply_filters( 'dht:vb:body_class_builder_enabled', ' dht-vb-enabled' );
		
		return $classes;
	}
	
}