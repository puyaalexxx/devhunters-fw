<?php
declare( strict_types = 1 );

namespace DHT\Core\Vb;

use DHT\Core\Vb\Components\ButtonsGroup;
use DHT\Core\Vb\Components\DisableEnableBuilder;
use DHT\Core\Vb\Components\Modal;
use DHT\Helpers\Classes\Environment;
use function DHT\dht;
use function DHT\Helpers\dht_get_current_admin_post_type_from_url;
use function DHT\Helpers\dht_make_script_as_module_type;

if ( ! defined( 'DHT_MAIN' ) ) {
	die( 'Forbidden' );
}

/**
 * Visual Builder component
 *
 * @since     1.0.0
 */
final class VB implements IVB {
	
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
		
		if ( in_array( $current_post_type, $this->_custom_post_types, true ) ) {
			
			//enqueue the vb scripts
			add_action( 'admin_enqueue_scripts', [ $this, 'enqueueScripts' ] );
			
			//enable the vb by adding the respective class to the body tag
			add_filter( 'admin_body_class', [ $this, 'addVBEnabledBodyClass' ] );
			
			//load all VB components
			$this->includeVBComponents( $current_post_type );
		}
	}
	
	/**
	 * Enqueue vb scripts and styles
	 *
	 * @return void
	 * @since     1.0.0
	 */
	public function enqueueScripts() : void {
		
		if ( Environment::isDevelopment() ) {
			wp_register_style( DHT_PREFIX_CSS . '-vb', DHT_ASSETS_URI . 'dist/css/vb.css', array(), dht()->manifest->get( 'version' ) );
			wp_enqueue_style( DHT_PREFIX_CSS . '-vb' );
			
			wp_enqueue_script( DHT_PREFIX_JS . '-vb', DHT_ASSETS_URI . 'dist/js/vb.js', array( 'jquery' ), dht()->manifest->get( 'version' ), true );
			
			//make vb.js as to load as a module
			add_filter( 'script_loader_tag', function( string $tag, string $handle ) : string {
				return dht_make_script_as_module_type( $tag, $handle, [ DHT_PREFIX_JS . '-vb' ] );
			}, 10, 2 );
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
	public function includeVBComponents( string $current_post_type ) : void {
		
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
	public function addVBEnabledBodyClass( string $classes ) : string {
		
		$classes .= apply_filters( 'dht_vb_body_class_builder_enabled', ' dht-vb-enabled' );
		
		return $classes;
	}
	
}