<?php
declare( strict_types = 1 );

namespace DHT\Core\Options\Fields\Fields;

use DHT\Core\Options\Fields\BaseField;
use DHT\DHT;
use DHT\Helpers\Classes\Environment;

if( !defined( 'DHT_MAIN' ) ) {
	die( 'Forbidden' );
}

final class Input extends BaseField {
	
	//field type
	protected string $_field = 'input';
	
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
			wp_enqueue_script_module( DHT_PREFIX_JS . '-input-field', DHT_ASSETS_URI . 'dist/js/input.js', array( 'jquery' ), DHT::$version );
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
	 * @param mixed $field_post_value - $field $_POST value passed on save
	 *
	 * @return mixed - changed field value
	 * @since     1.0.0
	 */
	public function saveValue( array $field, $field_post_value ) {
		
		if( empty( $field_post_value ) ) {
			return $field[ 'value' ];
		}
		
		if( isset( $field[ 'subtype' ] ) ) {
			if( $field[ 'subtype' ] == 'url' ) {
				$field_post_value = esc_url_raw( $field_post_value );
			}
			elseif( $field[ 'subtype' ] == 'email' ) {
				$field_post_value = sanitize_email( $field_post_value );
			}
		}
		
		return sanitize_text_field( $field_post_value );
	}
	
}
