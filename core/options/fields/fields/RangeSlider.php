<?php
declare( strict_types = 1 );

namespace DHT\Core\Options\Fields\Fields;

use DHT\Core\Options\Fields\BaseField;
use DHT\DHT;
use DHT\Helpers\Classes\Environment;

if( !defined( 'DHT_MAIN' ) ) {
	die( 'Forbidden' );
}

final class RangeSlider extends BaseField {
	
	//field type
	protected string $_field = 'range-slider';
	
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
		wp_register_style( DHT_PREFIX_CSS . '-jquery-ui-rangeslider', DHT_ASSETS_URI . 'styles/libraries/jquery-ui-rangeslider.min.css', array(), DHT::$version );
		wp_enqueue_style( DHT_PREFIX_CSS . '-jquery-ui-rangeslider' );
		
		//WordPress comes with the slider option
		wp_enqueue_script( 'jquery-ui-slider' );
		
		if( Environment::isDevelopment() ) {
			wp_register_style( DHT_PREFIX_CSS . '-rangeslider-field', DHT_ASSETS_URI . 'dist/css/rangeslider.css', array(), DHT::$version );
			wp_enqueue_style( DHT_PREFIX_CSS . '-rangeslider-field' );
			
			wp_enqueue_script_module( DHT_PREFIX_JS . '-rangeslider-field', DHT_ASSETS_URI . 'dist/js/rangeslider.js', array( 'jquery-ui-slider' ), DHT::$version, true );
		}
	}
	
	/**
	 *  In this method you receive $field_post_value (from form submit or whatever)
	 *  and must return correct and safe value that will be stored in database.
	 *
	 *  $field_post_value can be null.
	 *  In this case you should return default value from $field['value']
	 *
	 * @param array $field            - field
	 * @param mixed $field_post_value - field $_POST value passed on save
	 *
	 * @return mixed - changed field value
	 * @since     1.0.0
	 */
	public function saveValue( array $field, mixed $field_post_value ) : mixed {
		
		if( empty( $field_post_value ) ) {
			return (int) $field[ 'value' ];
		}
		
		//for the range field
		if( is_array( $field_post_value ) ) {
			
			$field_vals = [];
			foreach ( $field_post_value as $value ) {
				$field_vals[] = absint( sanitize_text_field( $value ) );
			}
			
			$field_post_value = $field_vals;
			
		} //for the slider field
		else {
			
			$field_post_value = absint( sanitize_text_field( $field_post_value ) );
		}
		
		return $field_post_value;
	}
	
}