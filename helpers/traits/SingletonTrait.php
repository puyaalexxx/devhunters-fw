<?php
declare( strict_types = 1 );

namespace DHT\Helpers\Traits;

if( !defined( 'DHT_MAIN' ) ) die( 'Forbidden' );

use Exception;

trait SingletonTrait {
    
    /**
     * Holds the single instance of the class.
     *
     * @var array
     */
    private static array $_instances = [];
    
    /**
     * This is the static method that controls the access to the singleton
     * instance. On the first run, it creates a singleton object and places it
     * into the static field. On subsequent runs, it returns the existing
     * object stored in the static field.
     *
     * @return self - current class
     * @since     1.0.0
     */
    public static function init() : self {
        
        $cls = static::class;
        if( !isset( self::$_instances[ $cls ] ) ) {
            error_log( "Creating new instance of {$cls}" );
            self::$_instances[ $cls ] = new static();
        }
        else {
            error_log( "Returning existing instance of {$cls}" );
        }
        
        return self::$_instances[ $cls ];
    }
    
    /**
     * Prevents cloning of the instance.
     *
     * @since     1.0.0
     */
    protected function __clone() : void {}
    
    /**
     * Prevents unserializing of the instance.
     *
     * @throws Exception
     * @since     1.0.0
     */
    public function __wakeup() {
        
        throw new Exception( _x( 'Cannot unserialize singleton', 'traits', DHT_PREFIX ) );
    }
    
}
