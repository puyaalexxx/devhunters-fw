<?php
declare( strict_types = 1 );

namespace DHT\Extensions\Options;

if ( !defined( 'DHT_MAIN' ) ) die( 'Forbidden' );

use DHT\Extensions\Options\Options\BaseField;
use DHT\Helpers\Traits\Options\{EnqueueOptionsHelpers,
    OptionsHelpers,
    RegisterOptionsHelpers,
    RenderOptionsHelpers,
    SaveOptionsHelpers};
use WP_Post;
use function DHT\fw;
use function DHT\Helpers\{dht_load_view};

final class Options implements IOptions {
    
    use OptionsHelpers;
    use SaveOptionsHelpers;
    use RenderOptionsHelpers;
    use RegisterOptionsHelpers;
    use EnqueueOptionsHelpers;
    
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
        
        //generate nonce field
        $this->_nonce = $this->_generateNonce();
        
        //enqueue settings
        {
            //enqueue the options container scripts
            add_action( 'admin_enqueue_scripts', [ $this, 'enqueueGeneralScripts' ] );
            //enqueue styles/scripts for each option received from the plugin
            $this->_enqueueOptionsScripts( $this->_options, array_merge( $this->_optionFieldsClasses, $this->_optionTogglesClasses, $this->_optionGroupsClasses, $this->_optionContainerClasses ) );
        }
        
        //render dashboard page form HTML content hook with the passed options
        add_action( 'dht_render_dashboard_page_content', function () {
            
            //save dashboard pages options
            $this->_saveDashBoardPageOptions();
            
            $this->renderDashBoardPageContent( $this->_options );
        } );
        
        //post types related functionality
        {
            //save post type metaboxes options
            add_action( 'save_post', [ $this, 'savePostTypeOptions' ], 999, 2 );
            //register post types and pages meta boxes
            add_action( 'add_meta_boxes', [ $this, 'registerPostTypeMetaboxes' ] );
        }
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
    public function registerPostTypeMetaboxes() : void {
        
        //if more than one metaboxes needs to be registered
        if ( !isset( $this->_options[ 'options' ] ) && !isset( $this->_options[ 'type' ] ) ) {
            
            $count = 0;
            foreach ( $this->_options as $metabox ) {
                
                $metabox_id = 'dht-fw-metabox-id-' . ++$count;
                
                add_meta_box(
                    $metabox_id, // ID of the metabox
                    $metabox[ 'title' ], // Title of the metabox
                    function ( $post ) use ( $metabox, $metabox_id ) {
                        
                        $metabox[ 'id' ] = $metabox_id;
                        $this->renderPostTypeMetaboxContent( $metabox, $post->ID );
                    },
                    $metabox[ 'post-type' ], // Post type
                    $metabox[ 'context' ] ?? 'normal', // Context (normal, side, advanced)
                    $metabox[ 'priority' ] ?? 'high' // Priority (high, core, default, low)
                );
            }
        } else {
            $metabox_id = 'dht-fw-metabox-id-1';
            
            add_meta_box(
                $metabox_id, // ID of the metabox
                $this->_options[ 'title' ], // Title of the metabox
                function ( $post ) use ( $metabox_id ) {
                    
                    $this->_options[ 'id' ] = $metabox_id;
                    $this->renderPostTypeMetaboxContent( $this->_options, $post->ID );
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
     * @return void
     * @since     1.0.0
     */
    public function renderDashBoardPageContent() : void {
        
        echo dht_load_view( DHT_TEMPLATES_DIR . 'extensions/options/', 'dashboard-page-template.php',
            [
                'nonce' => $this->_nonce,
                'options' => $this->_getOptionsView( $this->_options ),
            ]
        );
    }
    
    /**
     * render dashboard page content
     *
     * @param array $options options array
     * @param int   $post_id
     *
     * @return void
     * @since     1.0.0
     */
    public function renderPostTypeMetaboxContent( array $options, int $post_id ) : void {
        
        echo dht_load_view( DHT_TEMPLATES_DIR . 'extensions/options/', 'posts-template.php',
            [
                'nonce' => $this->_nonce,
                'options' => $this->_getOptionsView( $options, 'post', $post_id ),
            ]
        );
    }
    
    /**
     * Saves the dashboard page options based on the provided settings ID.
     *
     * This method handles both grouped and ungrouped options, validates the nonce,
     * and processes the POST data to save settings. It delegates specific processing
     * tasks to other methods to improve readability and maintainability.
     *
     *
     * @return void
     * @since     1.0.0
     */
    private function _saveDashBoardPageOptions() : void {
        
        if ( $this->_isValidRequest() ) {
            
            $post_values = $_POST[ $this->_options[ 'id' ] ?? '' ] ?? null;
            
            if ( $post_values ) {
                $this->_handleContainerOptions( $this->_options, $post_values, $this->_options[ 'id' ] );
            } else {
                $this->_handleUngroupedOptions( $this->_options );
            }
        }
    }
    
    /**
     * Saves post options settings based on its id
     *
     * This method handles the post saving options, it is used in the save_post hook, validates the nonce,
     * and processes the POST data to save settings. It delegates specific processing
     * tasks to other methods to improve readability and maintainability.
     *
     * @param int     $post_id saved post id
     * @param WP_Post $post    saved post
     *
     * @return void
     * @since     1.0.0
     */
    public function savePostTypeOptions( int $post_id, WP_Post $post ) : void {
        
        //check nonce field
        if ( $this->_isValidRequest() ) {
            
            if ( !current_user_can( 'edit_post', $post_id ) ) {
                return;
            }
            
            // Check if this is an autosave
            if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
                return;
            }
            
            // check post type
            if ( isset( $_POST[ 'post_type' ] ) && $post->post_type != $_POST[ 'post_type' ] ) {
                return;
            }
            
            //save metaboxes options
            if ( isset( $_POST ) ) {
                foreach ( $_POST as $key => $value ) {
                    if ( str_contains( $key, 'dht-fw-metabox-id' ) ) {
                        $this->_handleContainerOptions( $this->_options, $value, $key, 'post', $post_id );
                    }
                }
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