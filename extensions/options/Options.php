<?php
declare( strict_types = 1 );

namespace DHT\Extensions\Options;

if ( !defined( 'DHT_MAIN' ) ) die( 'Forbidden' );

use DHT\Extensions\Options\groups\groups\{Accordion, AddableBox, Group, Tabs};
use DHT\Extensions\Options\Options\BaseOption;
use DHT\Extensions\Options\Options\fields\{AceEditor,
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
    Typography,
    Upload,
    UploadGallery,
    UploadImage,
    WpEditor};
use DHT\Helpers\Traits\{OptionsHelpers, ValidateConfigurations};
use function DHT\fw;
use function DHT\Helpers\{dht_load_view, dht_print_r, dht_render_option_if_exists, dht_set_db_settings_option};

//TODO: for performance reason to merge CSS and Js code somehow for options used in one file
//TODO: display option css and js only on pages where they are used and not across entire admin area
//TODO: minify js files at the end
//TODO: ajax save options instead of refresh
final class Options implements IOptions {
    
    use OptionsHelpers;
    use ValidateConfigurations;
    
    //option configurations (received from the plugin config/options folder area)
    private array $_options;
    
    //option type Classes
    private array $_optionClasses = [];
    
    //option group Classes
    private array $_optionGroupsClasses = [];
    
    //options id prefix (from container options)
    private string $_settings_id;
    
    //nonce field
    private array $_nonce = [ 'action' => 'ppht_nonce_action', 'name' => 'ppht_nonce_action' ];
    
    /**
     * @param array $options
     *
     * @since     1.0.0
     */
    public function __construct( array $options ) {
        
        $this->_options = $options;
    }
    
    /**
     * initialize plugin options from received settings
     *
     * @return void
     * @since     1.0.0
     */
    public function init() : void {
        
        //register the Framework options classes
        $this->_registerFWOptionTypes();
        
        //register the Framework options group classes
        $this->_registerFWOptionGroups();
        
        //enqueue the options container scripts
        add_action( 'admin_enqueue_scripts', [ $this, 'enqueueFormScripts' ] );
        
        //pass option array to enqueue scripts method (this is needed to enqueue specific script for specific option)
        $this->_getEnqueueOptionArgs( $this->_options, array_merge( $this->_optionClasses, $this->_optionGroupsClasses ) );
        
        //generate nonce field
        $this->_nonce = $this->_generateNonce();
        
        //get option id prefix (from container options)
        $this->_settings_id = $this->_options[ 'id' ] ?? '';
        
        //save options
        $this->_save( $this->_settings_id );
        
        //render dashboard page form HTML content hook
        add_action( 'dht_render_dashboard_page_content', [ $this, 'renderDashBoardPageContent' ] );
    }
    
    /**
     * Enqueue main wrapper area styles and scripts
     *
     * @param string $hook
     *
     * @return void
     * @since     1.0.0
     */
    public function enqueueFormScripts( string $hook ) : void {
        
        wp_enqueue_script( DHT_PREFIX . '-dashboard-page-template', DHT_ASSETS_URI . 'scripts/js/extensions/options/dashboard-page-template-script.js', array( 'jquery' ), fw()->manifest->get( 'version' ), true );
        
        // Register the style
        wp_register_style( DHT_PREFIX . '-dashboard-page-template', DHT_ASSETS_URI . 'styles/css/extensions/options/dashboard-page-template-style.css', array(), fw()->manifest->get( 'version' ) );
        // Enqueue the style
        wp_enqueue_style( DHT_PREFIX . '-dashboard-page-template' );
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
     * render dashboard page content
     *
     * @return void
     * @since     1.0.0
     */
    public function renderDashBoardPageContent() : void {
        
        echo dht_load_view( DHT_TEMPLATES_DIR . 'extensions/options/', 'dashboard-page-template.php',
            [
                'nonce' => $this->_nonce,
                'options' => $this->_getOptionsView(),
            ]
        );
        
        echo '</div>';
    }
    
    /**
     * get options view to render further
     *
     * @return string
     * @since     1.0.0
     */
    private function _getOptionsView() : string {
        
        //get saved options if settings id present
        $saved_values = !empty( $this->_settings_id ) ? $this->_getSavedOptions( $this->_settings_id ) : [];
        
        //render the passed option types
        ob_start();
        foreach ( $this->_options[ 'options' ] as $option ) {
            
            //get option saved value by its id
            $saved_value = $this->_prepareSavedValues( $saved_values, $option[ 'id' ], $this->_settings_id );
            
            //if it is a group type
            if ( array_key_exists( $option[ 'type' ], $this->_optionGroupsClasses ) ) {
                
                //render the respective option group class
                echo $this->_optionGroupsClasses[ $option[ 'type' ] ]->render( $option, $saved_value, $this->_settings_id, $this->_optionClasses );
                
            } else {
                
                //render the respective option type class
                echo dht_render_option_if_exists( $option, $saved_value, $this->_settings_id, $this->_optionClasses );
            }
        }
        
        return ob_get_clean();
    }
    
    /**
     * save options
     *
     * @param string $settings_id - save the options under this settings id
     *
     * @return void
     * @since     1.0.0
     */
    private function _save( string $settings_id ) : void {
        
        if ( isset( $_POST ) && isset( $_POST[ $this->_nonce[ 'name' ] ] )
            && wp_verify_nonce( sanitize_key( wp_unslash( $_POST[ $this->_nonce[ 'name' ] ] ) ), $this->_nonce[ 'action' ] ) ) {
            
            //get options
            $options = $this->_options[ 'options' ] ?? $this->_options;
            
            //if the options are grouped under an id
            if ( !empty( $_POST[ $settings_id ] ) ) {
                
                //for convenience
                $post_values = $_POST[ $settings_id ];
                
                $values = [];
                foreach ( $options as $option ) {
                    
                    if ( array_key_exists( $option[ 'id' ], $_POST[ $settings_id ] ) ) {
                        
                        //if it is a group type
                        if ( isset( $this->_optionGroupsClasses[ $option[ 'type' ] ] ) ) {
                            
                            $values[ $option[ 'id' ] ] = $this->_optionGroupsClasses[ $option[ 'type' ] ]->saveValue( $option, $post_values[ $option[ 'id' ] ], $this->_optionClasses );
                            
                        } //if it is a simple option type
                        else {
                            
                            $values[ $option[ 'id' ] ] = $this->_optionClasses[ $option[ 'type' ] ]->saveValue( $option, $post_values[ $option[ 'id' ] ] );
                        }
                    }
                }
                
                dht_print_r( $values );
                
                dht_set_db_settings_option( $settings_id, $values );
                
            } //if the options are not grouped under an id
            else {
                //pre save option values
                //(each option class has a save method used to change the POST value as needed and then save it)
                //you can change the saved value entirely, sanitize it or replace if you want
                foreach ( $options as $option ) {
                    
                    if ( array_key_exists( $option[ 'id' ], $_POST ) ) {
                        
                        $value = $this->_optionClasses[ $option[ 'type' ] ]->saveValue( $option, $_POST[ $option[ 'id' ] ] );
                        
                        dht_set_db_settings_option( $option[ 'id' ], $value );
                    }
                }
            }
        }
    }
    
    /**
     * register framework option groups
     *
     * @return void
     * @since     1.0.0
     */
    private function _registerFWOptionGroups() : void {
        
        //instantiate the option group classes
        $group = new Group();
        $tabs = new Tabs();
        $accordion = new Accordion();
        $addable_box = new AddableBox();
        
        //add class instance to the _optionClasses array to use throughout the Option class methods
        $this->_optionGroupsClasses[ $group->getGroup() ] = $group;
        $this->_optionGroupsClasses[ $tabs->getGroup() ] = $tabs;
        $this->_optionGroupsClasses[ $accordion->getGroup() ] = $accordion;
        $this->_optionGroupsClasses[ $addable_box->getGroup() ] = $addable_box;
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
        $typography = new Typography();
        
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
        $this->_optionClasses[ $typography->getField() ] = $typography;
    }
    
}