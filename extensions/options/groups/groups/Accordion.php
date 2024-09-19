<?php
declare( strict_types = 1 );

namespace DHT\Extensions\Options\Groups\Groups;

use DHT\Extensions\Options\Groups\BaseGroup;
use DHT\Helpers\Classes\Environment;
use function DHT\fw;

if( !defined( 'DHT_MAIN' ) ) die( 'Forbidden' );

final class Accordion extends BaseGroup {
    
    //group type
    protected string $_group = 'accordion';
    
    /**
     * @param array $optionTogglesClasses
     * @param array $optionFieldsClasses
     *
     * @since     1.0.0
     */
    public function __construct( array $optionTogglesClasses, array $optionFieldsClasses ) {
        
        $this->_optionTogglesClasses = $optionTogglesClasses;
        $this->_optionFieldsClasses = $optionFieldsClasses;
        
        parent::__construct( $optionTogglesClasses, $optionFieldsClasses );
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
        
        if( Environment::isDevelopment() ) {
            wp_register_style( DHT_PREFIX_CSS . '-accordion-group', DHT_ASSETS_URI . 'dist/css/accordion.css', array(), fw()->manifest->get( 'version' ) );
            wp_enqueue_style( DHT_PREFIX_CSS . '-accordion-group' );
            
            wp_enqueue_script( DHT_PREFIX_JS . '-accordion-group', DHT_ASSETS_URI . 'dist/js/accordion.js', array( 'jquery' ), fw()->manifest->get( 'version' ), true );
        }
    }
    
}
