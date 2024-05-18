<?php

declare( strict_types = 1 );

namespace DHT\Components;

use DHT\Components\Preloader\IPreloader;
use DHT\Core\DI\ComponentClassInstance;
use DHT\Core\DI\DIInit;

if ( !defined( 'DHT_MAIN' ) ) die( 'Forbidden' );

final class Components {
    
    //class instances for Singleton Pattern
    private static array $_instances = [];
    
    private ComponentClassInstance $_componentClassInstance;
    
    /**
     * @param DIInit $diInit
     *
     * @since     1.0.0
     */
    protected function __construct( DIInit $diInit ) {
        
        do_action( 'dht_before_components_init' );
        
        //initialize Extension classes DI Container
        $this->_componentClassInstance = $diInit->compoponentClassInstance;
    }
    
    /**
     * get preloader component class instance
     *
     * @return ?IPreloader - preloader instance
     * @since     1.0.0
     */
    public function preloader() : ?IPreloader {
        
        //init class only if on specific pages (set from the plugin)
        if ( !apply_filters( 'dht_preloader_init_on_page', true ) ) return null;
        
        return $this->_componentClassInstance->getPreloaderInstance();
    }
    
    /**
     * This is the static method that controls the access to the singleton
     * instance. On the first run, it creates a singleton object and places it
     * into the static field. On subsequent runs, it returns the client existing
     * object stored in the static field.
     *
     * @param $classInstance - ClassInstance object
     *
     * @return self - current class
     * @since     1.0.0
     */
    public static function init( DIInit $classInstance ) : self {
        
        $cls = static::class;
        if ( !isset( self::$_instances[ $cls ] ) ) {
            self::$_instances[ $cls ] = new static( $classInstance );
        }
        
        return self::$_instances[ $cls ];
    }
    
    /**
     * no possibility to clone this class
     *
     * @return void
     * @since     1.0.0
     */
    protected function __clone() : void {}
    
}