<?php
declare( strict_types = 1 );

namespace DHT\Core\Options\Fields\Fields;

use DHT\Core\Options\Fields\BaseField;
use DHT\DHT;
use DHT\Helpers\Classes\Environment;

if( !defined( 'DHT_MAIN' ) ) {
	die( 'Forbidden' );
}

final class MultiInput extends BaseField {
	
	//field type
	protected string $_field = 'multi-input';
	
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
		
		if( Environment::isDevelopment() ) {
			wp_register_style( DHT_PREFIX_CSS . '-multiinput-field', DHT_ASSETS_URI . 'dist/css/multiinput.css', array(), DHT::$version );
			wp_enqueue_style( DHT_PREFIX_CSS . '-multiinput-field' );
			
			wp_enqueue_script( DHT_PREFIX_JS . '-multiinput-field', DHT_ASSETS_URI . 'dist/js/multiinput.js', array( 'jquery' ), DHT::$version, true );
		}
	}
	
	/**
	 * merge the field value with the saved value if exists
	 *
	 * @param array $field       - field
	 * @param mixed $saved_value - saved values
	 *
	 * @return mixed
	 * @since     1.0.0
	 */
	public function mergeValues( array $field, $saved_value ) : array {
		
		if( !empty( $saved_value ) ) {
			foreach ( $saved_value as $key => $value ) {
				//remove empty values as they are not needed
				if( empty( $value ) ) {
					unset( $saved_value[ $key ] );
				}
			}
			
			$field[ 'value' ] = $saved_value;
		}
		
		return $field;
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
	 * @return array - changed field value
	 * @since     1.0.0
	 */
	public function saveValue( array $field, $field_post_value ) : array {
		
		if( empty( $field_post_value ) ) {
			return $field[ 'value' ];
		}
		
		$sanitized_values = [];
		foreach ( $field_post_value as $value ) {
			if( !empty( $value ) ) $sanitized_values[] = sanitize_text_field( $value );
		}
		
		return $sanitized_values;
	}
	
}