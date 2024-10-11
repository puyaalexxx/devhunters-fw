<?php
declare( strict_types = 1 );

namespace DHT\Core\Options\Fields\Fields;

use DHT\Core\Options\Fields\BaseField;
use DHT\DHT;
use DHT\Helpers\Classes\Environment;

if ( ! defined( 'DHT_MAIN' ) ) {
	die( 'Forbidden' );
}

final class SwitchField extends BaseField {
	
	//field type
	protected string $_field = 'switch';
	
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
			wp_register_style( DHT_PREFIX_CSS . '-switch-field', DHT_ASSETS_URI . 'dist/css/switch.css', array(), DHT::$version );
			wp_enqueue_style( DHT_PREFIX_CSS . '-switch-field' );
			
			wp_enqueue_script( DHT_PREFIX_JS . '-switch-field', DHT_ASSETS_URI . 'dist/js/switch.js', array( 'jquery' ), DHT::$version, true );
		}
	}
	
}