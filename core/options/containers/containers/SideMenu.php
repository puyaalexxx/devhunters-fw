<?php
declare( strict_types = 1 );

namespace DHT\Core\Options\Containers\Containers;

use DHT\Core\Options\Containers\BaseContainer;
use DHT\DHT;
use DHT\Helpers\Classes\Environment;
use DHT\Helpers\Traits\Options\ContainerTypeTrait;

if( !defined( 'DHT_MAIN' ) ) {
	die( 'Forbidden' );
}

final class SideMenu extends BaseContainer {
	
	use ContainerTypeTrait;
	
	//field type
	protected string $_container = 'sidemenu';
	
	/**
	 * @param array $optionGroupsClasses
	 * @param array $optionTogglesClasses
	 * @param array $optionFieldsClasses
	 *
	 * @since     1.0.0
	 */
	public function __construct( array $optionGroupsClasses, array $optionTogglesClasses, array $optionFieldsClasses ) {
		
		parent::__construct( $optionGroupsClasses, $optionTogglesClasses, $optionFieldsClasses );
	}
	
	/**
	 * Enqueue input scripts and styles
	 *
	 * @param array $container
	 *
	 * @return void
	 * @since     1.0.0
	 */
	public function enqueueOptionScripts( array $container ) : void {
		
		if( Environment::isDevelopment() ) {
			wp_register_style( DHT_PREFIX_CSS . '-sidemenu-container', DHT_ASSETS_URI . 'dist/css/sidemenu.css', array(), DHT::$version );
			wp_enqueue_style( DHT_PREFIX_CSS . '-sidemenu-container' );
			
			wp_enqueue_script( DHT_PREFIX_JS . '-sidemenu-container', DHT_ASSETS_URI . 'dist/js/sidemenu.js', array( 'jquery' ), DHT::$version, true );
		}
	}
	
	/**
	 *  In this method you receive $container_value (from form submit or whatever)
	 *  and must return correct and safe value that will be stored in database.
	 *
	 *  $group_value can be null.
	 *  In this case you should return default value from $container['value']
	 *
	 * @param array $container             - container field
	 * @param mixed $container_post_values - container $_POST values passed on save
	 *
	 * @return array - changed container value
	 * @since     1.0.0
	 */
	public function saveValue( array $container, array $container_post_values ) : array {
		
		$values = [];
		// Sanitize option values
		foreach ( $container[ 'options' ] as $page ) {
			$page_options = $page[ 'options' ] ?? [];
			
			// Handle subpages if they exist
			if( isset( $page[ 'pages' ] ) ) {
				foreach ( $page[ 'pages' ] as $subpage ) {
					$subpage_options = $subpage[ 'options' ] ?? [];
					
					if( !empty( $subpage_options ) ) {
						$values = array_merge( $values, $this->_sanitizeValues( $subpage_options, $container_post_values ) );
					}
				}
			}
			else {
				if( !empty( $page_options ) ) {
					$values = array_merge( $values, $this->_sanitizeValues( $page_options, $container_post_values ) );
				}
			}
		}
		
		return $values;
	}
	
}
