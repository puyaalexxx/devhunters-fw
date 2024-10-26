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
	GetOptionsHelpers,
	OptionsHelpers,
	RegisterOptionsHelpers,
	RenderOptionsHelpers,
	SaveOptionsHelpers};
use WP_Post;
use function DHT\Helpers\{dht_get_current_admin_taxonomy_from_url};

final class Options implements IOptions {
	
	use OptionsHelpers;
	use SaveOptionsHelpers;
	use GetOptionsHelpers;
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
		$this->_renderDashBoardPagesOptions();
		
		//post types
		$this->_renderPostTypesOptions();
		
		//terms
		$this->_renderTermsOptions();
		
		//vb options
		$this->_renderVBOptions();
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
	 * @return void
	 * @since     1.0.0
	 */
	private function _renderDashBoardPagesOptions() : void {
		
		//enqueue styles/scripts for each option received from the plugin
		$this->_enqueueOptionsScripts( apply_filters( 'dht:options:enqueue_dash_pages_option_scripts', $this->_dashboardPagesOptions ) );
		
		//render dashboard page form HTML content hook with the passed options
		add_action( 'dht:view:render_dashboard_page_content', function() {
			//save dashboard pages options
			$this->_saveDashBoardPageOptions();
			
			$this->_renderContent( $this->_dashboardPagesOptions );
		} );
	}
	
	/**
	 * Render terms options
	 *
	 * @return void
	 * @since     1.0.0
	 */
	private function _renderTermsOptions() : void {
		
		//enqueue styles/scripts for each option received from the plugin
		$this->_enqueueOptionsScripts( apply_filters( 'dht:options:enqueue_term_scripts', $this->_termOptions ) );
		
		//taxonomies related functionality
		{
			$current_taxonomy = dht_get_current_admin_taxonomy_from_url();
			
			add_action( $current_taxonomy . '_edit_form', function( $term ) {
				$this->_renderContent( $this->_termOptions, 'term', $term->term_id );
			}, 999 );
			
			add_action( 'edited_' . $current_taxonomy, function( $term_id ) {
				$this->_saveTermOptions( $term_id );
			}, 999 );
		}
	}
	
	/**
	 * Render post types options
	 *
	 * @return void
	 * @since     1.0.0
	 */
	private function _renderPostTypesOptions() : void {
		
		//enqueue styles/scripts for each option received from the plugin
		$this->_enqueueOptionsScripts( apply_filters( 'dht:options:enqueue_post_types_scripts', $this->_postTypeOptions ) );
		
		//save post type metaboxes options
		add_action( 'save_post', function( int $post_id, WP_Post $post ) {
			$this->_savePostTypeOptions( $post_id, $post );
		}, 999, 2 );
		
		//register post types and pages meta boxes
		add_action( 'add_meta_boxes', function() {
			$this->_registerPostTypeMetaboxes( $this->_postTypeOptions );
		} );
	}
	
	/**
	 * Render visual builder options
	 *
	 * @return void
	 * @since     1.0.0
	 */
	private function _renderVBOptions() : void {
		
		//enqueue styles/scripts for each modal options
		foreach ( $this->_vbOptions as $vbOption ) {
			$this->_enqueueOptionsScripts( apply_filters( 'dht:options:enqueue_vb_scripts', $vbOption ) );
		}
		
		//process and filter the saved modal form options
		add_filter( 'dht:vb:save_modal_content', function( int $postID, string $moduleName, string $moduleID, array $modalFormData ) {
			$options = array_merge( $this->_vbOptions[ $moduleName ], [ "id" => $moduleID ] );
			
			return $modalFormData ? $this->_saveContainerOptions( $options, $modalFormData[ $options[ 'id' ] ] ?? [], 'vb', $postID, false ) : [];
		}, 10, 4 );
		
		//render visual builder modal HTML content hook with the passed options
		add_action( 'dht:vb:render_modal_content', function( int $postID, string $modalName, string $moduleID, array $modalSavedFormData ) {
			//change options id to the module id to make them unique
			$options = array_merge( $this->_vbOptions[ $modalName ], [ "id" => $moduleID ] );
			
			//override the modal saved values if you click the modal save button
			//modal options are not saved in the DB but locally to a hidden input to grab them when the modal is opened
			if( !empty( $modalSavedFormData ) ) {
				add_filter( 'dht:options:set_saved_values', function() use ( $options, $modalName, $modalSavedFormData ) {
					return [ $options[ 'id' ] => $modalSavedFormData ];
				} );
			}
			
			//render the modal options
			$this->_renderContent( $options, "vb", $postID );
		}, 10, 4 );
	}
	
	/**
	 * Save dashboard page options based on the provided settings ID.
	 *
	 * This method handles both grouped and ungrouped options, validates the nonce,
	 * and processes the POST data to save settings. It delegates specific processing
	 * tasks to other methods to improve readability and maintainability.
	 *
	 * @return void
	 * @since     1.0.0
	 */
	private function _saveDashBoardPageOptions() : void {
		
		if( $this->_isValidRequest() ) {
			
			$post_values = $_POST[ $this->_dashboardPagesOptions[ 'id' ] ?? '' ] ?? [];
			
			if( $post_values ) {
				$this->_saveContainerOptions( $this->_dashboardPagesOptions, $post_values );
			}
			else {
				$this->_saveUngroupedOptions( $this->_dashboardPagesOptions );
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
	 * @param int $term_id Term ID
	 *
	 * @return void
	 * @since     1.0.0
	 */
	private function _saveTermOptions( int $term_id ) : void {
		
		if( $this->_isValidRequest() ) {
			
			$post_values = $_POST[ $this->_termOptions[ 'id' ] ?? '' ] ?? [];
			
			//check for the container id
			if( $post_values ) {
				$this->_saveContainerOptions( $this->_termOptions, $post_values, 'term', $term_id );
			}
		}
	}
	
	/**
	 * Save post options settings based on its id (metaboxes and vb modules)
	 *
	 * This method handles the post saving options, it is used in the save_post hook, validates the nonce,
	 * and processes the POST data to save settings. It delegates specific processing
	 * tasks to other methods to improve readability and maintainability.
	 *
	 * @param int     $postID Saved post id
	 * @param WP_Post $post   Saved post
	 *
	 * @return void
	 * @since     1.0.0
	 */
	public function _savePostTypeOptions( int $postID, WP_Post $post ) : void {
		
		//check nonce field
		if( $this->_isValidRequest() ) {
			
			if( !current_user_can( 'edit_post', $postID ) ) {
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
			
			if( isset( $_POST ) ) {
				foreach ( $_POST as $id => $values ) {
					//saving for metaboxes
					if( str_contains( $id, 'dht-fw-metabox-id' ) ) {
						$this->_savePostTypeMetaboxesOptions( $postID, $values );
					}
					//saving for vb modals
					elseif( str_contains( $id, 'dht-fw-modules' ) ) {
						$this->_saveVBModulesOptions( $postID, $values );
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