<?php
declare( strict_types = 1 );

namespace DHT\Core\Options\Fields\Fields;

use DHT\Core\Options\Fields\BaseField;
use DHT\Helpers\Classes\Environment;
use DHT\DHT;

if( !defined( 'DHT_MAIN' ) ) {
	die( 'Forbidden' );
}

final class MultiOptions extends BaseField {
	
	//field type
	protected string $_field = 'multi-options';
	
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
		
		//library css
		wp_register_style( DHT_PREFIX_CSS . '-select2-field', DHT_ASSETS_URI . 'styles/libraries/select2.min.css', array(), DHT::$version );
		wp_enqueue_style( DHT_PREFIX_CSS . '-select2-field' );
		
		//library js
		wp_enqueue_script( DHT_PREFIX_JS . '-select2-field', DHT_ASSETS_URI . 'scripts/libraries/select2.full.min.js', array( 'jquery' ), DHT::$version, true );
		
		if( Environment::isDevelopment() ) {
			wp_register_style( DHT_PREFIX_CSS . '-multi-options-field', DHT_ASSETS_URI . 'dist/css/multi-options.css', array(), DHT::$version );
			wp_enqueue_style( DHT_PREFIX_CSS . '-multi-options-field' );
			
			wp_enqueue_script( DHT_PREFIX_JS . '-multi-options-field', DHT_ASSETS_URI . 'dist/js/multi-options.js', array(
				'jquery',
				DHT_PREFIX_JS . '-select2-field'
			), DHT::$version, true );
		}
	}
	
}