<?php
declare( strict_types = 1 );

namespace DHT\Core\Options\Fields;

use function DHT\Helpers\dht_load_view;

if( !defined( 'DHT_MAIN' ) ) {
	die( 'Forbidden' );
}

abstract class BaseField {
	
	//fields views directory
	protected string $template_dir = DHT_VIEWS_DIR . 'core/options/fields/';
	
	//field type
	protected string $_field = 'unknown';
	
	/**
	 * @since     1.0.0
	 */
	public function __construct() {}
	
	/**
	 *
	 * return field type
	 *
	 * @return string
	 * @since     1.0.0
	 */
	public function getField() : string {
		
		return $this->_field;
	}
	
	/**
	 * Method used to pass the $field array option to enqueue method (enqueueOptionScripts)
	 * This is done to have access to the $field option inside the enqueue method
	 *
	 * @param array $field
	 *
	 * @return void
	 * @since     1.0.0
	 */
	public function enqueueOptionScriptsHook( array $field ) : void {
		add_action( 'admin_enqueue_scripts', function() use ( $field ) {
			$this->enqueueOptionScripts( $field );
		} );
	}
	
	/**
	 * Enqueue the field scripts and css files
	 *
	 * @param array $field
	 *
	 * @return void
	 * @since     1.0.0
	 */
	protected abstract function enqueueOptionScripts( array $field ) : void;
	
	/**
	 * return field view
	 *
	 * @param array  $field
	 * @param mixed  $saved_value
	 * @param string $options_id
	 * @param array  $additional_args
	 *
	 * @return string
	 * @since     1.0.0
	 */
	public function render( array $field, mixed $saved_value, string $options_id, array $additional_args = [] ) : string {
		
		//merge default values with saved ones to display the saved ones
		$field = $this->mergeValues( $field, $saved_value );
		
		//add option prefix id
		$field = $this->addIDPrefix( $field, $options_id );
		
		//render the respective option type
		return dht_load_view( $this->template_dir, $this->getField() . '.php', [
			'field'           => $field,
			'additional_args' => $additional_args
		] );
	}
	
	/**
	 * add prefix id for field id to display it in the form as array values
	 * (used to retrieve the $_POST['prefix_id'] values)
	 *
	 * @param array  $field
	 * @param string $options_id
	 *
	 * @return array
	 * @since     1.0.0
	 */
	public function addIDPrefix( array $field, string $options_id ) : array {
		
		if( empty( $options_id ) ) {
			return $field;
		}
		
		$field[ 'id' ] = $options_id . '[' . $field[ 'id' ] . ']';
		
		return $field;
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
	public function mergeValues( array $field, mixed $saved_value ) : array {
		
		$field[ 'value' ] = empty( $saved_value ) ? $field[ 'value' ] : $saved_value;
		
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
	 * @return mixed - changed field value
	 * @since     1.0.0
	 */
	public function saveValue( array $field, mixed $field_post_value ) : mixed {
		
		if( empty( $field_post_value ) ) {
			return $field[ 'value' ];
		}
		
		return $field_post_value;
	}
	
}