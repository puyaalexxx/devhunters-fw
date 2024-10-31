<?php
declare( strict_types = 1 );

namespace DHT\Core\Options\Toggles\Toggles;

use DHT\Core\Options\Toggles\BaseToggle;
use DHT\DHT;
use DHT\Helpers\Classes\Environment;
use function DHT\Helpers\dht_load_view;

if( !defined( 'DHT_MAIN' ) ) {
	die( 'Forbidden' );
}

final class Toggle extends BaseToggle {
	
	//toggle type
	protected string $_toggle = 'toggle';
	
	/**
	 * @param array $registered_fields
	 *
	 * @since     1.0.0
	 */
	public function __construct( array $registered_fields ) {
		
		parent::__construct( $registered_fields );
	}
	
	/**
	 * Enqueue input scripts and styles
	 *
	 * @param array $toggle
	 *
	 * @return void
	 * @since     1.0.0
	 */
	public function enqueueOptionScripts( array $toggle ) : void {
		
		if( Environment::isDevelopment() ) {
			wp_register_style( DHT_PREFIX_CSS . '-toggle-toggle', DHT_ASSETS_URI . 'dist/css/toggle.css', array(), DHT::$version );
			wp_enqueue_style( DHT_PREFIX_CSS . '-toggle-toggle' );
			
			wp_enqueue_script_module( DHT_PREFIX_JS . '-toggle-toggle', DHT_ASSETS_URI . 'dist/js/toggle.js', array( 'jquery' ), DHT::$version, true );
		}
	}
	
	/**
	 * return toggle template
	 *
	 * @param array  $toggle
	 * @param mixed  $saved_values
	 * @param string $options_id
	 * @param array  $additional_args
	 *
	 * @return string
	 * @since     1.0.0
	 */
	public function render( array $toggle, mixed $saved_values, string $options_id, array $additional_args = [] ) : string {
		
		//merge default values with saved ones to display the saved ones
		$toggle = $this->mergeValues( $toggle, $saved_values );
		
		//add toggle prefix id
		$toggle = parent::addIDPrefix( $toggle, $options_id );
		
		
		return dht_load_view( $this->template_dir, $this->getToggle() . '.php', [
			'toggle'            => $toggle,
			'saved_values'      => $saved_values,
			'registered_fields' => $this->_registeredFields,
			'additional_args'   => $additional_args
		] );
	}
	
	/**
	 * merge the toggle value with the saved values if exists
	 *
	 * @param array $toggle       - toggle field
	 * @param mixed $saved_values - saved values
	 *
	 * @return mixed
	 * @since     1.0.0
	 */
	public function mergeValues( array $toggle, mixed $saved_values ) : array {
		
		$toggle[ 'value' ] = empty( $saved_values[ 'value' ] ) ? $toggle[ 'value' ] : $saved_values[ 'value' ];
		
		return $toggle;
	}
	
	/**
	 *  In this method you receive $toggle_value (from form submit or whatever)
	 *  and must return correct and safe value that will be stored in database.
	 *
	 *  $toggle_value can be null.
	 *  In this case you should return default value from $toggle['value']
	 *
	 * @param array $toggle             - toggle field
	 * @param mixed $toggle_post_values - $_POST values passed on save
	 *
	 * @return mixed - changed toggle value
	 * @since     1.0.0
	 */
	public function saveValue( array $toggle, mixed $toggle_post_values ) : mixed {
		
		if( empty( $toggle_post_values ) ) {
			return $toggle[ 'value' ];
		}
		
		//sanitize option values
		if( !empty( $toggle[ 'left-choice' ][ 'options' ] ) ) {
			
			$toggle_post_values = $this->_sanitize_values( $toggle, 'left-choice', $toggle_post_values, $this->_registeredFields );
		}
		
		if( !empty( $toggle[ 'right-choice' ][ 'options' ] ) ) {
			
			$toggle_post_values = $this->_sanitize_values( $toggle, 'right-choice', $toggle_post_values, $this->_registeredFields );
		}
		
		return $toggle_post_values;
	}
	
	/**
	 * sanitize toggle field values
	 *
	 * @param array  $toggle             - toggle field
	 * @param string $choice             - choice setitng
	 * @param array  $toggle_post_values - $_POST values passed on save
	 * @param array  $option_classes     - registered field classes
	 *
	 * @return mixed - changed toggle value
	 * @since     1.0.0
	 */
	private function _sanitize_values( array $toggle, string $choice, array $toggle_post_values, array $option_classes ) : array {
		
		foreach ( $toggle[ $choice ][ 'options' ] as $option ) {
			
			$option_post_value = $toggle_post_values[ $choice ][ $option[ 'id' ] ] ?? [];
			
			$toggle_post_values[ $choice ][ $option[ 'id' ] ] = $option_classes[ $option[ 'type' ] ]->saveValue( $option, $option_post_value );
		}
		
		return $toggle_post_values;
	}
	
}
