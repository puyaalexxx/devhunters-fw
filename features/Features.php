<?php

declare( strict_types = 1 );

namespace DHT\Features;

use DHT\Features\Preloader\IPreloader;
use DHT\Features\Preloader\Preloader;
use DHT\Helpers\Traits\SingletonTrait;

if ( !defined( 'DHT_MAIN' ) ) die( 'Forbidden' );

final class Features {
    
    use SingletonTrait;
    
    /**
     * @since     1.0.0
     */
    protected function __construct() {
        
        do_action( 'dht_before_features_init' );
    }
    
    /**
     * get preloader feature class instance
     *
     * @return Preloader - preloader instance
     * @since     1.0.0
     */
    public function preloader() : IPreloader {
        
        return new Preloader();
    }
    
}