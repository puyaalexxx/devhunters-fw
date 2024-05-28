<?php
declare( strict_types = 1 );

namespace DHT\Extensions\Options\Options\Fields;

use DHT\Extensions\Options\Options\BaseOption;

if ( !defined( 'DHT_MAIN' ) ) die( 'Forbidden' );

final class DropdownMultiple extends BaseOption {
    
    //field type
    protected string $_field = 'dropdown-multiple';
    
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
    
}