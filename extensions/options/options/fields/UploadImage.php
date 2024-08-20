<?php
declare( strict_types = 1 );

namespace DHT\Extensions\Options\Options\fields;

use DHT\Extensions\Options\Options\BaseOption;
use DHT\Helpers\Traits\UploadHelpers;
use function DHT\fw;

if ( !defined( 'DHT_MAIN' ) ) die( 'Forbidden' );

final class UploadImage extends BaseOption {
    
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
     * @param array $option
     *
     * @return void
     * @since     1.0.0
     */
    public function enqueueOptionScripts( array $option ) : void {
        
        //Enqueue the media uploader
        wp_enqueue_media();
        
        // Register custom style
        wp_register_style( DHT_PREFIX . '-upload-image-option', DHT_ASSETS_URI . 'styles/css/extensions/options/options/upload-image-style.css', array(), fw()->manifest->get( 'version' ) );
        wp_enqueue_style( DHT_PREFIX . '-upload-image-option' );
        
        wp_enqueue_script( DHT_PREFIX . '-upload-image-option', DHT_ASSETS_URI . 'scripts/js/extensions/options/options/upload-image-script.js', array( 'jquery', 'media-editor' ), fw()->manifest->get( 'version' ), true );
    }
    
    /**
     *  In this method you receive $option_post_value (from form submit or whatever)
     *  and must return correct and safe value that will be stored in database.
     *
     *  $option_post_value can be null.
     *  In this case you should return default value from $option['value']
     *
     * @param array $option            - option field
     * @param mixed $option_post_value - option $_POST value passed on save
     *
     * @return mixed - changed option value
     * @since     1.0.0
     */
    public function saveValue( array $option, mixed $option_post_value ) : mixed {
        
        if ( empty( $option_post_value ) ) {
            return $option[ 'value' ];
        }
        
        return $this->_saveUploadOptionHelper( $option, $option_post_value, 'image', 'image_id' );
    }
    
}
