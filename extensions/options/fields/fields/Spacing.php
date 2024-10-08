<?php
declare( strict_types = 1 );

namespace DHT\Extensions\Options\Fields\Fields;

use DHT\Extensions\Options\Fields\BaseField;
use DHT\Helpers\Classes\Environment;
use function DHT\dht;

if ( ! defined( 'DHT_MAIN' ) ) {
	die( 'Forbidden' );
}

final class Spacing extends BaseField {
	
	//field type
	protected string $_field = 'spacing';
	
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
			wp_register_style( DHT_PREFIX_CSS . '-spacing-field', DHT_ASSETS_URI . 'dist/css/spacing.css', array(), dht()->manifest->get( 'version' ) );
			wp_enqueue_style( DHT_PREFIX_CSS . '-spacing-field' );
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
		
		if ( empty( $field_post_value ) ) {
			return $field[ 'value' ];
		}
		
		//for the range field
		if ( is_array( $field_post_value ) ) {
			
			$field_vals = [];
			foreach ( $field_post_value as $key => $value ) {
				
				if ( $key == 'size' ) {
					
					$field_vals[ $key ] = $value;
					
					continue;
				}
				
				$field_vals[ $key ] = absint( sanitize_text_field( $value ) );
			}
			
			$field_post_value = $field_vals;
			
		}
		
		return $field_post_value;
	}
	
}
