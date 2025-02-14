<?php
declare( strict_types = 1 );

namespace DHT\Core\Options\Toggles;

use function DHT\Helpers\dht_load_view;

if( !defined( 'DHT_MAIN' ) ) {
	die( 'Forbidden' );
}

abstract class BaseToggle {
	
	//toggles views directory
	protected string $template_dir = DHT_VIEWS_DIR . 'core/options/toggles/';
	
	//toggle type
	protected string $_toggle = 'unknown';
	
	//registered field classes
	protected array $_registeredFields;
	
	/**
	 * @param array $registered_fields
	 *
	 * @since     1.0.0
	 */
	public function __construct( array $registered_fields ) {
		
		$this->_registeredFields = $registered_fields;
	}
	
	/**
	 *
	 * return toggle type
	 *
	 * @return string
	 * @since     1.0.0
	 */
	public function getToggle() : string {
		
		return $this->_toggle;
	}
	
	/**
	 * Method used to pass the $toggle array option to enqueue method (enqueueOptionScripts)
	 * This is done to have access to the $toggle option inside the enqueue method
	 *
	 * @param array $toggle
	 *
	 * @return void
	 * @since     1.0.0
	 */
	public function enqueueOptionScriptsHook( array $toggle ) : void {
		
		add_action( 'admin_enqueue_scripts', function() use ( $toggle ) {
			$this->enqueueOptionScripts( $toggle );
		} );
	}
	
	/**
	 * Enqueue the toggle scripts and css files
	 *
	 * @param array $toggle
	 *
	 * @return void
	 * @since     1.0.0
	 */
	protected abstract function enqueueOptionScripts( array $toggle ) : void;
	
	/**
	 * return toggle template
	 *
	 * @param array  $toggle
	 * @param array  $saved_values
	 * @param string $options_id
	 * @param array  $additional_args
	 *
	 * @return string
	 * @since     1.0.0
	 */
	public function render( array $toggle, array $saved_values, string $options_id, array $additional_args = [] ) : string {
		
		//merge default values with saved ones to display the saved ones
		$toggle = $this->mergeValues( $toggle, $saved_values );
		
		//add toggle prefix id
		$toggle = $this->addIDPrefix( $toggle, $options_id );
		
		return dht_load_view( $this->template_dir, $this->getToggle() . '.php', [
			'toggle'            => $toggle,
			'registered_fields' => $this->_registeredFields,
			'additional_args'   => $additional_args
		] );
	}
	
	/**
	 * add prefix id for the toggle id to display it in the form as array values
	 * (used to retrieve the $_POST['prefix_id'] values)
	 *
	 * @param array  $toggle
	 * @param string $options_id
	 *
	 * @return array
	 * @since     1.0.0
	 */
	public function addIDPrefix( array $toggle, string $options_id ) : array {
		
		if( empty( $options_id ) ) {
			return $toggle;
		}
		
		$toggle[ 'id' ] = $options_id . '[' . $toggle[ 'id' ] . ']';
		
		return $toggle;
	}
	
	/**
	 * merge the toggle value with the saved values if exists
	 *
	 * @param array $toggle       - toggle field
	 * @param array $saved_values - saved values
	 *
	 * @return mixed
	 * @since     1.0.0
	 */
	public function mergeValues( array $toggle, array $saved_values ) : array {
		
		$toggle[ 'value' ] = empty( $saved_values ) ? $toggle[ 'value' ] : $saved_values;
		
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
	 * @param array $toggle_post_values - $_POST values passed on save
	 *
	 * @return array - changed toggle value
	 * @since     1.0.0
	 */
	public function saveValue( array $toggle, array $toggle_post_values ) : array {
		
		//sanitize option values
		foreach ( $toggle[ 'options' ] as $subtoggle ) {
			foreach ( $subtoggle[ 'options' ] as $option ) {
				$option_post_value = $toggle_post_values[ $option[ 'id' ] ] ?? [];
				
				$toggle_post_values[ $option[ 'id' ] ] = $this->_registeredFields[ $option[ 'type' ] ]->saveValue( $option, $option_post_value );
			}
		}
		
		return $toggle_post_values;
	}
	
}