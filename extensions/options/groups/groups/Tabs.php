<?php
declare( strict_types = 1 );

namespace DHT\Extensions\Options\Groups\Groups;

use DHT\Extensions\Options\Groups\BaseGroup;
use DHT\Helpers\Classes\Environment;
use function DHT\dht;

if ( ! defined( 'DHT_MAIN' ) ) {
	die( 'Forbidden' );
}

final class Tabs extends BaseGroup {
	
	//group type
	protected string $_group = 'tabs';
	
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
		
		if ( Environment::isDevelopment() ) {
			wp_register_style( DHT_PREFIX_CSS . '-tabs-group', DHT_ASSETS_URI . 'dist/css/tabs.css', array(), dht()->manifest->get( 'version' ) );
			wp_enqueue_style( DHT_PREFIX_CSS . '-tabs-group' );
			
			wp_enqueue_script( DHT_PREFIX_JS . '-tabs-group', DHT_ASSETS_URI . 'dist/js/tabs.js', array( 'jquery' ), dht()->manifest->get( 'version' ), true );
		}
	}
	
}
