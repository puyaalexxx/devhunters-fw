<?php
declare( strict_types = 1 );

namespace DHT\Core\Vb\Components;

use DHT\Helpers\Classes\Environment;
use DHT\Helpers\Traits\SingletonTrait;
use function DHT\dht;

if ( ! defined( 'DHT_MAIN' ) ) {
	die( 'Forbidden' );
}

/**
 * Modal component
 *
 * @since     1.0.0
 */
final class Modal {
	
	use SingletonTrait;
	
	/**
	 * @since     1.0.0
	 */
	private function __construct() {
		
		//enqueue the options container scripts
		add_action( 'admin_enqueue_scripts', [ $this, 'enqueueScripts' ] );
	}
	
	/**
	 * Enqueue modal scripts and styles
	 *
	 * @return void
	 * @since     1.0.0
	 */
	public function enqueueScripts() : void {
		
		if ( Environment::isDevelopment() ) {
			wp_register_style( DHT_PREFIX_CSS . '-modal', DHT_ASSETS_URI . 'dist/css/modal.css', array(), dht()->manifest->get( 'version' ) );
			wp_enqueue_style( DHT_PREFIX_CSS . '-modal' );
		}
	}
	
	
	/**
	 * Render the modal template
	 *
	 * @return string
	 * @since     1.0.0
	 */
	/*public function render() : string {
		
		return dht_load_view( DHT_VIEWS_DIR . 'core/vb/components/', 'modal.php' );
	}
	*/
}