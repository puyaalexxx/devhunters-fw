<?php
declare( strict_types = 1 );

namespace DHT\Extensions\Options\Options;

if ( !defined( 'DHT_MAIN' ) ) die( 'Forbidden' );

use function DHT\Helpers\dht_load_view;

final class Textarea extends BaseOption {
    
    //field type
    protected string $_field = 'textarea';
    
    /**
     * @since     1.0.0
     */
    protected function __construct() {
        
        parent::__construct();
    }
    
    /**
     * Enqueue textarea scripts and styles
     *
     * @param string $hook
     *
     * @return void
     * @since     1.0.0
     */
    public function enqueueOptionScripts( string $hook ) : void {}
}