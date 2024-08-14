<?php
declare( strict_types = 1 );

namespace DHT\Extensions\Options\Options\fields;

use DHT\Extensions\Options\Options\BaseOption;

if ( !defined( 'DHT_MAIN' ) ) die( 'Forbidden' );

final class Input extends BaseOption {
    
    //field type
    protected string $_field = 'input';
    
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
        
        if ( isset( $option[ 'subtype' ] ) ) {
            if ( $option[ 'subtype' ] == 'url' ) {
                
                $option_value = esc_url_raw( $option_value );
                
            } elseif ( $option[ 'subtype' ] == 'email' ) {
                
                $option_value = sanitize_email( $option_value );
            }
        }
        
        return sanitize_text_field( $option_value );
    }
    
}
