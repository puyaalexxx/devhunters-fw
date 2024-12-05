<?php
declare( strict_types = 1 );

namespace DHT\Core\Options\Groups\Groups;

use DHT\Core\Options\Groups\BaseGroup;
use DHT\DHT;
use DHT\Helpers\Classes\Environment;
use DHT\Helpers\Traits\Options\GroupTypeTrait;

if( !defined( 'DHT_MAIN' ) ) {
	die( 'Forbidden' );
}

final class Group extends BaseGroup {
	
	use GroupTypeTrait;
	
	//group type
	protected string $_group = 'group';
	
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
		
		if( Environment::isDevelopment() ) {
			wp_register_style( DHT_PREFIX_CSS . '-group-group', DHT_ASSETS_URI . 'dist/css/group.css', array(), DHT::$version );
			wp_enqueue_style( DHT_PREFIX_CSS . '-group-group' );
		}
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
		
		if( empty( $group_post_values ) ) {
			return $group[ 'value' ];
		}
		
		//sanitize option values
		foreach ( $group[ 'options' ] as $option ) {
			
			$option_post_value = $group_post_values[ $option[ 'id' ] ] ?? [];
			
			$group_post_values = $this->_saveGroupHelper( $option, $group_post_values, $option_post_value, $this->_optionTogglesClasses, $this->_optionFieldsClasses );
		}
		
		return $group_post_values;
	}
	
}
