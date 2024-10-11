<?php
declare( strict_types = 1 );

namespace DHT\Core\Vb\Components;

use DHT\Helpers\Classes\Environment;
use DHT\Helpers\Traits\SingletonTrait;
use DHT\DHT;

if ( ! defined( 'DHT_MAIN' ) ) {
	die( 'Forbidden' );
}

/**
 * Buttons Group component (the icons that appears on hovering the element)
 *
 * @since     1.0.0
 */
final class ButtonsGroup {
	
	use SingletonTrait;
	
	/**
	 * @since     1.0.0
	 */
	private function __construct() {
		
		//enqueue scripts
		add_action( 'admin_enqueue_scripts', [ $this, 'enqueueScripts' ] );
	}
	
	/**
	 * Enqueue buttons scripts and styles
	 *
	 * @return void
	 * @since     1.0.0
	 */
	public function enqueueScripts() : void {
		
		if ( Environment::isDevelopment() ) {
			wp_register_style( DHT_PREFIX_CSS . '-buttons-group', DHT_ASSETS_URI . 'dist/css/buttons-group.css', array(), DHT::$version );
			wp_enqueue_style( DHT_PREFIX_CSS . '-buttons-group' );
		}
	}
	
}