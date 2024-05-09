<?php
declare( strict_types = 1 );

namespace DHT\Extensions\Options\Options;

if ( !defined( 'DHT_MAIN' ) ) die( 'Forbidden' );

final class DropdownMultiple extends BaseOption {
    
    //field type
    protected string $_field = 'dropdown-multiple';
    
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
    
}