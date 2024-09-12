<?php
declare( strict_types = 1 );

namespace DHT\Extensions\Options\Options\Fields;

use DHT\Extensions\Options\Options\BaseField;
use function DHT\fw;

if( !defined( 'DHT_MAIN' ) ) die( 'Forbidden' );

class TimePicker extends BaseField {
    
    //field type
    protected string $_field = 'timepicker';
    
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
        wp_register_style( DHT_PREFIX_CSS . '-jquery-ui-timepicker', DHT_ASSETS_URI . 'styles/libraries/jquery-ui-timepicker-addon.min.css', array(), fw()->manifest->get( 'version' ) );
        wp_enqueue_style( DHT_PREFIX_CSS . '-jquery-ui-timepicker' );
        
        //WordPress comes with the slider option
        wp_enqueue_script( 'jquery-ui-slider' );
        
        //custom css
        wp_register_style( DHT_PREFIX_CSS . '-timepicker-field', DHT_ASSETS_URI . 'styles/css/timepicker.css', array(), fw()->manifest->get( 'version' ) );
        wp_enqueue_style( DHT_PREFIX_CSS . '-timepicker-field' );
        
        wp_enqueue_script( DHT_PREFIX_JS . '-jquery-ui-datepicker', DHT_ASSETS_URI . 'scripts/libraries/jquery-ui-datepicker.min.js', array(), fw()->manifest->get( 'version' ), true );
        wp_enqueue_script( DHT_PREFIX_JS . '-jquery-ui-timepicker', DHT_ASSETS_URI . 'scripts/libraries/jquery-ui-timepicker-addon.min.js', array( DHT_PREFIX_JS . '-jquery-ui-datepicker' ), fw()->manifest->get( 'version' ), true );
        
        //custom js
        wp_enqueue_script( DHT_PREFIX_JS . '-timepicker-field', DHT_ASSETS_URI . 'scripts/js/timepicker-js.js', array( DHT_PREFIX_JS . '-jquery-ui-datepicker' ), fw()->manifest->get( 'version' ), true );
    }
    
}