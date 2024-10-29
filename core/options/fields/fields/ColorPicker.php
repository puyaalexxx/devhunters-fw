<?php
declare( strict_types = 1 );

namespace DHT\Core\Options\Fields\Fields;

use DHT\Core\Options\Fields\BaseField;
use DHT\DHT;
use DHT\Helpers\Classes\Environment;
use function DHT\Helpers\dht_make_script_as_module_type;

if( !defined( 'DHT_MAIN' ) ) {
	die( 'Forbidden' );
}

final class ColorPicker extends BaseField {
	
	//field type
	protected string $_field = 'colorpicker';
	
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
			wp_register_style( DHT_PREFIX_CSS . '-wp-color-picker-field', DHT_ASSETS_URI . 'dist/css/colorpicker.css', array(), DHT::$version );
			wp_enqueue_style( DHT_PREFIX_CSS . '-wp-color-picker-field' );
			
			//make colorpicker.js to load as a module
			add_filter( 'script_loader_tag', function( string $tag, string $handle ) : string {
				return dht_make_script_as_module_type( $tag, $handle, [
					DHT_PREFIX_JS . '-wp-color-picker-field',
				] );
			}, 10, 2 );
		}
		
		//include this script only if the option type is rgba
		if( $field[ 'subtype' ] == 'rgba' ) {
			//library js
			wp_enqueue_script( DHT_PREFIX_JS . '-wp-color-picker-option-alpha-field', DHT_ASSETS_URI . 'scripts/libraries/wp-color-picker-alpha.min.js', array(
				'jquery',
				'wp-color-picker'
			), DHT::$version, true );
			
			if( Environment::isDevelopment() ) {
				wp_enqueue_script( DHT_PREFIX_JS . '-wp-color-picker-field', DHT_ASSETS_URI . 'dist/js/colorpicker.js', array(
					'jquery',
					'wp-color-picker',
					DHT_PREFIX_JS . '-wp-color-picker-option-alpha-field'
				), DHT::$version, true );
			}
		}
		else {
			if( Environment::isDevelopment() ) {
				wp_enqueue_script( DHT_PREFIX_JS . '-wp-color-picker-field', DHT_ASSETS_URI . 'dist/js/colorpicker.js', array(
					'jquery',
					'wp-color-picker'
				), DHT::$version, true );
			}
		}
	}
	
}