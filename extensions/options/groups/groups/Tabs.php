<?php
declare( strict_types = 1 );

namespace DHT\Extensions\Options\groups\groups;

use DHT\Extensions\Options\groups\BaseGroup;
use function DHT\fw;

if ( !defined( 'DHT_MAIN' ) ) die( 'Forbidden' );

final class Tabs extends BaseGroup {
    
    //field type
    protected string $_group = 'tabs';
    
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
        
        wp_register_style( DHT_PREFIX . '-tabs-group', DHT_ASSETS_URI . 'styles/css/extensions/options/groups/tabs-style.css', array(), fw()->manifest->get( 'version' ) );
        wp_enqueue_style( DHT_PREFIX . '-tabs-group' );
        
        wp_enqueue_script( DHT_PREFIX . '-tabs-option', DHT_ASSETS_URI . 'scripts/js/extensions/options/groups/tabs-script.js', array( 'jquery' ), fw()->manifest->get( 'version' ), true );
    }
    
}
