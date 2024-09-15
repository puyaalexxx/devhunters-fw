<?php
declare( strict_types = 1 );

namespace DHT\Extensions\Options\Containers\Containers;

use DHT\Extensions\Options\Containers\BaseContainer;
use DHT\Helpers\Classes\Environment;
use DHT\Helpers\Traits\Options\ContainerTypeHelpers;
use function DHT\fw;

if( !defined( 'DHT_MAIN' ) ) die( 'Forbidden' );

final class TabsMenu extends BaseContainer {
    
    use ContainerTypeHelpers;
    
    //field type
    protected string $_container = 'tabsmenu';
    
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
            wp_register_style( DHT_PREFIX_CSS . '-tabsmenu-container', DHT_ASSETS_URI . 'styles/css/tabsmenu.css', array(), fw()->manifest->get( 'version' ) );
            wp_enqueue_style( DHT_PREFIX_CSS . '-tabsmenu-container' );
            
            wp_enqueue_script( DHT_PREFIX_JS . '-tabsmenu-container', DHT_ASSETS_URI . 'scripts/js/tabsmenu.js', array( 'jquery' ), fw()->manifest->get( 'version' ), true );
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
    public function saveValue( array $container, mixed $container_post_values ) : array {
        
        // Return early if container_post_values is empty
        if( empty( $container_post_values ) ) {
            return [];
        }
        
        $values = [];
        // Sanitize option values
        foreach( $container[ 'options' ] as $page ) {
            $page_options = $page[ 'options' ] ?? [];
            
            if( !empty( $page_options ) ) {
                $values = array_merge( $values, $this->_sanitizeValues( $page_options, $container_post_values ) );
            }
        }
        
        return $values;
    }
    
}
