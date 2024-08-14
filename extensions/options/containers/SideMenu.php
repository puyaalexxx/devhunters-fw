<?php
declare( strict_types = 1 );

namespace DHT\Extensions\Options\containers;

use DHT\Extensions\Options\groups\BaseGroup;

if ( !defined( 'DHT_MAIN' ) ) die( 'Forbidden' );

final class SideMenu extends BaseGroup {
    
    //field type
    protected string $_field = 'sidemenu';
    
    /**
     * @since     1.0.0
     */
    protected function __construct() {}
    
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
