<?php
declare( strict_types = 1 );

namespace DHT\Extensions\Options;

if ( !defined( 'DHT_MAIN' ) ) die( 'Forbidden' );

use DHT\Extensions\Options\Containers\Containers\SideMenu;
use DHT\Extensions\Options\Groups\Groups\{Accordion, AddableBox, Group, Tabs, Toggle};
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
use DHT\Helpers\Traits\Options\{OptionsHelpers, RenderOptionsHelpers, SaveOptionsHelpers};
use function DHT\fw;
use function DHT\Helpers\{dht_get_db_settings_option, dht_load_view};

final class Options implements IOptions {
    
    use OptionsHelpers;
    use SaveOptionsHelpers;
    use RenderOptionsHelpers;
    
    //option configurations (received from the plugin config/options folder area)
    private array $_options;
    
    //option type Classes
    private array $_optionClasses = [];
    
    //option group Classes
    private array $_optionGroupsClasses = [];
    
    //option container Classes
    private array $_optionContainerClasses = [];
    
    //options id prefix (from container options)
    private string $_settings_id;
    
    //nonce field
    private array $_nonce = [ 'action' => 'ppht_nonce_action', 'name' => 'ppht_nonce_action' ];
    
    /**     * @param array $options
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
        
        //register the Framework options container classes
        $this->_registerFWOptionContainers();
        
        //enqueue the options container scripts
        add_action( 'admin_enqueue_scripts', [ $this, 'enqueueFormScripts' ] );
        
        //enqueue scripts for each option received from the plugin
        $this->_getEnqueueOptionArgs( $this->_options, array_merge( $this->_optionClasses, $this->_optionGroupsClasses, $this->_optionContainerClasses ) );
        
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
     * Generates the HTML view for the options.
     *
     * This method retrieves the saved options, determines the type of options being rendered,
     * and generates the appropriate HTML output. It handles both container types and group/option types.
     *
     *
     * @return string
     * @since     1.0.0
     */
    private function _getOptionsView() : string {
        
        //get saved options if settings id present
        $saved_values = !empty( $this->_settings_id ) ? dht_get_db_settings_option( $this->_settings_id ) : [];
        
        // Start output buffering
        ob_start();
        
        // Check if the options are of container type
        if ( isset( $this->_options[ 'pages' ] ) ) {
            // Render container types
            $this->_renderContainerOptions( $saved_values );
        } else {
            // Render group or option types
            $this->_renderGroupOrOptionTypes( $saved_values );
        }
        
        // Return the generated HTML view
        return ob_get_clean();
    }
    
    /**
     * Saves the settings based on the provided settings ID.
     *
     * This method handles both grouped and ungrouped options, validates the nonce,
     * and processes the POST data to save settings. It delegates specific processing
     * tasks to other methods to improve readability and maintainability.
     *
     * @param string $settings_id The ID of the settings to be saved.
     *
     * @return void
     * @since     1.0.0
     */
    private function _save( string $settings_id ) : void {
        
        if ( $this->_isValidRequest() ) {
            $options = $this->_getOptions();
            $post_values = $_POST[ $settings_id ] ?? null;
            
            if ( $post_values ) {
                $this->_handleGroupedOptions( $options, $post_values, $settings_id );
            } else {
                $this->_handleUngroupedOptions( $options );
            }
        }
    }
    
    /**
     * register framework option containers
     *
     * @return void
     * @since     1.0.0
     */
    private function _registerFWOptionContainers() : void {
        
        //instantiate the option group classes
        $sidemenu = new SideMenu( $this->_optionGroupsClasses, $this->_optionClasses );
        
        //add class instance to the _optionContainerClasses array to use throughout the Container class methods
        $this->_optionContainerClasses[ $sidemenu->getContainer() ] = $sidemenu;
    }
    
    /**
     * register framework option groups
     *
     * @return void
     * @since     1.0.0
     */
    private function _registerFWOptionGroups() : void {
        
        //instantiate the option group classes
        $group = new Group( $this->_optionClasses );
        $tabs = new Tabs( $this->_optionClasses );
        $accordion = new Accordion( $this->_optionClasses );
        $addable_box = new AddableBox( $this->_optionClasses );
        $toggle = new Toggle( $this->_optionClasses );
        
        //add class instance to the _optionGroupClasses array to use throughout the Group class methods
        $this->_optionGroupsClasses[ $group->getGroup() ] = $group;
        $this->_optionGroupsClasses[ $tabs->getGroup() ] = $tabs;
        $this->_optionGroupsClasses[ $accordion->getGroup() ] = $accordion;
        $this->_optionGroupsClasses[ $addable_box->getGroup() ] = $addable_box;
        $this->_optionGroupsClasses[ $toggle->getGroup() ] = $toggle;
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