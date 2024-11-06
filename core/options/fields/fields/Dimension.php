<?php
declare( strict_types = 1 );

namespace DHT\Core\Options\Fields\Fields;

use DHT\Core\Options\Fields\BaseField;
use DHT\DHT;
use DHT\Helpers\Classes\Environment;

if( !defined( 'DHT_MAIN' ) ) {
	die( 'Forbidden' );
}

final class Dimension extends BaseField {
	
	//field type
	protected string $_field = 'dimension';
	
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
		
		wp_enqueue_style( 'wp-color-picker' );
		wp_enqueue_script( 'wp-color-picker' );
		
		if( Environment::isDevelopment() ) {
			wp_register_style( DHT_PREFIX_CSS . '-dimension-field', DHT_ASSETS_URI . 'dist/css/dimension.css', array(), DHT::$version );
			wp_enqueue_style( DHT_PREFIX_CSS . '-dimension-field' );
			
			wp_enqueue_script_module( DHT_PREFIX_JS . '-wp-color-picker-field-dimension', DHT_ASSETS_URI . 'dist/js/dimension.js', array(
				'jquery',
				'wp-color-picker'
			), DHT::$version );
		}
	}
	
	/**
	 *  In this method you receive $field_post_value (from form submit or whatever)
	 *  and must return correct and safe value that will be stored in database.
	 *
	 *  $field_post_value can be null.
	 *  In this case you should return default value from $field['value']
	 *
	 * @param array $field            - option field
	 * @param mixed $field_post_value - option $_POST value passed on save
	 *
	 * @return mixed - changed option value
	 * @since     1.0.0
	 */
	public function saveValue( array $field, mixed $field_post_value ) : mixed {
		
		if( empty( $field_post_value ) ) {
			return $field[ 'value' ];
		}
		
		//for the range field
		if( is_array( $field_post_value ) ) {
			
			$field_vals = [];
			foreach ( $field_post_value as $key => $value ) {
				
				if( $key == 'border-style' || $key == 'color' || $key == 'unit' ) {
					
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
