<?php
declare( strict_types = 1 );

namespace DHT\Extensions\Options\Options;

use function DHT\Helpers\dht_load_view;
use function DHT\Helpers\dht_print_r;

if ( !defined( 'DHT_MAIN' ) ) die( 'Forbidden' );

abstract class BaseOption {
    
    //class instances for Singleton Pattern
    private static array $_instances = [];
    
    //options templates directory
    protected string $template_dir = DHT_TEMPLATES_DIR . 'options/';
    
    //field type
    protected string $_field = 'unknown';
    
    /**
     *
     * receive the option array, saved options values and prefix_id
     *
     * @since     1.0.0
     */
    protected function __construct() {
        
        add_action( 'admin_enqueue_scripts', [ $this, 'enqueueOptionScripts' ] );
    }
    
    /**
     * Enqueue the checkbox css file
     *
     * @param string $hook
     *
     * @return void
     * @since     1.0.0
     */
    public abstract function enqueueOptionScripts( string $hook ) : void;
    
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
     * return option template
     *
     * @param array $option
     *
     * @return string
     * @since     1.0.0
     */
    public function render(array $option) : string {
        
        return dht_load_view( $this->template_dir, $this->getField() . '.php', $option );
    }
   
    /**
     *
     * add prefix id for option id to display it in the form as array values
     * (used to retrieve the $_POST['prefix_id'] values)
     *
     * @param array  $option
     * @param string $option_prefix_id
     *
     * @return array
     * @since     1.0.0
     */
    public function addIDPrefix( array $option, string $option_prefix_id ) : array {
        
        if ( empty( $option_prefix_id ) ) return $option;
        
        $option[ 'id' ] = $option_prefix_id . '[' . $option[ 'id' ] . ']';
        
        return $option;
    }
    
    /**
     *
     * merge the field value with the saved value if exists
     *
     * @param array $option      - option field
     * @param mixed $saved_value - saved values
     *
     * @return mixed
     * @since     1.0.0
     */
    public function mergeValues( array $option, mixed $saved_value ) : array {
        
        if($saved_value == 'no') return $option;
        
        $option[ 'value' ] = empty( $saved_value ) ? $option[ 'value' ] : $saved_value;
        
        return $option;
    }
    
    /**
     *
     *  In this method you receive $option_value (from form submit or whatever)
     *  and must return correct and safe value that will be stored in database.
     *
     *  $option_value can be null.
     *  In this case you should return default value from $option['value']
     *
     * @param array $option - option field
     * @param mixed $option_value  - saved option value
     *
     * @return mixed - changed option value
     * @since     1.0.0
     */
    public function saveValue( array $option, mixed $option_value ) : mixed {
        
        if ( empty( $option_value ) ) {
            return $option['value'];
        }
        
        return $option_value;
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