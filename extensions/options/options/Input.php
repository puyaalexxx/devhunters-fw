<?php
declare( strict_types = 1 );

namespace DHT\Extensions\Options\Options;

use function DHT\Helpers\dht_load_view;
use function DHT\Helpers\dht_print_r;

if ( !defined( 'DHT_MAIN' ) ) die( 'Forbidden' );

final class Input extends BaseOption {
    
    //field type
    protected string $_field = 'input';
    
    /**
     * @param array $option - option array
     *
     * @since     1.0.0
     */
    protected function __construct( array $option ) {
        
        parent::__construct( $option );
    }
    
    /**
     * Enqueue input scripts and styles
     *
     * @param string $hook
     * @param array  $option
     *
     * @return void
     * @since     1.0.0
     */
    public function enqueueOptionScripts( string $hook, array $option ) : void {}
    
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
        
        if ( $option[ 'subtype' ] == 'url' ) {
            $option_value = esc_url_raw( $option_value );
        } elseif ( $option[ 'subtype' ] == 'email' ) {
            $option_value = sanitize_email( $option_value );
        } else {
            $option_value = sanitize_text_field( $option_value );
        }
        
        return $option_value;
    }
    
}
