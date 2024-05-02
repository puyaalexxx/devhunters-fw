<?php
declare( strict_types = 1 );

namespace DHT\Extensions\Options\Options;

if ( !defined( 'DHT_MAIN' ) ) die( 'Forbidden' );

use function DHT\Helpers\dht_load_view;

final class Input extends AbstractOption {
    
    //class instances for Singleton Pattern
    private static array $_instances = [];
    
    //field type
    protected string $_field = 'input';
    
    protected function __construct() {}
    
    /**
     *
     * return field type
     *
     * @return string
     * @since     1.0.0
     */
    public function getField() : string {
        
        return $this->_field;
    }
    
    /**
     *
     * return field template
     *
     * @param array $option
     *
     * @return string
     * @since     1.0.0
     */
    public function getTemplate(array $option) : string {
        
        return dht_load_view( $this->template_dir, $this->getField() . '.php', $option );
    }
    
    public function saveOption() : void {
    
    
    }
    
    
    /**
     * This is the static method that controls the access to the singleton
     * instance. On the first run, it creates a singleton object and places it
     * into the static field. On subsequent runs, it returns the client existing
     * object stored in the static field.
     **
     *
     * @return Input - current class
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