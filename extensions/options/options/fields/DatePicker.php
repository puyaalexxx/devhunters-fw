<?php
declare( strict_types = 1 );

namespace DHT\Extensions\Options\Options\Fields;

use DHT\Extensions\Options\Options\BaseField;
use function DHT\fw;

if( !defined( 'DHT_MAIN' ) ) die( 'Forbidden' );

class DatePicker extends BaseField {
    
    //field type
    protected string $_field = 'datepicker';
    
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
        
        wp_register_style( DHT_PREFIX_CSS . '-jquery-ui-datepicker', DHT_ASSETS_URI . 'styles/libraries/jquery-ui-datepicker.min.css', array(), fw()->manifest->get( 'version' ) );
        wp_enqueue_style( DHT_PREFIX_CSS . '-jquery-ui-datepicker' );
        
        wp_register_style( DHT_PREFIX_CSS . '-datepicker-field', DHT_ASSETS_URI . 'styles/css/datepicker.css', array(), fw()->manifest->get( 'version' ) );
        wp_enqueue_style( DHT_PREFIX_CSS . '-datepicker-field' );
        
        wp_enqueue_script( DHT_PREFIX_JS . '-jquery-ui-datepicker', DHT_ASSETS_URI . 'scripts/libraries/jquery-ui-datepicker.min.js', array(), fw()->manifest->get( 'version' ), true );
        
        wp_enqueue_script( DHT_PREFIX_JS . '-datepicker-field', DHT_ASSETS_URI . 'scripts/js/datepicker-js.js', array( DHT_PREFIX_JS . '-jquery-ui-datepicker' ), fw()->manifest->get( 'version' ), true );
    }
    
}