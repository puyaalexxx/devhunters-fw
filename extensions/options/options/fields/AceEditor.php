<?php
declare( strict_types = 1 );

namespace DHT\Extensions\Options\Options\Fields;

use DHT\Extensions\Options\Options\BaseField;
use DHT\Helpers\Classes\Environment;
use function DHT\fw;

if( !defined( 'DHT_MAIN' ) ) die( 'Forbidden' );

final class AceEditor extends BaseField {
    
    //field type
    protected string $_field = 'ace-editor';
    
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
        
        if( Environment::isDevelopment() ) {
            wp_enqueue_script( DHT_PREFIX_JS . '-ace-editor-field', DHT_ASSETS_URI . 'scripts/js/ace-editor.js', array( 'jquery' ), fw()->manifest->get( 'version' ), true );
            
            wp_localize_script( DHT_PREFIX_JS . '-ace-editor-field', 'dht_ace_editor_path', array(
                'path' => DHT_URI . 'node_modules/ace-builds/'
            ) );
        }
        else {
            wp_localize_script( DHT_PREFIX_JS . '-main-bundle', 'dht_ace_editor_path', array(
                'path' => DHT_URI . 'node_modules/ace-builds/'
            ) );
        }
    }
    
    /**
     * merge the field value with the saved value if exists
     *
     * @param array $field       - field
     * @param mixed $saved_value - saved values
     *
     * @return mixed
     * @since     1.0.0
     */
    public function mergeValues( array $field, mixed $saved_value ) : array {
        
        $field[ 'value' ] = empty( $saved_value ) ? $field[ 'value' ] : stripslashes( $saved_value );
        
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
        
        if( empty( $field_post_value ) ) {
            return $field[ 'value' ];
        }
        
        return sanitize_textarea_field( $field_post_value );
    }
    
}
