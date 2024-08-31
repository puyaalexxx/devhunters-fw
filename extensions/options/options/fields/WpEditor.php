<?php
declare( strict_types = 1 );

namespace DHT\Extensions\Options\Options\fields;

use DHT\Extensions\Options\Options\BaseField;
use function DHT\fw;
use function DHT\Helpers\dht_sanitize_wpeditor_value;

if ( !defined( 'DHT_MAIN' ) ) die( 'Forbidden' );

final class WpEditor extends BaseField {
    
    //field type
    protected string $_field = 'wpeditor';
    
    /**
     * @since     1.0.0
     */
    public function __construct() {
        
        parent::__construct();
    }
    
    /**
     * Enqueue input scripts and styles
     *
     * @param array $field
     *
     * @return void
     * @since     1.0.0
     */
    public function enqueueOptionScripts( array $field ) : void {
        
        // Enqueue the WordPress editor scripts and styles
        wp_enqueue_editor();
        
        wp_register_style( DHT_PREFIX . '-wpeditor-field', DHT_ASSETS_URI . 'styles/css/extensions/options/fields/wpeditor-style.css', array(), fw()->manifest->get( 'version' ) );
        wp_enqueue_style( DHT_PREFIX . '-wpeditor-field' );
    }
    
    /**
     * add prefix id for field id to display it in the form as array values
     * (used to retrieve the $_POST['prefix_id'] values)
     *
     * @param array  $field
     * @param string $options_id
     *
     * @return array
     * @since     1.0.0
     */
    public function addIDPrefix( array $field, string $options_id ) : array {
        
        if ( empty( $options_id ) ) return $field;
        
        $id = $options_id . '[' . $field[ 'id' ] . ']';
        
        //wp editor does not support brackets in the id field so need to leave it without prefix id
        $field[ 'name' ] = $id;
        
        if ( str_ends_with( $id, ']' ) ) {
            // Replace the last character with an empty space
            $id = substr( $id, 0, -1 );
        }
        $field[ 'id' ] = str_replace( [ '[', ']' ], '-', $id );
        
        return $field;
    }
    
    /**
     *  In this method you receive $field_post_value (from form submit or whatever)
     *  and must return correct and safe value that will be stored in database.
     *
     *  $field_post_value can be null.
     *  In this case you should return default value from $field['value']
     *
     * @param array $field            - field
     * @param mixed $field_post_value - field $_POST value passed on save
     *
     * @return mixed - changed field value
     * @since     1.0.0
     */
    public function saveValue( array $field, mixed $field_post_value ) : mixed {
        
        if ( empty( $field_post_value ) ) {
            return $field[ 'value' ];
        }
        
        return dht_sanitize_wpeditor_value( $field_post_value );
    }
    
}