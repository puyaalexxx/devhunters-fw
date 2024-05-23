<?php
declare( strict_types = 1 );

namespace DHT\Core\Api;

use DHT\Core\Api\Api\DashMenusAPI;

if ( !defined( 'DHT_MAIN' ) ) die( 'Forbidden' );

/**
 * Singleton Class that is used to register all framework API endpoints
 */
final class API {
    
    //class instances for Singleton Pattern
    private static array $_instances = [];
    
    //dashboard menus
    public DashMenusAPI $dashmenus;
    
    /**
     * @since     1.0.0
     */
    public function __construct() {
        
        //get dashboard menus api instance
        $this->dashmenus = new DashMenusAPI();
    }
    
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