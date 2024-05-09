<?php
declare( strict_types = 1 );

namespace DHT\Extensions\Options;

if ( !defined( 'DHT_MAIN' ) ) die( 'Forbidden' );

use DHT\Extensions\Options\Options\{AceEditor,
    BaseOption,
    Checkbox,
    ColorPicker,
    Dropdown,
    DropdownMultiple,
    Input,
    MultiInput,
    Radio,
    SwitchField,
    Text,
    Textarea,
    WpEditor};
use DHT\Helpers\Exceptions\ConfigExceptions\EmptyOptionsConfigurationsException;
use function DHT\fw;
use function DHT\Helpers\{dht_get_db_settings_option, dht_load_view, dht_set_db_settings_option};

//TODO: at the end to add CSS styles in post css folder as sass
//TODO: at the end to add js as typescript code
//TODO: for performance reason to merge CSS and Js code somehow for options used in one file
//TODO: display option css and js only on pages where they are used and not across entire admin area
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
     * !!!NOTE - run this method before calling render to initialize the option types
     * register framework option types with passed option settings
     *
     * @param array $options
     *
     * @return void
     * @since     1.0.0
     */
    public function registerOptionTypes( array $options ) : void {
        
        // set class options array with passed plugin configurations
        $this->_options = $options;
        
        //register the Framework options classes
        $this->_registerOptionTypes();
    }
    
    /**
     *
     * create custom option types located outside the framework
     *
     * @param BaseOption $optionClass
     * @param array      $option
     *
     * @return void
     * @since     1.0.0
     */
    public function registerCustomOptionType( BaseOption $optionClass, array $option ) : void {
        
        $this->_optionClasses[ $option[ 'type' ] ] = $optionClass::init( $option );
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
                
                \DHT\Helpers\dht_print_r( $post_values );
                
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
     * register option types from the options config array
     *
     * @return void
     * @since     1.0.0
     */
    private function _registerOptionTypes() : void {
        
        foreach ( $this->_options as $option ) {
            
            //initialize option type classes that are required by the option configurations
            $this->_optionClasses [ $option[ 'type' ] ] = match ( $option[ 'type' ] ) {
                
                Input::init( $option )->getField() => Input::init( $option ),
                Textarea::init( $option )->getField() => Textarea::init( $option ),
                Checkbox::init( $option )->getField() => Checkbox::init( $option ),
                Radio::init( $option )->getField() => Radio::init( $option ),
                Text::init( $option )->getField() => Text::init( $option ),
                WpEditor::init( $option )->getField() => WpEditor::init( $option ),
                SwitchField::init( $option )->getField() => SwitchField::init( $option ),
                Dropdown::init( $option )->getField() => Dropdown::init( $option ),
                DropdownMultiple::init( $option )->getField() => DropdownMultiple::init( $option ),
                MultiInput::init( $option )->getField() => MultiInput::init( $option ),
                AceEditor::init( $option )->getField() => AceEditor::init( $option ),
                ColorPicker::init( $option )->getField() => ColorPicker::init( $option )
            };
        }
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
    
    /**
     *
     * validate the options configurations received from plugin
     *
     * @param array $options_config
     *
     * @return array
     * @throws EmptyOptionsConfigurationsException
     * @since     1.0.0
     */
    private function _validateOptionsConfigurations( array $options_config ) : array {
        
        if ( !empty( $options_config ) ) {
            
            return apply_filters( 'options_configurations', $options_config );
        } else {
            
            throw new EmptyOptionsConfigurationsException( _x( 'Empty options configurations array', 'exceptions', DHT_PREFIX ) );
        }
    }
    
}