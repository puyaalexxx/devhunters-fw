<?php
declare( strict_types = 1 );

namespace DHT\Extensions\Options;

if ( !defined( 'DHT_MAIN' ) ) die( 'Forbidden' );

use DHT\Extensions\Options\Groups\Groups\{Group, Tabs};
use DHT\Extensions\Options\Options\BaseOption;
use DHT\Extensions\Options\Options\Fields\{AceEditor,
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
use DHT\Helpers\Traits\OptionsHelpers;
use function DHT\fw;
use function DHT\Helpers\{dht_get_db_settings_option,
    dht_print_r,
    dht_render_option_if_exists,
    dht_set_db_settings_option};

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

    //option group Classes
    private array $_optionGroupsClasses = [];

    //nonce field
    private array $_nonce = [ 'action' => 'ppht_nonce_action', 'name' => 'ppht_nonce_action' ];

    /**
     * @since     1.0.0
     */
    protected function __construct() {

        //register the Framework options classes
        $this->_registerFWOptionTypes();

        //register the Framework options group classes
        $this->_registerFWOptionGroups();
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

        //enqueue the options container scripts
        add_action( 'admin_enqueue_scripts', [ $this, 'enqueueMainAreaScripts' ] );

        //set class $options across the instances
        $this->_options = apply_filters( 'dht_options_configurations', $options );

        //set form nonce field
        $this->_nonce = $this->_generateNonce();

        //pass option array to enqueue scripts method (this is needed to enqueue specific script for specific subtype option)
        $this->_getEnqueueOptionArgs( $this->_options, array_merge( $this->_optionClasses, $this->_optionGroupsClasses ) );
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

        wp_enqueue_script( DHT_PREFIX . '-wrapper-area', DHT_ASSETS_URI . 'scripts/js/extensions/options/dht-wrapper-area-script.js', array( 'jquery' ), fw()->manifest->get( 'version' ), true );

        // Register the style
        wp_register_style( DHT_PREFIX . '-wrapper-area', DHT_ASSETS_URI . 'styles/css/extensions/options/dht-wrapper-area-style.css', array(), fw()->manifest->get( 'version' ) );
        // Enqueue the style
        wp_enqueue_style( DHT_PREFIX . '-wrapper-area' );
    }

    /**
     * Enqueue react app files for options
     *
     * @param string $hook
     *
     * @return bool
     * @since     1.0.0
     */
    public function enqueueReactAppScripts( string $hook ) : bool {

        /*$is_main_dashboard = $hook === 'index.php';
        
        // Only load react app scripts in main admin page.
        if ( !$is_main_dashboard )
            return false;*/

        // Setting path variables.
        $dist_react_app_dir = DHT_REACT_APP_DIR . 'dist-react-app/';
        $dist_react_app_uri = DHT_REACT_APP_URI . 'dist-react-app/';
        $manifest_path = $dist_react_app_dir . '.vite/manifest.json';

        // Request manifest file.
        $request = file_get_contents( $manifest_path );

        // If the remote request fails, wp_remote_get() will return a WP_Error, so let’s check if the $request variable is an error:
        if ( !$request )
            return false;

        // Convert json to php array.
        $files_data = json_decode( $request, true );
        if ( $files_data === null )
            return false;

        //check if this is the entry point of the React application
        $entry_point = isset( $files_data[ 'index.html' ] ) && $files_data[ 'index.html' ][ 'isEntry' ] ? $files_data[ 'index.html' ] : '';
        if ( !$entry_point ) {
            return false;
        }

        // Get assets links.
        //make sure the js files are always in array
        $entry_point_js_files = is_array( $entry_point[ 'file' ] ) ? $entry_point[ 'file' ] : array( $entry_point[ 'file' ] );
        $js_files = array_filter( $entry_point_js_files, array( $this, '_filter_js_files' ) );
        $css_files = array_filter( $entry_point[ 'css' ], array( $this, '_filter_css_files' ) );

        // Load css files.
        foreach ( $css_files as $index => $css_file ) {
            wp_enqueue_style(
                DHT_PREFIX . '-react-app-' . $index,
                $dist_react_app_uri . $css_file,
                array(),
                filemtime( $dist_react_app_dir . $css_file ),
            );
        }

        // Load js files.
        foreach ( $js_files as $index => $js_file ) {
            wp_enqueue_script(
                DHT_PREFIX . '-react-app-' . $index,
                $dist_react_app_uri . $js_file,
                array(),
                filemtime( $dist_react_app_dir . $js_file ),
                true
            );
        }

        // Variables for app use.
        wp_localize_script( DHT_PREFIX . '-react-app-0', 'dht_options_selector',
            array( 'optionsAppSelector' => 'dht-wrapper-options-render-area' )
        );

        return true;
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
     * @return void
     * @since     1.0.0
     */
    public function renderOptions() : void {

        //display nonce field
        wp_nonce_field( $this->_nonce[ 'action' ], $this->_nonce[ 'name' ] );

        ?>

        <div class="cosidebar">
            <ul>
                <li>
                    <a href="index.html">
                        <span class="fa fa-tachometer"></span>
                        <span class="title">
        General Settings
        </span>
                    </a>
                </li>
                <li class="active">
                    <a href="#">
                        <span class="fa fa-thumb-tack"></span>
                        <span class="title">
        Posts
                    </span>
                    </a>
                    <ul class="sub-menu">
                        <li class="active">
                            <a href="posts.html">
                                All Posts
                            </a>
                        </li>
                        <li>
                            <a href="new-post.html">
                                Add New
                            </a>
                        </li>
                        <li>
                            <a href="#">
                                Categories
                            </a>
                        </li>
                        <li>
                            <a href="#">
                                Tags
                            </a>
                        </li>
                    </ul>
                </li>
                <li>
                    <a href="#">
                        <span class="fa fa-plug"></span>
                        <span class="title">
        Plugins
                </span>
                    </a>
                    <ul class="sub-menu">
                        <li>
                            <a href="#">
                                Installed Plugins
                            </a>
                        </li>
                        <li>
                            <a href="#">
                                Add New
                            </a>
                        </li>
                        <li>
                            <a href="#">
                                Editor
                            </a>
                        </li>
                    </ul>
                </li>
                <li>
                    <a href="#">
                        <span class="fa fa-wrench"></span>
                        <span class="title">
        Tools
                </span>
                    </a>
                </li>
            </ul>

        </div>

        <?php

        //this wrapper will be used for ajax to load content inside
        echo '<div class="dht-container-options">';

        //get options (from the container if exists or leave them as it is)
        $options = $this->_options[ 'options' ] ?? $this->_options;

        if ( !empty( $options ) ) {

            //get option id prefix (from container options)
            $settings_id = $this->_options[ 'id' ] ?? '';

            //save options
            $this->_saveOptions( $settings_id );

            //get saved options if settings id present
            $saved_values = !empty( $settings_id ) ? $this->_getSavedOptions( $settings_id ) : [];

            //render the passed option types
            foreach ( $options as $option ) {

                //get option saved value by its id
                $saved_value = $this->_prepareSavedValues( $saved_values, $option[ 'id' ], $settings_id );

                //if it is a group type
                if ( array_key_exists( $option[ 'type' ], $this->_optionGroupsClasses ) ) {

                    //render the respective option group class
                    echo $this->_optionGroupsClasses[ $option[ 'type' ] ]->render( $option, $saved_value, $settings_id, $this->_optionClasses );

                } else {

                    //render the respective option type class
                    echo dht_render_option_if_exists( $option, $saved_value, $settings_id, $this->_optionClasses );
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
     * @param string $settings_id - save the options under this settings id
     *
     * @return void
     * @since     1.0.0
     */
    private function _saveOptions( string $settings_id ) : void {

        if ( isset( $_POST ) && isset( $_POST[ $this->_nonce[ 'name' ] ] )
            && wp_verify_nonce( sanitize_key( wp_unslash( $_POST[ $this->_nonce[ 'name' ] ] ) ), $this->_nonce[ 'action' ] ) ) {

            //get options
            $options = $this->_options[ 'options' ] ?? $this->_options;

            //if the options are grouped under an id
            if ( !empty( $_POST[ $settings_id ] ) ) {

                //for convenience
                $post_values = $_POST[ $settings_id ];

                //pre save option values
                //(each option class has a save method used to change the POST value as needed and then save it)
                //you can change the saved value entirely, sanitize it or replace if you want

                $values = [];
                foreach ( $options as $option ) {

                    if ( array_key_exists( $option[ 'id' ], $_POST[ $settings_id ] ) ) {

                        //if it is a group type
                        if ( isset( $this->_optionGroupsClasses[ $option[ 'type' ] ] ) ) {

                            foreach ( $option[ 'options' ] as $group_option ) {

                                //check if the option id is present in the $_POST group values
                                if ( !isset( $post_values[ $option[ 'id' ] ][ $group_option[ 'id' ] ] ) ) continue;

                                $values[ $option[ 'id' ] ][ $group_option[ 'id' ] ] =
                                    $this->_optionClasses[ $group_option[ 'type' ] ]->saveValue( $group_option, $post_values[ $option[ 'id' ] ][ $group_option[ 'id' ] ] );
                            }
                        } else {

                            //if it is a simple option type
                            $values[ $option[ 'id' ] ] = $this->_optionClasses[ $option[ 'type' ] ]->saveValue( $option, $post_values[ $option[ 'id' ] ] );
                        }
                    }
                }

                dht_print_r( $values );

                dht_set_db_settings_option( $settings_id, $values );

            } else {
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
     *
     *
     * get saved options values
     *
     * @param string $settings_id - get saved options values with this id
     *
     * @return mixed
     * @since     1.0.0
     */
    private function _getSavedOptions( string $settings_id ) : mixed {

        return dht_get_db_settings_option( $settings_id );
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

        //add class instance to the _optionClasses array to use throughout the Option class methods
        $this->_optionGroupsClasses[ $group->getGroup() ] = $group;
        $this->_optionGroupsClasses[ $tabs->getGroup() ] = $tabs;
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