<?php
declare( strict_types = 1 );

namespace DHT\Extensions\Options\Options;

use function DHT\fw;
use function DHT\Helpers\dht_load_view;

if ( !defined( 'DHT_MAIN' ) ) die( 'Forbidden' );

 abstract class BaseOption {
    
    //class instances for Singleton Pattern
    private static array $_instances = [];
    
    //options templates directory
    protected string $template_dir = DHT_TEMPLATES_DIR . 'options/';
    
    //field type
    protected string $_field = 'unknown';
    
    //field option array
    protected array $_options = [];
    
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
     * get field options args
     *
     * @param array  $option
     * @param array  $saved_values - page saved values
     * @param string $prefix_id
     *
     * @return void
     * @since     1.0.0
     */
    public function getFieldOptions( array $option, array $saved_values, string $prefix_id = '' ) : void {
        
        $this->_options = $this->_setOptionArgs( $option, $saved_values, $prefix_id );
    }
    
    /**
     *
     * return option template
     *
     *
     * @return string
     * @since     1.0.0
     */
    public function render() : string {
        
        return dht_load_view( $this->template_dir, $this->getField() . '.php', $this->_options );
    }
    
    /**
     *
     * add prefix id and saved value if exists on the existent option array
     *
     * @param array  $option
     * @param array  $saved_values
     * @param string $prefix_id
     *
     * @return array
     * @since     1.0.0
     */
    private function _setOptionArgs( array $option, array $saved_values, string $prefix_id = '' ) : array {
        
        //if saved value exists, merge it with the default
        $option = $this->_mergeOptionValues( $option, $saved_values );
        
        //change option field prefix id
        return $this->_addOptionIDPrefix( $option, $prefix_id );
    }
    
    /**
     *
     * add prefix id for option id to display it in the form as array values
     * (used to retrieve the $_POST['prefix_id'] values)
     *
     * @param array  $option
     * @param string $prefix_id
     *
     * @return array
     * @since     1.0.0
     */
    protected function _addOptionIDPrefix( array $option, string $prefix_id ) : array {
        
        if ( empty( $prefix_id ) ) return $option;
        
        $option[ 'id' ] = $prefix_id . '[' . $option[ 'id' ] . ']';
        
        return $option;
    }
    
    /**
     *
     * merge the field value with the saved value if exists
     *
     * @param array $option       - option field
     * @param array $saved_values - saved values
     *
     * @return mixed
     * @since     1.0.0
     */
    protected function _mergeOptionValues( array $option, array $saved_values ) : array {
        
        //if saved value exists
        if ( isset( $saved_values[ $option[ 'id' ] ] ) ) {
            
            $option['value'] = $saved_values[ $option[ 'id' ] ];
        }
        
        return $option;
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