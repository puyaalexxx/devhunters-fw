<?php
declare( strict_types = 1 );

namespace DHT\Extensions\Options\Groups\Groups;

use DHT\Extensions\Options\Groups\BaseGroup;
use function DHT\fw;

if ( !defined( 'DHT_MAIN' ) ) die( 'Forbidden' );

final class Tabs extends BaseGroup {
    
    //field type
    protected string $_group = 'tabs';
    
    /**
     * @param array $registered_options
     *
     * @since     1.0.0
     */
    public function __construct( array $registered_options ) {
        
        parent::__construct( $registered_options );
    }
    
    /**
     * Enqueue input scripts and styles
     *
     * @param array $group
     *
     * @return void
     * @since     1.0.0
     */
    public function enqueueOptionScripts( array $group ) : void {
        
        wp_register_style( DHT_PREFIX . '-tabs-group', DHT_ASSETS_URI . 'styles/css/extensions/options/groups/tabs-style.css', array(), fw()->manifest->get( 'version' ) );
        wp_enqueue_style( DHT_PREFIX . '-tabs-group' );
        
        wp_enqueue_script( DHT_PREFIX . '-tabs-group', DHT_ASSETS_URI . 'scripts/js/extensions/options/groups/tabs-script.js', array( 'jquery' ), fw()->manifest->get( 'version' ), true );
    }
    
}
