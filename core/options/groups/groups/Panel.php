<?php
declare( strict_types = 1 );

namespace DHT\Core\Options\Groups\Groups;

use DHT\Core\Options\Groups\BaseGroup;
use DHT\DHT;
use DHT\Helpers\Classes\Environment;

if( !defined( 'DHT_MAIN' ) ) {
	die( 'Forbidden' );
}

final class Panel extends BaseGroup {
	
	//group type
	protected string $_group = 'panel';
	
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
			wp_register_style( DHT_PREFIX_CSS . '-panel-group', DHT_ASSETS_URI . 'dist/css/panel.css', array(), DHT::$version );
			wp_enqueue_style( DHT_PREFIX_CSS . '-panel-group' );
			
			wp_enqueue_script( DHT_PREFIX_JS . '-panel-group', DHT_ASSETS_URI . 'dist/js/panel.js', array( 'jquery' ), DHT::$version, true );
		}
	}
	
}
