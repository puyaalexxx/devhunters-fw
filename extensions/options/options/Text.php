<?php
declare( strict_types = 1 );

namespace DHT\Extensions\Options\Options;

use function DHT\Helpers\dht_print_r;

if ( !defined( 'DHT_MAIN' ) ) die( 'Forbidden' );

final class Text extends BaseOption {
    
    //field type
    protected string $_field = 'text';
    
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
    
    /**
     *
     * return field type
     *
     * @return string
     * @since     1.0.0
     */
    public function getField() : string {
        
        return parent::getField();
    }
}