<?php
declare( strict_types = 1 );

namespace DHT\Extensions\Options\Groups\Groups;

use DHT\Extensions\Options\Groups\BaseGroup;
use function DHT\fw;

if ( !defined( 'DHT_MAIN' ) ) die( 'Forbidden' );

final class AddableBox extends BaseGroup {
    
    //field type
    protected string $_group = 'addable-box';
    
    /**
     * @since     1.0.0
     */
    public function __construct() {
        
        parent::__construct();
    }
    
    /**
     * Enqueue input scripts and styles
     *
     * @param array $option
     *
     * @return void
     * @since     1.0.0
     */
    public function enqueueOptionScripts( array $option ) : void {
        
        wp_register_style( DHT_PREFIX . '-addable-box-group', DHT_ASSETS_URI . 'styles/css/extensions/options/groups/addable-box-style.css', array(), fw()->manifest->get( 'version' ) );
        wp_enqueue_style( DHT_PREFIX . '-addable-box-group' );
        
        wp_enqueue_script( DHT_PREFIX . '-addable-box-option', DHT_ASSETS_URI . 'scripts/js/extensions/options/groups/addable-box-script.js', array( 'jquery' ), fw()->manifest->get( 'version' ), true );
    }
    
    /**
     *  In this method you receive $option_value (from form submit or whatever)
     *  and must return correct and safe value that will be stored in database.
     *
     *  $group_value can be null.
     *  In this case you should return default value from $group['value']
     *
     * @param array $group       - option field
     * @param mixed $group_value - saved option value
     *
     * @return mixed - changed option value
     * @since     1.0.0
     */
    public function saveValue( array $group, mixed $group_value, array $option_classes ) : mixed {
        
        if ( empty( $group_value ) || empty( $group[ 'options' ] ) ) {
            return $group[ 'value' ];
        }
        
        $sanitized_values = [];
        
        // Flatten options array to make it easier to access options by ID
        $options = [];
        foreach ( $group[ 'options' ] as $option ) {
            
            $options[ $option[ 'id' ] ] = $option;
        }
        
        //go through all the saved values and sanitize them
        foreach ( $group_value as $value_key => $values ) {
            
            foreach ( $values as $option_id => $value ) {
                
                //the box title, it is not located in the options array so we need to sanitize it separately
                if ( $option_id == 'box-title' ) {
                    
                    $sanitized_values[ $value_key ] [ 'box-title' ] = sanitize_text_field( $value );
                    
                    continue;
                }
                
                if ( isset( $options[ $option_id ] ) ) {
                    
                    $sanitized_values[ $value_key ] [ $option_id ] = $option_classes[ $options[ $option_id ][ 'type' ] ]->saveValue( $options[ $option_id ], $value );
                }
            }
        }
        
        return $sanitized_values;
    }
    
}
