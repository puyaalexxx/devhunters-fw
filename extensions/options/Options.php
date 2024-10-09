<?php
declare( strict_types = 1 );

namespace DHT\Extensions\Options;

if ( ! defined( 'DHT_MAIN' ) ) {
	die( 'Forbidden' );
}

use DHT\Extensions\Options\Fields\BaseField;
use DHT\Helpers\Classes\Environment;
use DHT\Helpers\Traits\Options\{EnqueueOptionsHelpers,
	OptionsHelpers,
	RegisterOptionsHelpers,
	RenderOptionsHelpers,
	SaveOptionsHelpers};
use WP_Post;
use function DHT\dht;
use function DHT\Helpers\{dht_get_current_admin_post_type, dht_get_current_admin_taxonomy_from_url, dht_load_view};

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
	private array $_nonce = [
		'action' => DHT_PREFIX . '_nonce_action',
		'name'   => DHT_PREFIX . 'ppht_nonce_action'
	];
	
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
			$this->_enqueueOptionsScripts( apply_filters( 'dht_options_enqueue_option_scripts', $this->_options ) );
		}
		
		//render dashboard page form HTML content hook with the passed options
		add_action( 'dht_render_dashboard_page_content', function() {
			//save dashboard pages options
			$this->_saveDashBoardPageOptions();
			
			$this->renderContent( apply_filters( 'dht_options_dashboard_page_options', $this->_options ) );
		} );
		
		//post types related functionality
		{
			//save post type metaboxes options
			add_action( 'save_post', [ $this, 'savePostTypeOptions' ], 999, 2 );
			
			//register post types and pages meta boxes
			add_action( 'add_meta_boxes', [ $this, 'registerPostTypeMetaboxes' ] );
		}
		
		//taxonomies related functionality
		{
			$current_taxonomy = dht_get_current_admin_taxonomy_from_url();
			
			add_action( $current_taxonomy . '_edit_form', function( $term ) {
				$this->renderContent( apply_filters( 'dht_options_term_options', $this->_options ), 'term', $term->term_id );
			}, 999 );
			
			add_action( 'edited_' . $current_taxonomy, [ $this, 'saveTermOptions' ], 999 );
		}
		
		//vb related functionality
		{
			//render visual builder modal HTML content hook with the passed options
			add_action( 'dht_vb_render_modal_content', function( int $postID, string $modalType ) {
				$this->renderContent( apply_filters( 'dht_options_vb_modal_options', $this->_options ), "vb", $postID );
			}, 10, 2 );
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
		
		if ( Environment::isDevelopment() ) {
			wp_register_style( DHT_PREFIX_CSS . '-dashboard-page', DHT_ASSETS_URI . 'dist/css/dashboard-page.css', array(), dht()->manifest->get( 'version' ) );
			wp_enqueue_style( DHT_PREFIX_CSS . '-dashboard-page' );
			
			wp_enqueue_script( DHT_PREFIX_JS . '-dashboard-page', DHT_ASSETS_URI . 'dist/js/dashboard-page.js', array( 'jquery' ), dht()->manifest->get( 'version' ), true );
		}
	}
	
	/**
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
		
		$post_type = dht_get_current_admin_post_type();
		
		$options = apply_filters( 'dht_options_post_type_options', $this->_options );
		
		// Determine if multiple metaboxes need to be registered
		$metaboxes = isset( $options[ 'options' ] ) ? [ $options ] : $options;
		
		// Initialize counter for unique metabox IDs
		$count = 0;
		// Loop through each metabox configuration
		foreach ( $metaboxes as &$metabox ) {
			$count ++;
			$metabox_id = 'dht-fw-metabox-id-' . $count;
			// Set metabox ID and options ID
			$metabox[ 'options_id' ] = $metabox[ 'id' ];
			$metabox[ 'id' ]         = $metabox_id . '[' . $metabox[ 'options_id' ] . ']';
			//used to not adding the class to the containers because it is added to metabox
			$metabox[ 'area' ] = 'metabox';
			
			// Register the metabox
			add_meta_box( $metabox_id, // ID of the metabox
				$metabox[ 'title' ], // Title of the metabox
				function( $post ) use ( $metabox ) {
					
					$this->renderContent( $metabox, 'post', $post->ID );
				}, $post_type, // Post type
				$metabox[ 'context' ] ?? 'normal', // Context (normal, side, advanced)
				$metabox[ 'priority' ] ?? 'high'  // Priority (high, core, default, low)
			);
			
			// Add custom class to the postbox area
			$this->_addMetaboxCustomClass( $metabox, $post_type, $metabox_id );
		}
	}
	
	/**
	 * Render content for dashboard pages, metaboxes and terms area.
	 *
	 * @param array  $options  Options array.
	 * @param string $location Where to save the data - dashboard/post or term
	 * @param int    $id       The post or term ID if rendering post type metabox content or term fields.
	 *
	 * @return void
	 * @since 1.0.0
	 */
	public function renderContent( array $options, string $location = 'dashboard', int $id = 0 ) : void {
		
		$template = apply_filters( 'dht_options_get_options_template_file', $this->_getOptionsTemplate( $location ) );
		
		$viewData = [
			'nonce'   => apply_filters( 'dht_options_get_options_get_nonce_field', $this->_nonce ),
			'options' => apply_filters( 'dht_options_get_options_view_html', $this->_getOptionsView( $options, $location, $id ) ),
		];
		
		//add 'metabox_id' if it exists
		if ( isset( $options[ 'options_id' ] ) ) {
			$viewData[ 'metabox_id' ] = $options[ 'options_id' ];
		}
		
		if ( $location == 'vb' ) {
			echo dht_load_view( DHT_VIEWS_DIR . 'core/vb/', $template, $viewData );
		} else {
			echo dht_load_view( DHT_VIEWS_DIR . 'extensions/options/', $template, $viewData );
		}
	}
	
	/**
	 * Save dashboard page options based on the provided settings ID.
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
			
			$post_values = $_POST[ $this->_options[ 'id' ] ?? '' ] ?? NULL;
			
			if ( $post_values ) {
				$this->_handleContainerOptions( $this->_options, $post_values );
			} else {
				$this->_handleUngroupedOptions( $this->_options );
			}
		}
	}
	
	/**
	 * Save term option based on the provided settings ID.
	 *
	 * This method handles both grouped and ungrouped options, validates the nonce,
	 * and processes the POST data to save settings. It delegates specific processing
	 * tasks to other methods to improve readability and maintainability.
	 *
	 *
	 * @param int $term_id Term ID
	 *
	 * @return void
	 * @since     1.0.0
	 */
	public function saveTermOptions( int $term_id ) : void {
		
		if ( $this->_isValidRequest() ) {
			
			$post_values = $_POST[ $this->_options[ 'id' ] ?? '' ] ?? NULL;
			
			//check for the container id
			if ( $post_values ) {
				$this->_handleContainerOptions( $this->_options, $post_values, 'term', $term_id );
			}
		}
	}
	
	/**
	 * Save post options settings based on its id
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
			
			if ( ! current_user_can( 'edit_post', $post_id ) ) {
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
				foreach ( $_POST as $metabox_id => $values ) {
					if ( str_contains( $metabox_id, 'dht-fw-metabox-id' ) ) {
						//many metaboxes
						if ( ! isset( $this->_options[ 'options' ] ) ) {
							foreach ( $this->_options as $options ) {
								if ( isset( $values[ $options[ 'id' ] ] ) ) {
									$this->_handleContainerOptions( $options, $values[ $options[ 'id' ] ], 'post', $post_id );
								}
							}
						} else {
							$this->_handleContainerOptions( $this->_options, $values[ $this->_options[ 'id' ] ], 'post', $post_id );
						}
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