<?php
declare( strict_types = 1 );

namespace DHT\Core\Options\Fields\Fields;

use DHT\Core\Options\Fields\BaseField;
use DHT\DHT;
use DHT\Helpers\Classes\Environment;

if( !defined( 'DHT_MAIN' ) ) {
	die( 'Forbidden' );
}

final class Checkbox extends BaseField {
	
	//field type
	protected string $_field = 'checkbox';
	
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
			
			
			wp_register_style( DHT_PREFIX_CSS . '-checkbox-field', DHT_ASSETS_URI . 'dist/css/checkbox.css', array(), DHT::$version );
			wp_enqueue_style( DHT_PREFIX_CSS . '-checkbox-field' );
		}
	}
	
	/**
	 * merge the field value with the saved value if exists
	 *
	 * @param array $field       - field
	 * @param mixed $saved_value $saved_value - saved values
	 *
	 * @return array
	 * @since     1.0.0
	 */
	public function mergeValues( array $field, mixed $saved_value ) : array {
		
		//if saved value exists
		if( !empty( $saved_value ) ) {
			
			$values = [];
			foreach ( $field[ 'choices' ] as $checkbox ) {
				
				//if checkbox id exists in saved_values array, save it as checked value
				if( array_key_exists( $checkbox[ 'id' ], $saved_value ) ) {
					$values[] = $checkbox[ 'id' ];
				}
			}
			
			$field[ 'value' ] = $values;
			
		} /*elseif ( empty($saved_value) && $field['id'] ) {
            $field[ 'value' ] = [];
        }*/
		
		return $field;
	}
	
}