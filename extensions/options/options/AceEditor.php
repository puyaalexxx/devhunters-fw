<?php
declare( strict_types = 1 );

namespace DHT\Extensions\Options\Options;

use function DHT\fw;

if ( !defined( 'DHT_MAIN' ) ) die( 'Forbidden' );

final class AceEditor extends BaseOption {
    
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
     * @param array $option
     *
     * @return void
     * @since     1.0.0
     */
    public function enqueueOptionScripts( array $option ) : void {
        
        wp_enqueue_script( DHT_PREFIX . '-ace-editor-option', DHT_ASSETS_URI . 'scripts/js/options/ace-editor-script.js', array( 'jquery' ), fw()->manifest->get( 'version' ), true );
        
        wp_localize_script( DHT_PREFIX . '-ace-editor-option', 'dht_ace_editor_path', array(
            'path' => DHT_URI . 'node_modules/ace-builds/'
        ) );
    }
    
    /**
     *
     * merge the field value with the saved value if exists
     *
     * @param array $option      - option field
     * @param mixed $saved_value - saved values
     *
     * @return mixed
     * @since     1.0.0
     */
    public function mergeValues( array $option, mixed $saved_value ) : array {
        
        $option[ 'value' ] = empty( $saved_value ) ? $option[ 'value' ] : stripslashes( $saved_value );
        
        return $option;
    }
    
    /**
     *
     *  In this method you receive $option_value (from form submit or whatever)
     *  and must return correct and safe value that will be stored in database.
     *
     *  $option_value can be null.
     *  In this case you should return default value from $option['value']
     *
     * @param array $option       - option field
     * @param mixed $option_value - saved option value
     *
     * @return mixed - changed option value
     * @since     1.0.0
     */
    public function saveValue( array $option, mixed $option_value ) : mixed {
        
        if ( empty( $option_value ) ) {
            return $option[ 'value' ];
        }
        
        return sanitize_textarea_field( $option_value );
    }
    
}
