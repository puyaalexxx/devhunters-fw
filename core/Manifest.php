<?php
declare( strict_types = 1 );

namespace DHT\Core;

use function DHT\Helpers\dht_get_variables_from_file;

if ( !defined( 'DHT_MAIN' ) ) die( 'Forbidden' );

/*
 * Class used to retrieve the framework manifest array of values
 */
final class Manifest {
    
    //class instances for Singleton Pattern
    private static array $_instances = [];
    
    //manifest array values
    private array $_manifest = [];
    
    /**
     * @since     1.0.0
     */
    protected function __construct( ) {
        
        //set manifest args to use them through the class
        $this->_manifest = $this->_getManifestArgs();
    }
    
    /**
     *
     * retrieve the manifest value from the manifest array
     *
     * @param string $key - array key to retrieve
     *
     * @return mixed
     *
     * @since     1.0.0
     */
    public function get( string $key ) : mixed {
        
        $no_value = _x( 'Value does not exist', 'manifest', DHT_PREFIX );
        
        if(empty($this->_manifest)) return $no_value;
        
        if(array_key_exists($key, $this->_manifest)) {
            
            return $this->_manifest[$key];
        }
        
        return $no_value;
    }
    
    /**
     *
     * retrieve the manifest args from the manifest.php file
     *
     * @return array
     *
     * @since     1.0.0
     */
    private function _getManifestArgs() : array {
        
        return dht_get_variables_from_file( DHT_DIR . 'manifest.php', 'manifest' );
    }
    
    /**
     * This is the static method that controls the access to the singleton
     * instance. On the first run, it creates a singleton object and places it
     * into the static field. On subsequent runs, it returns the client existing
     * object stored in the static field.
     *
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