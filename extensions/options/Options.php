<?php
declare( strict_types = 1 );

namespace DHT\Extensions\Options;

if ( !defined( 'DHT_MAIN' ) ) die( 'Forbidden' );

use DHT\Extensions\Options\Options\{AceEditor,
    BaseOption,
    Checkbox,
    ColorPicker,
    DatePicker,
    DateTimePicker,
    Dropdown,
    DropdownMultiple,
    Input,
    MultiInput,
    Radio,
    RangeSlider,
    Spacing,
    SwitchField,
    Text,
    Textarea,
    TimePicker,
    WpEditor};
use function DHT\fw;
use function DHT\Helpers\{dht_get_db_settings_option, dht_load_view, dht_print_r, dht_set_db_settings_option};

//TODO: for performance reason to merge CSS and Js code somehow for options used in one file
//TODO: display option css and js only on pages where they are used and not across entire admin area
//TODO: minify js files at the end
final class Options implements IOptions {
    
    //option configurations (received from config/options folder area)
    private array $_options = [];
    
    //option type Classes
    private array $_optionClasses = [];
    
    //nonce fields (name and action)
    private array $_nonce;
    
    /**
     *
     * @since     1.0.0
     */
    public function __construct() {
        
        add_action( 'admin_enqueue_scripts', [ $this, 'enqueueMainAreaScripts' ] );
        
        //generate nonce field
        $this->_nonce = $this->_generateNonce();
    }
    
    /**
     * Enqueue main wrapper area styles and scripts
     *
     * @param string $hook
     *
     * @return void
     * @since     1.0.0
     */
    public function enqueueMainAreaScripts( string $hook ) : void {
        
        wp_enqueue_script( 'dht-wrapper-area', DHT_ASSETS_URI . 'scripts/js/options/dht-wrapper-area-script.js', array( 'jquery' ), fw()->manifest->get( 'version' ), true );
        
        // Register the style
        wp_register_style( 'dht-wrapper-area', DHT_ASSETS_URI . 'styles/css/options/dht-wrapper-area-style.css', array(), fw()->manifest->get( 'version' ) );
        // Enqueue the style
        wp_enqueue_style( 'dht-wrapper-area' );
    }
    
    /**
     * !!!NOTE - run this method before calling render to initialize the option types from passed option settings
     *
     * @param array $options
     *
     * @return void
     * @since     1.0.0
     */
    public function initOptions( array $options ) : void {
        
        //if no options passed, don't init the options
        if ( empty( $options ) ) return;
        
        // set class options array with passed plugin configurations
        $this->_options = apply_filters( 'options_configurations', $options );
        
        //register the Framework options classes
        $this->_registerFWOptionTypes();
        
        //pass option array to enqueue scripts method (this is needed to enqueue specific script for specific subtype option)
        foreach ( $this->_options as $option ) {
            
            //pass the option array to the enqueue method
            if ( isset( $this->_optionClasses[ $option[ 'type' ] ] ) ) {
                
                $this->_optionClasses[ $option[ 'type' ] ]->enqueueOptionScriptsHook( $option );
            }
        }
    }
    
    /**
     * TODO: finish this method registerCustomOptionType
     * create custom option types located outside the framework
     *
     * @param BaseOption $optionClass
     * @param array      $option
     *
     * @return void
     * @since     1.0.0
     */
    public function registerCustomOptionType( BaseOption $optionClass, array $option ) : void {
        
        $this->_optionClasses[ $option[ 'type' ] ] = $optionClass;
    }
    
    /**
     *
     * render options passed from the plugin
     *
     * @param string $settings_id       - the id passed to update_option() function
     * @param string $options_prefix_id - options prefix id
     *
     * @return void
     * @since     1.0.0
     */
    public function renderOptions( string $settings_id, string $options_prefix_id = '' ) : void {
        
        //save options
        $this->_saveOptions( $settings_id, $options_prefix_id );
        
        //get saved options
        $saved_values = $this->_getSavedOptions( $settings_id );
        
        //this wrapper will be used for ajax to load content inside
        echo '<div id="dht-form-wrapper">';
        
        //display nonce field
        wp_nonce_field( $this->_nonce[ 'action' ], $this->_nonce[ 'name' ] );
        
        //render the passed option types
        foreach ( $this->_options as $option ) {
            
            if ( array_key_exists( $option[ 'type' ], $this->_optionClasses ) ) {
                
                //if this option id has a saved value
                $saved_value = $saved_values[ $option[ 'id' ] ] ?? [];
                
                //merge default values with saved ones to display the saved ones
                $option = $this->_optionClasses[ $option[ 'type' ] ]->mergeValues( $option, $saved_value );
                
                //add option prefix id
                $option = $this->_optionClasses[ $option[ 'type' ] ]->addIDPrefix( $option, $options_prefix_id );
                
                //render the respective option type class
                echo $this->_optionClasses[ $option[ 'type' ] ]->render( $option );
                
            } else {
                
                //display no option template if no match
                echo dht_load_view( DHT_TEMPLATES_DIR . 'options/', 'no-option.php' );
            }
        }
        
        echo '</div>';
    }
    
    /**
     *
     * save options
     *
     * @param string $settings_id       - save the options under this settings id
     * @param string $options_prefix_id - all options are saved under this array key
     *
     * @return void
     * @since     1.0.0
     */
    private function _saveOptions( string $settings_id, string $options_prefix_id ) : void {
        
        if ( isset( $_POST ) && isset( $_POST[ $this->_nonce[ 'name' ] ] )
            && wp_verify_nonce( sanitize_key( wp_unslash( $_POST[ $this->_nonce[ 'name' ] ] ) ), $this->_nonce[ 'action' ] ) ) {
            
            if ( !empty( $_POST[ $options_prefix_id ] ) ) {
                
                $post_values = $_POST[ $options_prefix_id ];
                
                //pre save option values
                //(each option class has a save method used to change the POST value as needed and then save it)
                //you can change the saved value entirely, sanitize it or replace if you want
                foreach ( $this->_options as $option ) {
                    
                    if ( array_key_exists( $option[ 'id' ], $post_values ) ) {
                        
                        $post_values[ $option[ 'id' ] ] = $this->_optionClasses[ $option[ 'type' ] ]->saveValue( $option, $post_values[ $option[ 'id' ] ] );
                    }
                }
                
                dht_print_r( $post_values );
                
                dht_set_db_settings_option( $settings_id, $post_values );
            }
        }
    }
    
    /**
     *
     * get saved options values
     *
     * @param string $settings_id - get saved options values with this id
     *
     * @return array
     * @since     1.0.0
     */
    private function _getSavedOptions( string $settings_id ) : array {
        
        return dht_get_db_settings_option( $settings_id );
    }
    
    /**----------------------------- helper methods -------------------------------*/
    
    /**
     * register framework option types
     *
     * @return void
     * @since     1.0.0
     */
    private function _registerFWOptionTypes() : void {
        
        //instanciate the option type classes
        $input = new Input();
        $textarea = new Textarea();
        $checkbox = new Checkbox();
        $radio = new Radio();
        $text = new Text();
        $wpeditor = new WpEditor();
        $switchfield = new SwitchField();
        $dropdown = new Dropdown();
        $dropdown_multple = new DropdownMultiple();
        $multiinput = new MultiInput();
        $ace_editor = new AceEditor();
        $colorpicker = new ColorPicker();
        $datepicker = new DatePicker();
        $timepicker = new TimePicker();
        $datetimepicker = new DateTimePicker();
        $rangeslider = new RangeSlider();
        $spacing = new Spacing();
        
        //add class instance to the _optionClasses array to use throughout the Option class methods
        $this->_optionClasses[ $input->getField() ] = $input;
        $this->_optionClasses[ $textarea->getField() ] = $textarea;
        $this->_optionClasses[ $checkbox->getField() ] = $checkbox;
        $this->_optionClasses[ $radio->getField() ] = $radio;
        $this->_optionClasses[ $text->getField() ] = $text;
        $this->_optionClasses[ $wpeditor->getField() ] = $wpeditor;
        $this->_optionClasses[ $switchfield->getField() ] = $switchfield;
        $this->_optionClasses[ $dropdown->getField() ] = $dropdown;
        $this->_optionClasses[ $dropdown_multple->getField() ] = $dropdown_multple;
        $this->_optionClasses[ $multiinput->getField() ] = $multiinput;
        $this->_optionClasses[ $ace_editor->getField() ] = $ace_editor;
        $this->_optionClasses[ $colorpicker->getField() ] = $colorpicker;
        $this->_optionClasses[ $datepicker->getField() ] = $datepicker;
        $this->_optionClasses[ $timepicker->getField() ] = $timepicker;
        $this->_optionClasses[ $datetimepicker->getField() ] = $datetimepicker;
        $this->_optionClasses[ $rangeslider->getField() ] = $rangeslider;
        $this->_optionClasses[ $spacing->getField() ] = $spacing;
    }
    
    /**
     *
     * generate form nonce fields (name and action)
     *
     * @return array
     * @since     1.0.0
     */
    private function _generateNonce() : array {
        
        $nonce = '';
        
        if ( isset( $_POST ) ) {
            $nonce = array_filter( array_keys( $_POST ), function ( $key ) {
                
                return str_contains( $key, '_dht_fw_nonce' );
            } );
            
            $nonce = !empty( $nonce ) ? str_replace( "_name", "", implode( "", $nonce ) ) : '';
        }
        
        $nonce = empty( $nonce ) ? 'dht_' . md5( uniqid( (string)mt_rand(), true ) ) . '_dht_fw_nonce' : $nonce;
        
        return [ 'name' => $nonce . '_name', 'action' => $nonce . '_action' ];
    }
    
}