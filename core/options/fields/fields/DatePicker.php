<?php
declare( strict_types = 1 );

namespace DHT\Core\Options\Fields\Fields;

use DHT\Core\Options\Fields\BaseField;
use DHT\DHT;
use DHT\Helpers\Classes\Environment;

if ( ! defined( 'DHT_MAIN' ) ) {
	die( 'Forbidden' );
}

class DatePicker extends BaseField {
	
	//field type
	protected string $_field = 'datepicker';
	
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
		wp_register_style( DHT_PREFIX_CSS . '-jquery-ui-datepicker', DHT_ASSETS_URI . 'styles/libraries/jquery-ui-datepicker.min.css', array(), DHT::$version );
		wp_enqueue_style( DHT_PREFIX_CSS . '-jquery-ui-datepicker' );
		
		//library js
		wp_enqueue_script( DHT_PREFIX_JS . '-jquery-ui-datepicker', DHT_ASSETS_URI . 'scripts/libraries/jquery-ui-datepicker.min.js', array(), DHT::$version, true );
		
		if ( Environment::isDevelopment() ) {
			wp_register_style( DHT_PREFIX_CSS . '-datepicker-field', DHT_ASSETS_URI . 'dist/css/datepicker.css', array(), DHT::$version );
			wp_enqueue_style( DHT_PREFIX_CSS . '-datepicker-field' );
			
			wp_enqueue_script_module( DHT_PREFIX_JS . '-datepicker-field', DHT_ASSETS_URI . 'dist/js/datepicker.js', array( DHT_PREFIX_JS . '-jquery-ui-datepicker' ), DHT::$version, true );
		}
	}
	
}