<?php
declare( strict_types = 1 );

namespace DHT\Extensions\Options\Options\Fields;

use DHT\Extensions\Options\Options\BaseField;
use DHT\Helpers\Classes\Environment;
use function DHT\fw;

if( !defined( 'DHT_MAIN' ) ) die( 'Forbidden' );

final class MultiOptions extends BaseField {
    
    //field type
    protected string $_field = 'multi-options';
    
    /**
     * @since     1.0.0
     */
    public function __construct() {
        
        parent::__construct();
    }
    
    /**
     * Enqueue input scripts and styles
     *
     * @param array $field
     *
     * @return void
     * @since     1.0.0
     */
    public function enqueueOptionScripts( array $field ) : void {
        
        //library css
        wp_register_style( DHT_PREFIX_CSS . '-select2-field', DHT_ASSETS_URI . 'styles/libraries/select2.min.css', array(), fw()->manifest->get( 'version' ) );
        wp_enqueue_style( DHT_PREFIX_CSS . '-select2-field' );
        
        //library js
        wp_enqueue_script( DHT_PREFIX_JS . '-select2-field', DHT_ASSETS_URI . 'scripts/libraries/select2.full.min.js', array( 'jquery' ), fw()->manifest->get( 'version' ), true );
        
        if( Environment::isDevelopment() ) {
            wp_register_style( DHT_PREFIX_CSS . '-multi-options-field', DHT_ASSETS_URI . 'styles/css/multi-options.css', array(), fw()->manifest->get( 'version' ) );
            wp_enqueue_style( DHT_PREFIX_CSS . '-multi-options-field' );
            
            wp_enqueue_script( DHT_PREFIX_JS . '-multi-options-field', DHT_ASSETS_URI . 'scripts/js/multi-options.js', array(
                'jquery',
                DHT_PREFIX_JS . '-select2-field'
            ), fw()->manifest->get( 'version' ), true );
        }
    }
    
}