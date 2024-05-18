<?php
declare( strict_types = 1 );

namespace DHT\Extensions\Options\Options;

use function DHT\Helpers\dht_sanitize_wpeditor_value;

if ( !defined( 'DHT_MAIN' ) ) die( 'Forbidden' );

final class WpEditor extends BaseOption {
    
    //field type
    protected string $_field = 'wpeditor';
    
    /**
     * @since     1.0.0
     */
    public function __construct() {
        
        parent::__construct();
    }
    
    /**
     * Enqueue input scripts and styles
     *
     * @param array $option
     *
     * @return void
     * @since     1.0.0
     */
    public function enqueueOptionScripts( array $option ) : void {}
    
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
        
        //wp editor does not support brackets in the id field so need to leave it withour prefix id
        $option[ 'name' ] = $option_prefix_id . '[' . $option[ 'id' ] . ']';
        
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
        
        return dht_sanitize_wpeditor_value( $option_value );
    }
    
}