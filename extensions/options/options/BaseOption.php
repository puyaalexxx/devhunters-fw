<?php
declare( strict_types = 1 );

namespace DHT\Extensions\Options\Options;

use function DHT\Helpers\dht_load_view;

if ( !defined( 'DHT_MAIN' ) ) die( 'Forbidden' );

abstract class BaseOption {
    
    //options templates directory
    protected string $template_dir = DHT_TEMPLATES_DIR . 'extensions/options/';
    
    //field type
    protected string $_field = 'unknown';
    
    /**
     * @since     1.0.0
     */
    public function __construct() {}
    
    /**
     * Enqueue the option scripts and css files hook
     *
     * @param array $option
     *
     * @return void
     * @since     1.0.0
     */
    public function enqueueOptionScriptsHook( array $option ) : void {
        
        add_action( 'admin_enqueue_scripts', function () use ( $option ) {
            
            $this->enqueueOptionScripts( $option );
            
        } );
    }
    
    /**
     * Enqueue the option scripts and css files
     *
     * @param array $option
     *
     * @return void
     * @since     1.0.0
     */
    protected abstract function enqueueOptionScripts( array $option ) : void;
    
    /**
     * return option template
     *
     * @param array $option
     *
     * @return string
     * @since     1.0.0
     */
    public function render( array $option ) : string {
        
        return dht_load_view( $this->template_dir, $this->getField() . '.php', $option );
    }
    
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
     * merge the field value with the saved value if exists
     *
     * @param array $option      - option field
     * @param mixed $saved_value - saved values
     *
     * @return mixed
     * @since     1.0.0
     */
    public function mergeValues( array $option, mixed $saved_value ) : array {
        
        $option[ 'value' ] = empty( $saved_value ) ? $option[ 'value' ] : $saved_value;
        
        return $option;
    }
    
    /**
     *  In this method you receive $option_value (from form submit or whatever)
     *  and must return correct and safe value that will be stored in database.
     *
     *  $option_value can be null.
     *  In this case you should return default value from $option['value']
     *
     * @param array $option       - option field
     * @param mixed $option_value - saved option value
     *
     * @return mixed - changed option value
     * @since     1.0.0
     */
    public function saveValue( array $option, mixed $option_value ) : mixed {
        
        if ( empty( $option_value ) ) {
            return $option[ 'value' ];
        }
        
        return $option_value;
    }
    
}