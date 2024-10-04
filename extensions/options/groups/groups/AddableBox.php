<?php
declare( strict_types = 1 );

namespace DHT\Extensions\Options\Groups\Groups;

use DHT\Extensions\Options\Groups\BaseGroup;
use DHT\Helpers\Classes\Environment;
use function DHT\dht;
use function DHT\Helpers\dht_fw_render_box_item_content;

if ( ! defined( 'DHT_MAIN' ) ) {
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
		
		add_action( 'wp_ajax_getBoxOptions', [ $this, 'getBoxOptions' ] );
		add_action( 'wp_ajax_nopriv_getBoxOptions', [ $this, 'getBoxOptions' ] ); // For non-logged in users
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
		
		// Enqueue the WordPress editor scripts and styles
		wp_enqueue_editor();
		
		if ( Environment::isDevelopment() ) {
			wp_register_style( DHT_PREFIX_CSS . '-addable-box-group', DHT_ASSETS_URI . 'dist/css/addable-box.css', array(), dht()->manifest->get( 'version' ) );
			wp_enqueue_style( DHT_PREFIX_CSS . '-addable-box-group' );
			
			wp_enqueue_script( DHT_PREFIX_JS . '-addable-box-group', DHT_ASSETS_URI . 'dist/js/addable-box.js', array(
				'jquery',
				'jquery-ui-sortable'
			), dht()->manifest->get( 'version' ), true );
		}
	}
	
	/**
	 * ajax action to retrieve all options and add them to ther box item
	 *
	 * @return void
	 * @since     1.0.0
	 */
	public function getBoxOptions() : void {
		
		if ( isset( $_POST[ 'data' ][ 'box_number' ] ) && isset( $_POST[ 'data' ][ 'group' ] ) ) {
			
			//retrieve box number
			$box_number = ! empty( $_POST[ 'data' ][ 'box_number' ] ) ? (int) $_POST[ 'data' ][ 'box_number' ] : 0;
			$group      = ! empty( $_POST[ 'data' ][ 'group' ] ) ? json_decode( stripslashes( html_entity_decode( $_POST[ 'data' ][ 'group' ], ENT_QUOTES, 'UTF-8' ) ), true ) : [];
			
			ob_start();
			
			if ( ! empty( $group ) ) {
				echo dht_fw_render_box_item_content( $group, [], [
					'togglesClasses' => $this->_optionTogglesClasses,
					'fieldsClasses'  => $this->_optionFieldsClasses
				], _x( 'Box Title', 'options', DHT_PREFIX ), $box_number );
			} else {
				echo _x( 'No options available', 'options', DHT_PREFIX );
			}
			
			$content = ob_get_clean();
			
			wp_send_json_success( $content );
			
		} else {
			wp_send_json_success( _x( 'Something went wrong, please refresh the page', 'options', DHT_PREFIX ) );
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
	 * @param mixed $group_post_values - $_POST values passed on save
	 *
	 * @return mixed - sanitized group values
	 * @since     1.0.0
	 */
	public function saveValue( array $group, mixed $group_post_values ) : mixed {
		
		if ( empty( $group_post_values ) || empty( $group[ 'options' ] ) ) {
			return $group[ 'value' ];
		}
		
		$sanitized_values = [];
		
		// Flatten options array to make it easier to access options by ID
		$options = [];
		foreach ( $group[ 'options' ] as $option ) {
			
			$options[ $option[ 'id' ] ] = $option;
		}
		
		//go through all the saved values and sanitize them
		foreach ( $group_post_values as $value_key => $values ) {
			
			foreach ( $values as $option_id => $value ) {
				
				//the box title, it is not located in the options array so we need to sanitize it separately
				if ( $option_id == 'box-title' ) {
					
					$sanitized_values[ $value_key ] [ 'box-title' ] = sanitize_text_field( $value );
					
					continue;
				}
				
				if ( isset( $options[ $option_id ] ) ) {
					
					if ( array_key_exists( $options[ $option_id ][ 'type' ], $this->_optionTogglesClasses ) ) {
						$sanitized_values[ $value_key ] [ $option_id ] = $this->_optionTogglesClasses[ $options[ $option_id ][ 'type' ] ]->saveValue( $options[ $option_id ], $value );
					} //if it is a field option type
					else {
						$sanitized_values[ $value_key ] [ $option_id ] = $this->_optionFieldsClasses[ $options[ $option_id ][ 'type' ] ]->saveValue( $options[ $option_id ], $value );
					}
				}
			}
		}
		
		return $sanitized_values;
	}
	
}
