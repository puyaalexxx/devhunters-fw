<?php
declare( strict_types = 1 );

namespace DHT\Extensions\Options\Options\fields;

use DHT\Extensions\Options\Options\BaseOption;
use function DHT\fw;
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
    public function enqueueOptionScripts( array $option ) : void {
        
        // Enqueue the WordPress editor scripts and styles
        wp_enqueue_editor();
        
        wp_register_style( DHT_PREFIX . '-wpeditor-option', DHT_ASSETS_URI . 'styles/css/extensions/options/options/wpeditor-style.css', array(), fw()->manifest->get( 'version' ) );
        wp_enqueue_style( DHT_PREFIX . '-wpeditor-option' );
    }
    
    /**
     * add prefix id for option id to display it in the form as array values
     * (used to retrieve the $_POST['prefix_id'] values)
     *
     * @param array  $option
     * @param string $prefix_id
     *
     * @return array
     * @since     1.0.0
     */
    public function addIDPrefix( array $option, string $prefix_id ) : array {
        
        if ( empty( $prefix_id ) ) return $option;
        
        $id = $prefix_id . '[' . $option[ 'id' ] . ']';
        
        //wp editor does not support brackets in the id field so need to leave it withour prefix id
        $option[ 'name' ] = $id;
        
        if ( str_ends_with( $id, ']' ) ) {
            // Replace the last character with an empty space
            $id = substr( $id, 0, -1 );
        }
        $option[ 'id' ] = str_replace( [ '[', ']' ], '-', $id );
        
        return $option;
    }
    
    /**
     *  In this method you receive $option_post_value (from form submit or whatever)
     *  and must return correct and safe value that will be stored in database.
     *
     *  $option_post_value can be null.
     *  In this case you should return default value from $option['value']
     *
     * @param array $option            - option field
     * @param mixed $option_post_value - option $_POST value passed on save
     *
     * @return mixed - changed option value
     * @since     1.0.0
     */
    public function saveValue( array $option, mixed $option_post_value ) : mixed {
        
        if ( empty( $option_post_value ) ) {
            return $option[ 'value' ];
        }
        
        return dht_sanitize_wpeditor_value( $option_post_value );
    }
    
}