<?php
declare( strict_types = 1 );

namespace DHT\Extensions\Options\Containers\Containers;

use DHT\Extensions\Options\Containers\BaseContainer;
use function DHT\fw;

if ( !defined( 'DHT_MAIN' ) ) die( 'Forbidden' );

final class SideMenu extends BaseContainer {
    
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
        
        wp_register_style( DHT_PREFIX . '-sidemenu-container', DHT_ASSETS_URI . 'styles/css/extensions/options/containers/sidemenu-style.css', array(), fw()->manifest->get( 'version' ) );
        wp_enqueue_style( DHT_PREFIX . '-sidemenu-container' );
        
        wp_enqueue_script( DHT_PREFIX . '-sidemenu-container', DHT_ASSETS_URI . 'scripts/js/extensions/options/containers/sidemenu-script.js', array( 'jquery' ), fw()->manifest->get( 'version' ), true );
    }
    
}
