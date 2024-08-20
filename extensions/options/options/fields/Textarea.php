<?php
declare( strict_types = 1 );

namespace DHT\Extensions\Options\Options\fields;

use DHT\Extensions\Options\Options\BaseOption;

if ( !defined( 'DHT_MAIN' ) ) die( 'Forbidden' );

final class Textarea extends BaseOption {
    
    //field type
    protected string $_field = 'textarea';
    
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
    public function enqueueOptionScripts( array $option ) : void {}
    
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
        
        return sanitize_textarea_field( $option_post_value );
    }
    
}