<?php
declare( strict_types = 1 );

namespace DHT\Extensions\Sidebars;

if( !defined( 'DHT_MAIN' ) ) die( 'Forbidden' );

/**
 * Interface  that is used for the CreateSidebar class.
 */
interface ICreateDynamicSidebars {
    
    /**
     * enable dynamic sidebars feature
     *
     * @return void
     * @since     1.0.0
     */
    public function enable() : void;
    
}