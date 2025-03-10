<?php
declare( strict_types = 1 );

namespace DHT\Core\Options\Containers;

use DHT\Helpers\Traits\Options\ContainerTypeTrait;
use function DHT\Helpers\dht_load_view;

if( !defined( 'DHT_MAIN' ) ) {
	die( 'Forbidden' );
}

abstract class BaseContainer {
	
	use ContainerTypeTrait;
	
	//options views directory
	protected string $template_dir = DHT_VIEWS_DIR . 'core/options/containers/';
	
	//field type
	protected string $_container = 'unknown';
	
	//registered toggles classes
	protected array $_optionGroupsClasses;
	
	//registered option classes
	protected array $_optionTogglesClasses;
	
	//registered field classes
	protected array $_optionFieldsClasses;
	
	/**
	 * @param array $optionGroupsClasses
	 * @param array $optionTogglesClasses
	 * @param array $optionFieldClasses
	 *
	 * @since     1.0.0
	 */
	public function __construct( array $optionGroupsClasses, array $optionTogglesClasses, array $optionFieldClasses ) {
		
		$this->_optionGroupsClasses  = $optionGroupsClasses;
		$this->_optionTogglesClasses = $optionTogglesClasses;
		$this->_optionFieldsClasses  = $optionFieldClasses;
	}
	
	/**
	 *
	 * return container type
	 *
	 * @return string
	 * @since     1.0.0
	 */
	public function getContainer() : string {
		
		return $this->_container;
	}
	
	/**
	 * Method used to pass the $container array option to enqueue method (enqueueOptionScripts)
	 * This is done to have access to the $container option inside the enqueue method
	 *
	 * @param array $container
	 *
	 * @return void
	 * @since     1.0.0
	 */
	public function enqueueOptionScriptsHook( array $container ) : void {
		
		add_action( 'admin_enqueue_scripts', function() use ( $container ) {
			$this->enqueueOptionScripts( $container );
		} );
	}
	
	/**
	 * Enqueue the container scripts and css files
	 *
	 * @param array $container
	 *
	 * @return void
	 * @since     1.0.0
	 */
	protected abstract function enqueueOptionScripts( array $container ) : void;
	
	/**
	 * return container template
	 *
	 * @param array $container - container option array
	 * @param array $saved_values
	 * @param array $additional_args
	 *
	 * @return string
	 * @since     1.0.0
	 */
	public function render( array $container, array $saved_values, array $additional_args = [] ) : string {
		
		//merge default values with saved ones to display the saved ones
		$container[ 'value' ] = $this->mergeValues( $containe[ "value" ] ?? [], $saved_values );
		
		$registered_options_classes = [
			'groupsClasses'  => $this->_optionGroupsClasses,
			'togglesClasses' => $this->_optionTogglesClasses,
			'fieldsClasses'  => $this->_optionFieldsClasses
		];
		
		return dht_load_view( $this->template_dir, $this->getContainer() . '.php', [
			'container'                  => $container,
			'registered_options_classes' => $registered_options_classes,
			'additional_args'            => $additional_args
		] );
	}
	
	/**
	 * merge the container values with the saved values if exists
	 *
	 * @param array $container_values - container values
	 * @param mixed $saved_values     - saved values
	 *
	 * @return mixed
	 * @since     1.0.0
	 */
	public function mergeValues( array $container_values, $saved_values ) : array {
		return empty( $saved_values ) ? $container_values : $saved_values;
	}
	
	/**
	 *  In this method you receive $container_value (from form submit or whatever)
	 *  and must return correct and safe value that will be stored in database.
	 *
	 *  $group_value can be null.
	 *  In this case you should return default value from $container['value']
	 *
	 * @param array $container             - container field
	 * @param array $container_post_values - container $_POST values passed on save
	 *
	 * @return array - changed container value
	 * @since     1.0.0
	 */
	public function saveValue( array $container, array $container_post_values ) : array {
		
		return $this->_sanitizeValues( $container[ 'options' ], $container_post_values );
	}
	
}