<?php
declare( strict_types = 1 );

namespace DHT\Extensions\Options\Options\fields;

use DHT\Extensions\Options\Options\BaseField;
use DHT\Helpers\Traits\UploadHelpers;
use function DHT\fw;

if ( !defined( 'DHT_MAIN' ) ) die( 'Forbidden' );

final class UploadImage extends BaseField {
    
    use UploadHelpers;
    
    //field type
    protected string $_field = 'upload-image';
    
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
        
        //Enqueue the media uploader
        wp_enqueue_media();
        
        // Register custom style
        wp_register_style( DHT_PREFIX . '-upload-image-field', DHT_ASSETS_URI . 'styles/css/extensions/options/fields/upload-image-style.css', array(), fw()->manifest->get( 'version' ) );
        wp_enqueue_style( DHT_PREFIX . '-upload-image-field' );
        
        wp_enqueue_script( DHT_PREFIX . '-upload-image-field', DHT_ASSETS_URI . 'scripts/js/extensions/options/fields/upload-image-script.js', array( 'jquery', 'media-editor' ), fw()->manifest->get( 'version' ), true );
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
        
        return $this->_saveUploadFieldHelper( $field, $field_post_value, 'image', 'image_id' );
    }
    
}
