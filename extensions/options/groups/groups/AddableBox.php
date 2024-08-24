<?php
declare( strict_types = 1 );

namespace DHT\Extensions\Options\Groups\Groups;

use DHT\Extensions\Options\Groups\BaseGroup;
use function DHT\fw;
use function DHT\Helpers\dht_render_box_item_content;

if ( !defined( 'DHT_MAIN' ) ) die( 'Forbidden' );

final class AddableBox extends BaseGroup {
    
    //field type
    protected string $_group = 'addable-box';
    
    //group option
    private array $_groupOptions = [];
    
    /**
     * @param array $registered_options
     *
     * @since     1.0.0
     */
    public function __construct( array $registered_options ) {
        
        parent::__construct( $registered_options );
        
        add_action( 'wp_ajax_getBoxOptions', [ $this, 'getBoxOptions' ] );
        add_action( 'wp_ajax_nopriv_getBoxOptions', [ $this, 'getBoxOptions' ] ); // For non-logged in users
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
        
        // Enqueue the WordPress editor scripts and styles
        wp_enqueue_editor();
        
        wp_register_style( DHT_PREFIX . '-addable-box-group', DHT_ASSETS_URI . 'styles/css/extensions/options/groups/addable-box-style.css', array(), fw()->manifest->get( 'version' ) );
        wp_enqueue_style( DHT_PREFIX . '-addable-box-group' );
        
        wp_enqueue_script( DHT_PREFIX . '-addable-box-group', DHT_ASSETS_URI . 'scripts/js/extensions/options/groups/addable-box-script.js', array( 'jquery', 'jquery-ui-sortable' ), fw()->manifest->get( 'version' ), true );
        wp_localize_script( DHT_PREFIX . '-addable-box-group', DHT_PREFIX . '_addable_box_option_ajax', array( 'ajax_url' => admin_url( 'admin-ajax.php' ) ) );
    }
    
    /**
     * ajax action to retrieve all icons and display then in the popup
     *
     * @return void
     * @since     1.0.0
     */
    public function getBoxOptions() : void {
        
        if ( isset( $_POST[ 'data' ][ 'box_number' ] ) && isset( $_POST[ 'data' ][ 'group' ] ) ) {
            
            //retrieve box number
            $box_number = !empty( $_POST[ 'data' ][ 'box_number' ] ) ? (int)$_POST[ 'data' ][ 'box_number' ] : 0;
            $group = !empty( $_POST[ 'data' ][ 'group' ] ) ? json_decode( stripslashes( html_entity_decode( $_POST[ 'data' ][ 'group' ], ENT_QUOTES, 'UTF-8' ) ), true ) : [];
            
            ob_start();
            
            if ( !empty( $group ) ) {
                
                echo dht_render_box_item_content( $group, [], $this->_registeredOptions, _x( 'Box Title', 'options', DHT_PREFIX ), $box_number );
            } else {
                
                echo _x( 'No options available', 'options', DHT_PREFIX );
            }
            
            $content = ob_get_clean();
            
            wp_send_json_success( $content );
            
        } else {
            
            wp_send_json_success( _x( 'Something went wrong, please refresh the page', 'options', DHT_PREFIX ) );
        }
        
        die();
    }
    
    /**
     *  In this method you receive $group_value (from form submit or whatever)
     *  and must return correct and safe value that will be stored in database.
     *
     *  $group_value can be null.
     *  In this case you should return default value from $group['value']
     *
     * @param array $group             - option field
     * @param mixed $group_post_values - $_POST values passed on save
     *
     * @return mixed - changed group value
     * @since     1.0.0
     */
    public function saveValue( array $group, mixed $group_post_values ) : mixed {
        
        if ( empty( $group_post_values ) || empty( $group[ 'options' ] ) ) {
            return $group[ 'value' ];
        }
        
        $sanitized_values = [];
        
        // Flatten options array to make it easier to access options by ID
        $options = [];
        foreach ( $group[ 'options' ] as $option ) {
            
            $options[ $option[ 'id' ] ] = $option;
        }
        
        //go through all the saved values and sanitize them
        foreach ( $group_post_values as $value_key => $values ) {
            
            foreach ( $values as $option_id => $value ) {
                
                //the box title, it is not located in the options array so we need to sanitize it separately
                if ( $option_id == 'box-title' ) {
                    
                    $sanitized_values[ $value_key ] [ 'box-title' ] = sanitize_text_field( $value );
                    
                    continue;
                }
                
                if ( isset( $options[ $option_id ] ) ) {
                    
                    $sanitized_values[ $value_key ] [ $option_id ] = $this->_registeredOptions[ $options[ $option_id ][ 'type' ] ]->saveValue( $options[ $option_id ], $value );
                }
            }
        }
        
        return $sanitized_values;
    }
    
}
