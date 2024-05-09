<?php
declare( strict_types = 1 );

namespace DHT\Extensions\Options\Options;

if ( !defined( 'DHT_MAIN' ) ) die( 'Forbidden' );

final class Textarea extends BaseOption {
    
    //field type
    protected string $_field = 'textarea';
    
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
        
        return sanitize_textarea_field( $option_value );
    }
    
}