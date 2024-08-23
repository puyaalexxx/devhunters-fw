<?php
declare( strict_types = 1 );

namespace DHT\Extensions\Options\Containers;

use function DHT\Helpers\dht_load_view;

if ( !defined( 'DHT_MAIN' ) ) die( 'Forbidden' );

abstract class BaseContainer {
    
    //options templates directory
    protected string $template_dir = DHT_TEMPLATES_DIR . 'extensions/options/containers/';
    
    //field type
    protected string $_container = 'unknown';
    
    //registered group classes
    private array $_optionGroupsClasses;
    
    //registered option classes
    private array $_optionClasses;
    
    /**
     * @param array $optionGroupsClasses
     * @param array $optionClasses
     *
     * @since     1.0.0
     */
    public function __construct( array $optionGroupsClasses, array $optionClasses ) {
        
        $this->_optionGroupsClasses = $optionGroupsClasses;
        $this->_optionClasses = $optionClasses;
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
        
        add_action( 'admin_enqueue_scripts', function () use ( $container ) {
            
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
     * @param mixed $saved_values
     * @param array $additional_args
     *
     * @return string
     * @since     1.0.0
     */
    public function render( array $container, mixed $saved_values, array $additional_args = [] ) : string {
        
        $registered_options = [
            'groupClasses' => $this->_optionGroupsClasses,
            'optionClasses' => $this->_optionClasses
        ];
        
        //get each current page options if exists
        
        return dht_load_view( $this->template_dir, $this->getContainer() . '.php', [
            'container' => $container,
            'saved_values' => $saved_values,
            'registered_options' => $registered_options,
            'additional_args' => $additional_args
        ] );
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
    
    /**
     * sanitize each option value passed from the $_POST array
     *
     * @param array $options
     * @param array $options_post_values - container options $_POST values passed on save
     *
     * @return mixed
     * @since     1.0.0
     */
    private function _sanitizeValues( array $options, array $options_post_values ) : array {
        
        $values = [];
        foreach ( $options as $option ) {
            
            $option_post_value = $options_post_values[ $option[ 'id' ] ] ?? [];
            
            //if it is a group type
            if ( isset( $this->_optionGroupsClasses[ $option[ 'type' ] ] ) ) {
                
                $values[ $option[ 'id' ] ] = $this->_optionGroupsClasses[ $option[ 'type' ] ]->saveValue( $option, $option_post_value );
                
            } //if it is a simple option type
            else {
                
                $values[ $option[ 'id' ] ] = $this->_optionClasses[ $option[ 'type' ] ]->saveValue( $option, $option_post_value );
            }
        }
        
        return $values;
    }
    
}