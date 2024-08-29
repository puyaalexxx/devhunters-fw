<?php
declare( strict_types = 1 );

namespace DHT\Extensions\Options;

if ( !defined( 'DHT_MAIN' ) ) die( 'Forbidden' );

use DHT\Extensions\Options\Options\BaseField;
use DHT\Helpers\Traits\Options\{OptionsHelpers, RegisterOptionsHelpers, RenderOptionsHelpers, SaveOptionsHelpers};
use function DHT\fw;
use function DHT\Helpers\{dht_load_view};

final class Options implements IOptions {
    
    use OptionsHelpers;
    use SaveOptionsHelpers;
    use RenderOptionsHelpers;
    use RegisterOptionsHelpers;
    
    //option configurations (received from the plugin config/options folder area)
    private array $_options;
    
    //option type Classes
    private array $_optionFieldsClasses = [];
    
    //option toggle Classes
    private array $_optionTogglesClasses = [];
    
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
        
        //register the Framework options types
        $this->_registerFWOptions();
        
        //enqueue the options container scripts
        add_action( 'admin_enqueue_scripts', [ $this, 'enqueueGeneralScripts' ] );
        
        //enqueue styles/scripts for each option received from the plugin
        $this->_enqueueOptionsScripts( $this->_options, array_merge( $this->_optionFieldsClasses, $this->_optionTogglesClasses, $this->_optionGroupsClasses, $this->_optionContainerClasses ) );
        
        //generate nonce field
        $this->_nonce = $this->_generateNonce();
        
        //get option id prefix (from container options)
        $this->_settings_id = $this->_options[ 'id' ] ?? '';
        
        //save options
        $this->_save( $this->_settings_id );
        
        //render dashboard page form HTML content hook with the passed options
        add_action( 'dht_render_dashboard_page_content', function () {
            
            $this->renderDashBoardPageContent( $this->_options );
        } );
        
        //register post types and pages meta boxes
        add_action( 'add_meta_boxes', [ $this, 'registerPostTypesMetaboxes' ] );
    }
    
    /**
     * Enqueue main wrapper area styles and scripts
     *
     * @param string $hook
     *
     * @return void
     * @since     1.0.0
     */
    public function enqueueGeneralScripts( string $hook ) : void {
        
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
     * @param BaseField $optionClass
     * @param array     $option
     *
     * @return void
     * @since     1.0.0
     */
    public function registerCustomOptionType( BaseField $optionClass, array $option ) : void {
        
        $this->_optionFieldsClasses[ $option[ 'type' ] ] = $optionClass;
    }
    
    /**
     * register post types and pages meta boxes
     *
     * @return void
     * @since     1.0.0
     */
    public function registerPostTypesMetaboxes() : void {
        
        //if more than one metaboxes needs to be registered
        if ( !isset( $this->_options[ 'options' ] ) ) {
            foreach ( $this->_options as $metabox_id => $metabox ) {
                add_meta_box(
                    $metabox_id, // ID of the metabox
                    $metabox[ 'title' ], // Title of the metabox
                    function () use ( $metabox ) {
                        
                        $this->renderPostTypeMetaboxContent( $metabox[ 'options' ] );
                    },
                    $metabox[ 'post-type' ], // Post type
                    $metabox[ 'context' ] ?? 'normal', // Context (normal, side, advanced)
                    $metabox[ 'priority' ] ?? 'high' // Priority (high, core, default, low)
                );
            }
        } else {
            add_meta_box(
                $this->_options[ 'id' ], // ID of the metabox
                $this->_options[ 'title' ], // Title of the metabox
                function () {
                    
                    $this->renderPostTypeMetaboxContent( $this->_options[ 'options' ] );
                },
                $this->_options[ 'post-type' ], // Post type
                $this->_options[ 'context' ] ?? 'normal', // Context (normal, side, advanced)
                $this->_options[ 'priority' ] ?? 'high'  // Priority (high, core, default, low)
            );
        }
        
    }
    
    /**
     * render dashboard page content
     *
     * @param array $options
     *
     * @return void
     * @since     1.0.0
     */
    public function renderDashBoardPageContent( array $options ) : void {
        
        echo dht_load_view( DHT_TEMPLATES_DIR . 'extensions/options/', 'dashboard-page-template.php',
            [
                'nonce' => $this->_nonce,
                'options' => $this->_getOptionsView( $options ),
            ]
        );
    }
    
    /**
     * render dashboard page content
     *
     * @param array $options
     *
     * @return void
     * @since     1.0.0
     */
    public function renderPostTypeMetaboxContent( array $options ) : void {
        
        echo dht_load_view( DHT_TEMPLATES_DIR . 'extensions/options/', 'posts-template.php',
            [
                'nonce' => $this->_nonce,
                'options' => $this->_getOptionsView( $options ),
            ]
        );
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
     * register framework option types
     *
     * @return void
     * @since     1.0.0
     */
    private function _registerFWOptions() : void {
        
        //register the Framework options classes
        $this->_registerFWOptionFields();
        
        //register the Framework toggles classes
        $this->_registerFWOptionToggles();
        
        //register the Framework options group classes
        $this->_registerFWOptionGroups();
        
        //register the Framework options container classes
        $this->_registerFWOptionContainers();
    }
    
}

/*
// Hook to save the metabox data
add_action('save_post', 'popupht_save_metabox_data');
function popupht_save_metabox_data($post_id) {
    // Check if our nonce is set
    if (!isset($_POST['popupht_meta_box_nonce_field'])) {
        return;
    }
    
    // Verify that the nonce is valid
    if (!wp_verify_nonce($_POST['popupht_meta_box_nonce_field'], 'popupht_meta_box_nonce')) {
        return;
    }
    
    // Check if this is an autosave
    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
        return;
    }
    
    // Check the post type
    if (isset($_POST['post_type']) && $_POST['post_type'] === 'popupht') {
        // Check if the user has permission to save data
        if (!current_user_can('edit_post', $post_id)) {
            return;
        }
        
        // Sanitize user input
        $new_value = isset($_POST['popupht_field']) ? sanitize_text_field($_POST['popupht_field']) : '';
        
        // Update the meta field in the database
        update_post_meta($post_id, '_popupht_meta_key', $new_value);
    }
}*/