<?php
declare( strict_types = 1 );

namespace DHT\Core\Options\Groups;

use DHT\Helpers\Traits\Options\GroupTypeTrait;
use function DHT\Helpers\dht_load_view;

if( !defined( 'DHT_MAIN' ) ) {
	die( 'Forbidden' );
}

abstract class BaseGroup {
	
	use GroupTypeTrait;
	
	//groups views directory
	protected string $template_dir = DHT_VIEWS_DIR . 'core/options/groups/';
	
	//field type
	protected string $_group = 'unknown';
	
	//registered toggle classes
	protected array $_optionFieldsClasses;
	
	//registered field classes
	protected array $_optionTogglesClasses;
	
	/**
	 * @param array $optionTogglesClasses
	 * @param array $optionFieldsClasses
	 *
	 * @since     1.0.0
	 */
	public function __construct( array $optionTogglesClasses, array $optionFieldsClasses ) {
		
		$this->_optionTogglesClasses = $optionTogglesClasses;
		$this->_optionFieldsClasses  = $optionFieldsClasses;
	}
	
	/**
	 *
	 * return group type
	 *
	 * @return string
	 * @since     1.0.0
	 */
	public function getGroup() : string {
		
		return $this->_group;
	}
	
	/**
	 * Method used to pass the $group array option to enqueue method (enqueueOptionScripts)
	 * This is done to have access to the $group option inside the enqueue method
	 *
	 * @param array $group
	 *
	 * @return void
	 * @since     1.0.0
	 */
	public function enqueueOptionScriptsHook( array $group ) : void {
		
		add_action( 'admin_enqueue_scripts', function() use ( $group ) {
			$this->enqueueOptionScripts( $group );
		} );
	}
	
	/**
	 * Enqueue the group scripts and css files
	 *
	 * @param array $group
	 *
	 * @return void
	 * @since     1.0.0
	 */
	protected abstract function enqueueOptionScripts( array $group ) : void;
	
	/**
	 * return group template
	 *
	 * @param array  $group
	 * @param mixed  $saved_values
	 * @param string $options_id
	 * @param array  $additional_args
	 *
	 * @return string
	 * @since     1.0.0
	 */
	public function render( array $group, mixed $saved_values, string $options_id, array $additional_args = [] ) : string {
		
		//merge default values with saved ones to display the saved ones
		$group[ 'value' ] = $this->mergeValues( $group[ "value" ] ?? [], $saved_values );
		
		//add group prefix id
		$group = $this->addIDPrefix( $group, $options_id );
		
		return dht_load_view( $this->template_dir, $this->getGroup() . '.php', [
			'group'                      => $group,
			'registered_options_classes' => [
				'togglesClasses' => $this->_optionTogglesClasses,
				'fieldsClasses'  => $this->_optionFieldsClasses
			],
			'additional_args'            => $additional_args
		] );
	}
	
	/**
	 * add prefix id for the group id to display it in the form as array values
	 * (used to retrieve the $_POST['prefix_id'] values)
	 *
	 * @param array  $group
	 * @param string $options_id
	 *
	 * @return array
	 * @since     1.0.0
	 */
	public function addIDPrefix( array $group, string $options_id ) : array {
		
		if( empty( $options_id ) ) {
			return $group;
		}
		
		$group[ 'id' ] = $options_id . '[' . $group[ 'id' ] . ']';
		
		return $group;
	}
	
	/**
	 * merge the group value with the saved values if exists
	 *
	 * @param array $group_values - group values
	 * @param mixed $saved_values - saved values
	 *
	 * @return mixed
	 * @since     1.0.0
	 */
	public function mergeValues( array $group_values, mixed $saved_values ) : array {
		return empty( $saved_values ) ? $group_values : $saved_values;
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
		
		//sanitize option values
		foreach ( $group[ 'options' ] as $subgroup ) {
			foreach ( $subgroup[ 'options' ] as $option ) {
				$option_post_value = $group_post_values[ $option[ 'id' ] ] ?? [];
				
				$group_post_values = $this->_saveGroupHelper( $option, $group_post_values, $option_post_value, $this->_optionTogglesClasses, $this->_optionFieldsClasses );
			}
		}
		
		return $group_post_values;
	}
	
}