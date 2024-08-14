<?php

namespace DHT\Features\Preloader;

if ( !defined( 'DHT_MAIN' ) ) die( 'Forbidden' );

/**
 * Interface  that is used for the Preloader class.
 */
interface IPreloader {
    
    /**
     * initialize Preloader class
     *
     * @return void
     * @since     1.0.0
     */
    public function init() : void;
    
    /**
     * render preloader
     *
     * @param int $delay - hide it after this delay
     *
     * @return void
     * @since     1.0.0
     */
    public function render( int $delay = 500 ) : void;
    
}