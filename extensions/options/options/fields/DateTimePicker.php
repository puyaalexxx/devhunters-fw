<?php
declare( strict_types = 1 );

namespace DHT\Extensions\Options\Options\fields;

use DHT\Extensions\Options\Options\BaseField;
use function DHT\fw;

if ( !defined( 'DHT_MAIN' ) ) die( 'Forbidden' );

class DateTimePicker extends BaseField {
    
    //field type
    protected string $_field = 'datetimepicker';
    
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
        
        wp_register_style( DHT_PREFIX . '-jquery-ui-datepicker', DHT_ASSETS_URI . 'styles/libraries/jquery-ui-datepicker.min.css', array(), fw()->manifest->get( 'version' ) );
        wp_enqueue_style( DHT_PREFIX . '-jquery-ui-datepicker' );
        wp_register_style( DHT_PREFIX . '-jquery-ui-timepicker', DHT_ASSETS_URI . 'styles/libraries/jquery-ui-timepicker-addon.min.css', array(), fw()->manifest->get( 'version' ) );
        wp_enqueue_style( DHT_PREFIX . '-jquery-ui-timepicker' );
        
        //custom css
        wp_register_style( DHT_PREFIX . '-datetimepicker-field', DHT_ASSETS_URI . 'styles/css/extensions/options/fields/datetimepicker-style.css', array(), fw()->manifest->get( 'version' ) );
        wp_enqueue_style( DHT_PREFIX . '-datetimepicker-field' );
        
        wp_enqueue_script( DHT_PREFIX . '-jquery-ui-datepicker', DHT_ASSETS_URI . 'scripts/libraries/jquery-ui-datepicker.min.js', array(), fw()->manifest->get( 'version' ), true );
        wp_enqueue_script( DHT_PREFIX . '-jquery-ui-timepicker', DHT_ASSETS_URI . 'scripts/libraries/jquery-ui-timepicker-addon.min.js', array( DHT_PREFIX . '-jquery-ui-datepicker' ), fw()->manifest->get( 'version' ), true );
        
        //custom js
        wp_enqueue_script( DHT_PREFIX . '-datetimepicker-field', DHT_ASSETS_URI . 'scripts/js/extensions/options/fields/datetimepicker-script.js', array( DHT_PREFIX . '-jquery-ui-datepicker' ), fw()->manifest->get( 'version' ), true );
    }
    
}