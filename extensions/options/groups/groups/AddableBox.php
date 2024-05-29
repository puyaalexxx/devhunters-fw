<?php
declare( strict_types = 1 );

namespace DHT\Extensions\Options\Groups\Groups;

use DHT\Extensions\Options\Groups\BaseGroup;

if ( !defined( 'DHT_MAIN' ) ) die( 'Forbidden' );

final class AddableBox extends BaseGroup {
    
    //field type
    protected string $_group = 'addable-box';
    
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
        
        // wp_register_style( DHT_PREFIX . '-addable-box-group', DHT_ASSETS_URI . 'styles/css/extensions/options/groups/addable-box-style.css', array(), fw()->manifest->get( 'version' ) );
        // wp_enqueue_style( DHT_PREFIX . '-addable-box-group' );
        
        // wp_enqueue_script( DHT_PREFIX . '-addable-box-option', DHT_ASSETS_URI . 'scripts/js/extensions/options/groups/addable-box-script.js', array( 'jquery' ), fw()->manifest->get( 'version' ), true );
    }
    
}
