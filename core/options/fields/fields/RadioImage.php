<?php
declare( strict_types = 1 );

namespace DHT\Core\Options\Fields\Fields;

use DHT\Core\Options\Fields\BaseField;
use DHT\DHT;
use DHT\Helpers\Classes\Environment;

if ( ! defined( 'DHT_MAIN' ) ) {
	die( 'Forbidden' );
}

final class RadioImage extends BaseField {
	
	//field type
	protected string $_field = 'radio-image';
	
	/**
	 * @since     1.0.0
	 */
	public function __construct() {
		
		parent::__construct();
	}
	
	/**
	 * Enqueue input scripts and styles
	 *
	 * @param array $field
	 *
	 * @return void
	 * @since     1.0.0
	 */
	public function enqueueOptionScripts( array $field ) : void {
		
		if ( Environment::isDevelopment() ) {
			wp_register_style( DHT_PREFIX_CSS . '-radio-image-field', DHT_ASSETS_URI . 'dist/css/radio-image.css', array(), DHT::$version );
			wp_enqueue_style( DHT_PREFIX_CSS . '-radio-image-field' );
			
			wp_enqueue_script( DHT_PREFIX_JS . '-radio-image-field', DHT_ASSETS_URI . 'dist/js/radio-image.js', array( 'jquery' ), DHT::$version, true );
		}
	}
	
}
