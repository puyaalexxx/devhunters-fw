<?php
declare( strict_types = 1 );

namespace DHT\Extensions\Options;

if ( !defined( 'DHT_MAIN' ) ) die( 'Forbidden' );

use DHT\Extensions\Options\Options\{AceEditor,
    BaseOption,
    Borders,
    Checkbox,
    ColorPicker,
    DatePicker,
    DateTimePicker,
    Dropdown,
    DropdownMultiple,
    Icon,
    Input,
    MultiInput,
    MultiOptions,
    Radio,
    RadioImage,
    RangeSlider,
    Spacing,
    SwitchField,
    Text,
    Textarea,
    TimePicker,
    Upload,
    UploadGallery,
    UploadImage,
    WpEditor};
use DHT\Helpers\Traits\OptionsHelpers;
use function DHT\fw;
use function DHT\Helpers\{dht_get_db_settings_option, dht_load_view, dht_print_r, dht_set_db_settings_option};

//TODO: for performance reason to merge CSS and Js code somehow for options used in one file
//TODO: display option css and js only on pages where they are used and not across entire admin area
//TODO: minify js files at the end
//TODO: ajax save options instead of refresh
final class Options implements IOptions {
    
    use OptionsHelpers;
    
    //class instances for Singleton Pattern
    private static array $_instances = [];
    
    //extension name
    public string $ext_name = 'options';
    
    //option configurations (received from config/options folder area on init)
    private array $_options = [];
    
    //option type Classes
    private array $_optionClasses = [];
    
    //nonce field
    private array $_nonce = [ 'action' => 'ppht_nonce_action', 'name' => 'ppht_nonce_action' ];
    
    /**
     * @since     1.0.0
     */
    protected function __construct() {
        
        //register the Framework options classes
        $this->_registerFWOptionTypes();
    }
    
    /**
     * !!!NOTE - run this method before calling render to initialize the option types from passed option settings
     *
     * @param array $options - options array passed from plugin
     *
     * @return void
     * @since     1.0.0
     */
    public function initOptions( array $options ) : void {
        
        if ( empty( $options ) ) return;
        
        //set class $options across the instances
        $this->_options = apply_filters( 'dht_options_configurations', $options );
        
        //enqueue the options container scripts
        add_action( 'admin_enqueue_scripts', [ $this, 'enqueueMainAreaScripts' ] );
        
        //set form nonce field
        $this->_nonce = $this->_generateNonce();
        
        //pass option array to enqueue scripts method (this is needed to enqueue specific script for specific subtype option)
        $this->_getEnqueueOptionArgs( $this->_options, $this->_optionClasses );
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
        
        wp_enqueue_script( 'dht-wrapper-area', DHT_ASSETS_URI . 'scripts/js/extensions/options/dht-wrapper-area-script.js', array( 'jquery' ), fw()->manifest->get( 'version' ), true );
        
        // Register the style
        wp_register_style( 'dht-wrapper-area', DHT_ASSETS_URI . 'styles/css/extensions/options/dht-wrapper-area-style.css', array(), fw()->manifest->get( 'version' ) );
        // Enqueue the style
        wp_enqueue_style( 'dht-wrapper-area' );
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
     * @param string $settings_id - the id passed to update_option() function
     *
     * @return void
     * @since     1.0.0
     */
    public function renderOptions( string $settings_id ) : void {
        
        //this wrapper will be used for ajax to load content inside
        echo '<div id="dht-form-wrapper">';
        
        //display nonce field
        wp_nonce_field( $this->_nonce[ 'action' ], $this->_nonce[ 'name' ] );
        
        if ( !empty( $this->_options ) ) {
            
            //get option id prefix
            $options_prefix_id = array_key_first( $this->_options );
            
            //save options
            $this->_saveOptions( $settings_id, $options_prefix_id );
            
            //get saved options
            $saved_values = $this->_getSavedOptions( $settings_id );
            
            //render the passed option types
            foreach ( $this->_options[ $options_prefix_id ] as $option ) {
                
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
            
        } else {
            echo _x( 'No options provided', 'options', PPHT_PREFIX );
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
                foreach ( $this->_options[ $options_prefix_id ] as $option ) {
                    
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
    
    /**
     * register framework option types
     *
     * @return void
     * @since     1.0.0
     */
    private function _registerFWOptionTypes() : void {
        
        //instantiate the option type classes
        $input = new Input();
        $textarea = new Textarea();
        $checkbox = new Checkbox();
        $radio = new Radio();
        $text = new Text();
        $wpeditor = new WpEditor();
        $switch_field = new SwitchField();
        $dropdown = new Dropdown();
        $dropdown_multple = new DropdownMultiple();
        $multi_input = new MultiInput();
        $ace_editor = new AceEditor();
        $colorpicker = new ColorPicker();
        $datepicker = new DatePicker();
        $timepicker = new TimePicker();
        $datetimepicker = new DateTimePicker();
        $range_slider = new RangeSlider();
        $spacing = new Spacing();
        $radio_image = new RadioImage();
        $multi_options = new MultiOptions();
        $borders = new Borders();
        $upload_image = new UploadImage();
        $upload = new Upload();
        $upload_gallery = new UploadGallery();
        $icon = new Icon();
        
        //add class instance to the _optionClasses array to use throughout the Option class methods
        $this->_optionClasses[ $input->getField() ] = $input;
        $this->_optionClasses[ $textarea->getField() ] = $textarea;
        $this->_optionClasses[ $checkbox->getField() ] = $checkbox;
        $this->_optionClasses[ $radio->getField() ] = $radio;
        $this->_optionClasses[ $text->getField() ] = $text;
        $this->_optionClasses[ $wpeditor->getField() ] = $wpeditor;
        $this->_optionClasses[ $switch_field->getField() ] = $switch_field;
        $this->_optionClasses[ $dropdown->getField() ] = $dropdown;
        $this->_optionClasses[ $dropdown_multple->getField() ] = $dropdown_multple;
        $this->_optionClasses[ $multi_input->getField() ] = $multi_input;
        $this->_optionClasses[ $ace_editor->getField() ] = $ace_editor;
        $this->_optionClasses[ $colorpicker->getField() ] = $colorpicker;
        $this->_optionClasses[ $datepicker->getField() ] = $datepicker;
        $this->_optionClasses[ $timepicker->getField() ] = $timepicker;
        $this->_optionClasses[ $datetimepicker->getField() ] = $datetimepicker;
        $this->_optionClasses[ $range_slider->getField() ] = $range_slider;
        $this->_optionClasses[ $spacing->getField() ] = $spacing;
        $this->_optionClasses[ $radio_image->getField() ] = $radio_image;
        $this->_optionClasses[ $multi_options->getField() ] = $multi_options;
        $this->_optionClasses[ $borders->getField() ] = $borders;
        $this->_optionClasses[ $upload_image->getField() ] = $upload_image;
        $this->_optionClasses[ $upload->getField() ] = $upload;
        $this->_optionClasses[ $upload_gallery->getField() ] = $upload_gallery;
        $this->_optionClasses[ $icon->getField() ] = $icon;
    }
    
    /**
     * This is the static method that controls the access to the singleton
     * instance. On the first run, it creates a singleton object and places it
     * into the static field. On subsequent runs, it returns the client existing
     * object stored in the static field.
     *
     *
     * @return self - current class
     * @since     1.0.0
     */
    public static function init() : self {
        
        $cls = static::class;
        if ( !isset( self::$_instances[ $cls ] ) ) {
            self::$_instances[ $cls ] = new static();
        }
        
        return self::$_instances[ $cls ];
    }
    
    /**
     * no possibility to clone this class
     *
     * @return void
     * @since     1.0.0
     */
    protected function __clone() : void {}
    
}