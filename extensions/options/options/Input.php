<?php
declare( strict_types = 1 );

namespace DHT\Extensions\Options\Options;

if ( !defined( 'DHT_MAIN' ) ) die( 'Forbidden' );

final class Input extends BaseOption {
    
    //field type
    protected string $_field = 'input';
    
    /**
     * @since     1.0.0
     */
    protected function __construct() {
        
        parent::__construct();
    }
    
    
    /**
     * Enqueue input scripts and styles
     *
     * @param string $hook
     *
     * @return void
     * @since     1.0.0
     */
    public function enqueueOptionScripts( string $hook ) : void {}
    
}