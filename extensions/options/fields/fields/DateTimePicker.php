<?php
declare( strict_types = 1 );

namespace DHT\Extensions\Options\Fields\Fields;

use DHT\Extensions\Options\Fields\BaseField;
use DHT\Helpers\Classes\Environment;
use function DHT\dht;

if ( ! defined( 'DHT_MAIN' ) ) {
	die( 'Forbidden' );
}

class DateTimePicker extends BaseField {
	
	//field type
	protected string $_field = 'datetimepicker';
	
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
		
		//libraries css
		wp_register_style( DHT_PREFIX_CSS . '-jquery-ui-datepicker', DHT_ASSETS_URI . 'styles/libraries/jquery-ui-datepicker.min.css', array(), dht()->manifest->get( 'version' ) );
		wp_enqueue_style( DHT_PREFIX_CSS . '-jquery-ui-datepicker' );
		wp_register_style( DHT_PREFIX_CSS . '-jquery-ui-timepicker', DHT_ASSETS_URI . 'styles/libraries/jquery-ui-timepicker-addon.min.css', array(), dht()->manifest->get( 'version' ) );
		wp_enqueue_style( DHT_PREFIX_CSS . '-jquery-ui-timepicker' );
		
		//WordPress comes with the slider option
		wp_enqueue_script( 'jquery-ui-slider' );
		//libraries js
		wp_enqueue_script( DHT_PREFIX_JS . '-jquery-ui-datepicker', DHT_ASSETS_URI . 'scripts/libraries/jquery-ui-datepicker.min.js', array(), dht()->manifest->get( 'version' ), true );
		wp_enqueue_script( DHT_PREFIX_JS . '-jquery-ui-timepicker', DHT_ASSETS_URI . 'scripts/libraries/jquery-ui-timepicker-addon.min.js', array( DHT_PREFIX_JS . '-jquery-ui-datepicker' ), dht()->manifest->get( 'version' ), true );
		
		if ( Environment::isDevelopment() ) {
			//custom css
			wp_register_style( DHT_PREFIX_CSS . '-datetimepicker-field', DHT_ASSETS_URI . 'dist/css/datetimepicker.css', array(), dht()->manifest->get( 'version' ) );
			wp_enqueue_style( DHT_PREFIX_CSS . '-datetimepicker-field' );
			
			wp_enqueue_script( DHT_PREFIX_JS . '-datetimepicker-field', DHT_ASSETS_URI . 'dist/js/datetimepicker.js', array( DHT_PREFIX_JS . '-jquery-ui-datepicker' ), dht()->manifest->get( 'version' ), true );
		}
	}
	
}