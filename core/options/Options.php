<?php
declare( strict_types = 1 );

namespace DHT\Core\Options;

if( !defined( 'DHT_MAIN' ) ) {
	die( 'Forbidden' );
}

use DHT\Core\Options\Fields\BaseField;
use DHT\DHT;
use DHT\Helpers\Classes\Environment;
use DHT\Helpers\Traits\Options\{EnqueueOptionsHelpers,
	OptionsHelpers,
	RegisterOptionsHelpers,
	RenderOptionsHelpers,
	SaveOptionsHelpers};
use WP_Post;
use function DHT\Helpers\{dht_get_current_admin_taxonomy_from_url};

final class Options implements IOptions {
	
	use OptionsHelpers;
	use SaveOptionsHelpers;
	use RenderOptionsHelpers;
	use RegisterOptionsHelpers;
	use EnqueueOptionsHelpers;
	
	//option configurations (received from the plugin config/options folder area)
	private array $_dashboardPagesOptions;
	private array $_postTypeOptions;
	private array $_termOptions;
	private array $_vbOptions;
	
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
	
	/**
	 * @since     1.0.0
	 */
	public function __construct( array $dashboardPagesOptions, array $postTypeOptions, array $termOptions, array $vbOptions ) {
		
		$this->_dashboardPagesOptions = $dashboardPagesOptions;
		$this->_postTypeOptions       = $postTypeOptions;
		$this->_termOptions           = $termOptions;
		$this->_vbOptions             = $vbOptions;
	}
	
	/**
	 * initialize general options settings
	 *
	 * @return void
	 * @since     1.0.0
	 */
	public function register() : void {
		
		//register the Framework options types
		$this->_registerFWOptions();
		
		//generate nonce field
		$this->_nonce = $this->_generateNonce();
		
		//enqueue the options container scripts
		add_action( 'admin_enqueue_scripts', [ $this, 'enqueueGeneralScripts' ] );
		
		//dashboard pages
		$this->_renderDashBoardPagesOptions( $this->_dashboardPagesOptions );
		
		//post types
		$this->_renderPostTypesOptions( $this->_postTypeOptions );
		
		//terms
		$this->_renderTermsOptions( $this->_termOptions );
		
		//vb options
		$this->_renderVBOptions( $this->_vbOptions );
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
		
		if( Environment::isDevelopment() ) {
			wp_register_style( DHT_PREFIX_CSS . '-dashboard-page', DHT_ASSETS_URI . 'dist/css/dashboard-page.css', array(), DHT::$version );
			wp_enqueue_style( DHT_PREFIX_CSS . '-dashboard-page' );
			
			wp_enqueue_script( DHT_PREFIX_JS . '-dashboard-page', DHT_ASSETS_URI . 'dist/js/dashboard-page.js', array( 'jquery' ), DHT::$version, true );
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
	 * Render dashboard page options
	 *
	 * @param array $dashboardPagesOptions Dashboard Pages options
	 *
	 * @return void
	 * @since     1.0.0
	 */
	private function _renderDashBoardPagesOptions( array $dashboardPagesOptions ) : void {
		
		//enqueue styles/scripts for each option received from the plugin
		$this->_enqueueOptionsScripts( apply_filters( 'dht:options:enqueue_dash_pages_option_scripts', $dashboardPagesOptions ) );
		
		//render dashboard page form HTML content hook with the passed options
		add_action( 'dht:options:view:render_dashboard_page_content', function() use ( $dashboardPagesOptions ) {
			//save dashboard pages options
			$this->_saveDashBoardPageOptions( $dashboardPagesOptions );
			
			$this->_renderContent( $dashboardPagesOptions );
		} );
	}
	
	/**
	 * Render post types options
	 *
	 * @param array $postTypeOptions Post type options
	 *
	 * @return void
	 * @since     1.0.0
	 */
	private function _renderPostTypesOptions( array $postTypeOptions ) : void {
		
		//enqueue styles/scripts for each option received from the plugin
		$this->_enqueueOptionsScripts( apply_filters( 'dht:options:enqueue_post_types_scripts', $postTypeOptions ) );
		
		//save post type metaboxes options
		add_action( 'save_post', function( int $post_id, WP_Post $post ) use ( $postTypeOptions ) {
			$this->_savePostTypeOptions( $post_id, $post, $postTypeOptions );
		}, 999, 2 );
		
		//register post types and pages meta boxes
		add_action( 'add_meta_boxes', function() use ( $postTypeOptions ) {
			$this->_registerPostTypeMetaboxes( $postTypeOptions );
		} );
	}
	
	/**
	 * Render terms options
	 *
	 * @param array $termOptions Term options
	 *
	 * @return void
	 * @since     1.0.0
	 */
	private function _renderTermsOptions( array $termOptions ) : void {
		
		//enqueue styles/scripts for each option received from the plugin
		$this->_enqueueOptionsScripts( apply_filters( 'dht:options:enqueue_term_scripts', $termOptions ) );
		
		//taxonomies related functionality
		{
			$current_taxonomy = dht_get_current_admin_taxonomy_from_url();
			
			add_action( $current_taxonomy . '_edit_form', function( $term ) use ( $termOptions ) {
				$this->_renderContent( $termOptions, 'term', $term->term_id );
			}, 999 );
			
			add_action( 'edited_' . $current_taxonomy, function( $term_id ) use ( $termOptions ) {
				$this->_saveTermOptions( $term_id, $termOptions );
			}, 999 );
		}
	}
	
	/**
	 * Render visual builder options
	 *
	 * @param array $vbOptions VB modal options
	 *
	 * @return void
	 * @since     1.0.0
	 */
	private function _renderVBOptions( array $vbOptions ) : void {
		
		//enqueue styles/scripts for each modal options
		foreach ( $vbOptions as $vbOption ) {
			$this->_enqueueOptionsScripts( apply_filters( 'dht:options:enqueue_vb_scripts', $vbOption ) );
		}
		
		//render visual builder modal HTML content hook with the passed options
		add_action( 'dht:vb:render_modal_content', function( int $postID, string $modalName ) use ( $vbOptions ) {
			//load the options by the modal name key
			$this->_renderContent( $vbOptions[ $modalName ] ?? [], "vb", $postID );
		}, 10, 2 );
	}
	
	/**
	 * Save dashboard page options based on the provided settings ID.
	 *
	 * This method handles both grouped and ungrouped options, validates the nonce,
	 * and processes the POST data to save settings. It delegates specific processing
	 * tasks to other methods to improve readability and maintainability.
	 *
	 *
	 * @param array $options
	 *
	 * @return void
	 * @since     1.0.0
	 */
	private function _saveDashBoardPageOptions( array $options ) : void {
		
		if( $this->_isValidRequest() ) {
			
			$post_values = $_POST[ $options[ 'id' ] ?? '' ] ?? NULL;
			
			if( $post_values ) {
				$this->_handleContainerOptions( $options, $post_values );
			}
			else {
				$this->_handleUngroupedOptions( $options );
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
	 * @param int     $post_id         saved post id
	 * @param WP_Post $post            saved post
	 * @param array   $postTypeOptions Options array
	 *
	 * @return void
	 * @since     1.0.0
	 */
	public function _savePostTypeOptions( int $post_id, WP_Post $post, array $postTypeOptions ) : void {
		
		//check nonce field
		if( $this->_isValidRequest() ) {
			
			if( !current_user_can( 'edit_post', $post_id ) ) {
				return;
			}
			
			// Check if this is an autosave
			if( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
				return;
			}
			
			// check post type
			if( isset( $_POST[ 'post_type' ] ) && $post->post_type != $_POST[ 'post_type' ] ) {
				return;
			}
			
			//save metaboxes options
			if( isset( $_POST ) ) {
				foreach ( $_POST as $metabox_id => $values ) {
					if( str_contains( $metabox_id, 'dht-fw-metabox-id' ) ) {
						//many metaboxes
						if( !isset( $postTypeOptions[ 'options' ] ) ) {
							foreach ( $postTypeOptions as $options ) {
								if( isset( $values[ $options[ 'id' ] ] ) ) {
									$this->_handleContainerOptions( $options, $values[ $options[ 'id' ] ], 'post', $post_id );
								}
							}
						}
						else {
							$this->_handleContainerOptions( $postTypeOptions, $values[ $postTypeOptions[ 'id' ] ], 'post', $post_id );
						}
					}
				}
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
	 * @param int   $term_id Term ID
	 * @param array $options Option array
	 *
	 * @return void
	 * @since     1.0.0
	 */
	private function _saveTermOptions( int $term_id, array $options ) : void {
		
		if( $this->_isValidRequest() ) {
			
			$post_values = $_POST[ $options[ 'id' ] ?? '' ] ?? NULL;
			
			//check for the container id
			if( $post_values ) {
				$this->_handleContainerOptions( $options, $post_values, 'term', $term_id );
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