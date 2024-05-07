<?php
declare( strict_types = 1 );

namespace DHT\Extensions\Options;

if ( !defined( 'DHT_MAIN' ) ) die( 'Forbidden' );

use DHT\Extensions\Options\Options\{Checkbox, Input, Radio, Text, Textarea, WpEditor};
use DHT\Extensions\Options\Options\BaseOption;
use DHT\Helpers\Exceptions\ConfigExceptions\EmptyOptionsConfigurationsException;
use function DHT\fw;
use function DHT\Helpers\{dht_get_db_settings_option, dht_load_view, dht_print_r, dht_set_db_settings_option};

//TODO: at the end to add CSS styles in post css folder as sass
//TODO: at the end to add js as typescript code
//TODO: for performance reason to merge CSS and Js code somehow for options used in one file
final class Options implements IOptions {
    
    //passed options
    private array $_options = [];
    
    //nonce fields (name and action)
    private array $_nonce;
    
    /**
     * @since     1.0.0
     */
    public function __construct() {
        
        add_action( 'admin_enqueue_scripts', [ $this, 'enqueueMainAreaScripts' ] );
        
        //register framework Option Types
        $this->_registerFWOptionTypes();
        
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
     *
     * create custom option types located outside the framework
     *
     * @param BaseOption $optionClass
     *
     * @return void
     * @since     1.0.0
     */
    public function registerCustomOptionType( BaseOption $optionClass ) : void {
        
        $this->_options[ $optionClass::init()->getField() ] = $optionClass::init();
    }
    
    /**
     *
     * render options passed from the plugin
     *
     * @param array  $options           - option fields
     * @param string $settings_id       - the id passed to update_option() function
     * @param string $options_prefix_id - options prefix id
     *
     * @return void
     * @throws EmptyOptionsConfigurationsException
     * @since     1.0.0
     */
    public function renderOptions( array $options, string $settings_id, string $options_prefix_id = '' ) : void {
        
        //validate options passed from plugin
        $options = $this->_validateOptionsConfigurations( $options );
        
        //save options
        $this->_saveOptions( $options, $settings_id, $options_prefix_id );
        
        //get saved options
        $saved_values = $this->_getSavedOptions( $settings_id );
        
        //this wrapper will be used for ajax to load content inside
        echo '<div id="dht-form-wrapper">';
        
        //display nonce field
        wp_nonce_field( $this->_nonce[ 'action' ], $this->_nonce[ 'name' ] );
        
        //render the passed option types
        foreach ( $options as $option ) {
            
            if ( array_key_exists( $option[ 'type' ], $this->_options ) ) {
                
                //if this option id has a saved value
                $saved_value = $saved_values[ $option[ 'id' ] ] ?? [];
                
                //merge default values with saved ones to display the saved ones
                $option = $this->_options[ $option[ 'type' ] ]->mergeValues( $option, $saved_value );
                
                //add option prefix id
                $option = $this->_options[ $option[ 'type' ] ]->addIDPrefix( $option, $options_prefix_id );
                
                //render the respective option type class
                echo $this->_options[ $option[ 'type' ] ]->render( $option );
                
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
     * @param array  $options
     * @param string $settings_id       - save the options under this settings id
     * @param string $options_prefix_id - all options are saved under this array key
     *
     * @return void
     * @since     1.0.0
     */
    private function _saveOptions( array $options, string $settings_id, string $options_prefix_id ) : void {
        
        if ( isset( $_POST ) && isset( $_POST[ $this->_nonce[ 'name' ] ] )
            && wp_verify_nonce( sanitize_key( wp_unslash( $_POST[ $this->_nonce[ 'name' ] ] ) ), $this->_nonce[ 'action' ] ) ) {
            
            if ( !empty( $_POST[ $options_prefix_id ] ) ) {
                
                $post_values = $_POST[ $options_prefix_id ];
                
                //pre save option values
                //(each option class has a save method used to change the POST value as needed and then save it)
                //you can change the saved value entirely, sanitize it or replace if you want
                foreach ( $options as $option ) {
                    
                    if ( array_key_exists( $option[ 'id' ], $post_values ) ) {
                        
                        $post_values[ $option[ 'id' ] ] = $this->_options[ $option[ 'type' ] ]->saveValue( $option, $post_values[ $option[ 'id' ] ] );
                    }
                }
                
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
     *
     * register framework option types
     *
     * @return void
     * @since     1.0.0
     */
    private function _registerFWOptionTypes() : void {
        
        $this->_options[ Input::init()->getField() ] = Input::init();
        $this->_options[ Textarea::init()->getField() ] = Textarea::init();
        $this->_options[ Checkbox::init()->getField() ] = Checkbox::init();
        $this->_options[ Radio::init()->getField() ] = Radio::init();
        $this->_options[ Text::init()->getField() ] = Text::init();
        $this->_options[ WpEditor::init()->getField() ] = WpEditor::init();
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