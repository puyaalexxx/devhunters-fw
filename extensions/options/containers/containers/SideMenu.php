<?php
declare( strict_types = 1 );

namespace DHT\Extensions\Options\Containers\Containers;

use DHT\Extensions\Options\Containers\BaseContainer;
use DHT\Helpers\Traits\Options\ContainerTypeHelpers;
use function DHT\fw;

if ( !defined( 'DHT_MAIN' ) ) die( 'Forbidden' );

final class SideMenu extends BaseContainer {
    
    use ContainerTypeHelpers;
    
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
        if ( empty( $container_post_values ) ) {
            return [];
        }
        
        $values = [];
        // Check the subtype of menu pages
        $is_tabs_subtype = isset( $container[ 'subtype' ] ) && $container[ 'subtype' ] == 'tabs';
        
        // Sanitize option values
        foreach ( $container[ 'pages' ] as $page ) {
            $page_id = $page[ 'id' ];
            $page_options = $page[ 'options' ] ?? [];
            
            // Handle subpages if they exist
            if ( isset( $page[ 'pages' ] ) ) {
                foreach ( $page[ 'pages' ] as $subpage ) {
                    $subpage_id = $subpage[ 'id' ];
                    $subpage_options = $subpage[ 'options' ] ?? [];
                    
                    if ( $is_tabs_subtype ) {
                        // For 'tabs' subtype, sanitize subpage values
                        $values[ $page_id ][ $subpage_id ] = $this->_sanitizeValues( $subpage_options, $container_post_values[ $page_id ][ $subpage_id ] ?? [] );
                    } else {
                        // For other subtypes, handle subpage values if options are not empty
                        if ( !empty( $subpage_options ) ) {
                            $values = $this->_sanitizeValues( $subpage_options, $container_post_values );
                        }
                    }
                }
            } else {
                if ( $is_tabs_subtype ) {
                    // For 'tabs' subtype, sanitize page values
                    $values[ $page_id ] = $this->_sanitizeValues( $page_options, $container_post_values[ $page_id ] ?? [] );
                } else {
                    // For other subtypes, handle page values if options are not empty
                    if ( !empty( $page_options ) ) {
                        $values = $this->_sanitizeValues( $page_options, $container_post_values );
                    }
                }
            }
        }
        
        return $values;
    }
    
}
