<?php
declare( strict_types = 1 );

namespace DHT\Core\Options\Groups\Groups;

use DHT\Core\Options\Groups\BaseGroup;
use DHT\DHT;
use DHT\Helpers\Classes\Environment;
use DHT\Helpers\Classes\OptionsHelpers;

if( !defined( 'DHT_MAIN' ) ) {
	die( 'Forbidden' );
}

final class AddableBox extends BaseGroup {
	
	//group type
	protected string $_group = 'addable-box';
	
	//group option
	private array $_groupOptions = [];
	
	/**
	 * @param array $optionTogglesClasses
	 * @param array $optionFieldsClasses
	 *
	 * @since     1.0.0
	 */
	public function __construct( array $optionTogglesClasses, array $optionFieldsClasses ) {
		
		$this->_optionTogglesClasses = $optionTogglesClasses;
		$this->_optionFieldsClasses  = $optionFieldsClasses;
		
		parent::__construct( $optionTogglesClasses, $optionFieldsClasses );
		
		add_action( 'wp_ajax_getAddableBoxOptions', [ $this, 'getAddableBoxOptions' ] );
		add_action( 'wp_ajax_nopriv_getAddableBoxOptions', [
			$this,
			'getAddableBoxOptions'
		] ); // For non-logged in users
	}
	
	/**
	 * Enqueue input scripts and styles
	 *
	 * @param array $group
	 *
	 * @return void
	 * @since     1.0.0
	 */
	public function enqueueOptionScripts( array $group ) : void {
		
		$deps = [ 'jquery' ];
		
		// Enqueue the WordPress editor scripts and styles
		wp_enqueue_editor();
		
		if( $group[ 'sortable' ] ) {
			$deps = [ 'jquery', 'jquery-ui-sortable' ];
			wp_enqueue_script( 'jquery-ui-sortable' );
		}
		
		if( Environment::isDevelopment() ) {
			wp_register_style( DHT_PREFIX_CSS . '-addable-box-group', DHT_ASSETS_URI . 'dist/css/addable-box.css', array(), DHT::$version );
			wp_enqueue_style( DHT_PREFIX_CSS . '-addable-box-group' );
			
			wp_enqueue_script_module( DHT_PREFIX_JS . '-addable-box-group', DHT_ASSETS_URI . 'dist/js/addable-box.js', $deps, DHT::$version );
		}
	}
	
	/**
	 * ajax action to retrieve all options and add them to their box item
	 *
	 * @return void
	 * @since     1.0.0
	 */
	public function getAddableBoxOptions() : void {
		
		if( isset( $_POST[ 'action' ] ) && $_POST[ 'action' ] == "getAddableBoxOptions" && isset( $_POST[ 'data' ][ 'box_number' ] ) && isset( $_POST[ 'data' ][ 'group' ] ) ) {
			
			//retrieve box number
			$box_number = !empty( $_POST[ 'data' ][ 'box_number' ] ) ? (int) $_POST[ 'data' ][ 'box_number' ] : 0;
			$group      = !empty( $_POST[ 'data' ][ 'group' ] ) ? json_decode( stripslashes( html_entity_decode( $_POST[ 'data' ][ 'group' ], ENT_QUOTES, 'UTF-8' ) ), true ) : [];
			
			ob_start();
			
			if( !empty( $group ) ) {
				echo OptionsHelpers::renderBoxItemContent( $group, [], [
					'togglesClasses' => $this->_optionTogglesClasses,
					'fieldsClasses'  => $this->_optionFieldsClasses
				], $box_number );
			}
			else {
				echo _x( 'No options available', 'options', 'dht' );
			}
			
			$content = ob_get_clean();
			
			wp_send_json_success( $content );
			
		}
		else {
			wp_send_json_success( _x( 'Something went wrong, please refresh the page', 'options', 'dht' ) );
		}
		
		die();
	}
	
	/**
	 *  In this method you receive $group_value (from form submit or whatever)
	 *  and must return correct and safe value that will be stored in database.
	 *
	 *  $group_value can be null.
	 *  In this case you should return default value from $group['value']
	 *
	 * @param array $group             - group option
	 * @param array $group_post_values - $_POST values passed on save
	 *
	 * @return array - sanitized group values
	 * @since     1.0.0
	 */
	public function saveValue( array $group, array $group_post_values ) : array {
		
		if( empty( $group[ 'options' ] ) ) {
			return [];
		}
		
		$sanitized_values = $options = [];
		
		// flatten options array to make it easier to access options by ID
		foreach ( $group[ 'options' ] as $option ) {
			$options[ $option[ 'id' ] ] = $option;
		}
		
		//return the addable box default option values
		if( empty( $group_post_values ) ) {
			//for default values, there will always be only one box
			$box_number = 0;
			
			//box title value
			$sanitized_values[ $box_number ][ 'box-title' ] = $group[ "box-title" ] ?? "";
			
			foreach ( $options as $option ) {
				if( array_key_exists( $option[ 'type' ], $this->_optionTogglesClasses ) ) {
					$sanitized_values[ $box_number ] [ $option[ 'id' ] ] = $this->_optionTogglesClasses[ $option[ 'type' ] ]->saveValue( $option, $option[ 'value' ] );
				} //if it is a field option type
				else {
					$sanitized_values[ $box_number ] [ $option[ 'id' ] ] = $this->_optionFieldsClasses[ $option[ 'type' ] ]->saveValue( $option, $option[ 'value' ] );
				}
			}
		}
		else {
			//go through all the saved values and sanitize them
			foreach ( $group_post_values as $value_key => $values ) {
				foreach ( $values as $option_id => $value ) {
					//the box title, it is not located in the options array so we need to sanitize it separately
					if( $option_id == 'box-title' ) {
						$sanitized_values[ $value_key ] [ 'box-title' ] = sanitize_text_field( $value );
						continue;
					}
					
					if( isset( $options[ $option_id ] ) ) {
						if( array_key_exists( $options[ $option_id ][ 'type' ], $this->_optionTogglesClasses ) ) {
							$sanitized_values[ $value_key ] [ $option_id ] = $this->_optionTogglesClasses[ $options[ $option_id ][ 'type' ] ]->saveValue( $options[ $option_id ], $value );
						} //if it is a field option type
						else {
							$sanitized_values[ $value_key ] [ $option_id ] = $this->_optionFieldsClasses[ $options[ $option_id ][ 'type' ] ]->saveValue( $options[ $option_id ], $value );
						}
					}
				}
			}
		}
		
		return $sanitized_values;
	}
	
}
