<?php
declare( strict_types = 1 );

namespace DHT\Extensions\Options\Options\Fields;

use DHT\Extensions\Options\Options\BaseField;
use DHT\Helpers\Classes\Environment;
use function DHT\dht;

if ( ! defined( 'DHT_MAIN' ) ) {
	die( 'Forbidden' );
}

final class Borders extends BaseField {
	
	//field type
	protected string $_field = 'borders';
	
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
		
		if ( Environment::isDevelopment() ) {
			wp_register_style( DHT_PREFIX_CSS . '-borders-field', DHT_ASSETS_URI . 'dist/css/borders.css', array(), dht()->manifest->get( 'version' ) );
			wp_enqueue_style( DHT_PREFIX_CSS . '-borders-field' );
			
			wp_enqueue_script_module( DHT_PREFIX_JS . '-wp-color-picker-field', DHT_ASSETS_URI . 'dist/js/borders.js', array(
				'jquery',
				'wp-color-picker'
			), dht()->manifest->get( 'version' ) );
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
		
		if ( empty( $field_post_value ) ) {
			return $field[ 'value' ];
		}
		
		//for the range field
		if ( is_array( $field_post_value ) ) {
			
			$field_vals = [];
			foreach ( $field_post_value as $key => $value ) {
				
				if ( $key == 'style' || $key == 'color' ) {
					
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
