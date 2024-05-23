<?php

declare( strict_types = 1 );

namespace DHT\Core\Api\Api;

if ( !defined( 'DHT_MAIN' ) ) die( 'Forbidden' );

/**
 * Singleton Class that is used as a base class for all API classes
 */
abstract class BaseAPI {
    
    //route namespace
    protected string $_namespace = 'devhunters';
    
    //route version
    protected string $_version = 'v1';
    
    
    public abstract function registerAPIEndpoints( array $config ) : void;
    
    /**
     * This is the static method that controls the access to the singleton
     * instance. On the first run, it creates a singleton object and places it
     * into the static field. On subsequent runs, it returns the client existing
     * object stored in the static field.
     *
     * @return self - current class
     * @since     1.0.0
     */
    public static function init() : self {
        
        $cls = static::class;
        if ( !isset( self::$_instances[ $cls ] ) ) {
            self::$_instances[ $cls ] = new static();
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