<?php
declare( strict_types = 1 );

namespace DHT\Core\Vb\Components;

use DHT\DHT;
use DHT\Helpers\Classes\Environment;
use DHT\Helpers\Traits\SingletonTrait;

if( !defined( 'DHT_MAIN' ) ) {
	die( 'Forbidden' );
}

/**
 * Modal component
 *
 * @since     1.0.0
 */
final class Modal {
	
	use SingletonTrait;
	
	/**
	 * @since     1.0.0
	 */
	private function __construct() {
		
		//enqueue the options container scripts
		add_action( 'admin_enqueue_scripts', [ $this, 'enqueueScripts' ] );
		
		add_action( 'wp_ajax_getModalOptions', [ $this, 'getModalOptions' ] );
		add_action( 'wp_ajax_nopriv_getModalOptions', [ $this, 'getModalOptions' ] );
		
		add_action( 'wp_ajax_saveModalOptions', [ $this, 'saveModalOptions' ] );
		add_action( 'wp_ajax_nopriv_saveModalOptions', [ $this, 'saveModalOptions' ] );
	}
	
	/**
	 * Enqueue modal scripts and styles
	 *
	 * @return void
	 * @since     1.0.0
	 */
	public function enqueueScripts() : void {
		
		if( Environment::isDevelopment() ) {
			wp_register_style( DHT_PREFIX_CSS . '-modal', DHT_ASSETS_URI . 'dist/css/modal.css', array(), DHT::$version );
			wp_enqueue_style( DHT_PREFIX_CSS . '-modal' );
		}
	}
	
	/**
	 * ajax action to retrieve all options for the modal
	 *
	 * @return void
	 * @since     1.0.0
	 */
	public function getModalOptions() : void {
		
		if( isset( $_POST[ 'action' ] ) && $_POST[ 'action' ] == "getModalOptions" && isset( $_POST[ 'post_id' ] ) ) {
			
			if( isset( $_POST[ 'data' ][ 'moduleName' ] ) && isset( $_POST[ 'data' ][ 'moduleID' ] ) ) {
				$postId        = !empty( $_POST[ 'post_id' ] ) ? intval( $_POST[ 'post_id' ] ) : 0;
				$moduleName    = !empty( $_POST[ 'data' ][ 'moduleName' ] ) ? $_POST[ 'data' ][ 'moduleName' ] : "";
				$moduleID      = !empty( $_POST[ 'data' ][ 'moduleID' ] ) ? $_POST[ 'data' ][ 'moduleID' ] : "";
				$formSavedData = !empty( $_POST[ 'data' ][ 'formSavedData' ] ) ? json_decode( stripslashes( html_entity_decode( $_POST[ 'data' ][ 'formSavedData' ], ENT_QUOTES, 'UTF-8' ) ), true ) : [];
				
				ob_start();
				
				//options are rendered via this hook from the Options class
				do_action( 'dht:vb:render_modal_content', $postId, $moduleName, $moduleID, $formSavedData );
				
				$content = ob_get_clean();
				
				wp_send_json_success( $content );
			}
			else {
				wp_send_json_success( _x( 'Modal name or id not provided', 'vb', 'dht' ) );
			}
		}
		else {
			wp_send_json_success( _x( 'Something went wrong, please refresh the page', 'vb', 'dht' ) );
		}
		
		die();
	}
	
	/**
	 * ajax action to save all modal options
	 *
	 * @return void
	 * @since     1.0.0
	 */
	public function saveModalOptions() : void {
		
		if( isset( $_POST[ 'action' ] ) && $_POST[ 'action' ] == "saveModalOptions" && isset( $_POST[ 'post_id' ] ) ) {
			
			if( isset( $_POST[ 'data' ][ 'formData' ] ) && isset( $_POST[ 'data' ][ 'moduleID' ] ) && isset( $_POST[ 'data' ][ 'moduleName' ] ) ) {
				$post_id    = !empty( $_POST[ 'post_id' ] ) ? intval( $_POST[ 'post_id' ] ) : 0;
				$modal_name = !empty( $_POST[ 'data' ][ 'moduleName' ] ) ? $_POST[ 'data' ][ 'moduleName' ] : "";
				$moduleID   = !empty( $_POST[ 'data' ][ 'moduleID' ] ) ? $_POST[ 'data' ][ 'moduleID' ] : "";
				parse_str( $_POST[ 'data' ][ 'formData' ], $formData ); // Parse the serialized string into an array
				
				//get filtered form data
				$filteredFormData = apply_filters( 'dht:vb:save_modal_content', $post_id, $modal_name, $moduleID, $formData );
				
				wp_send_json_success( json_encode( $filteredFormData ) );
			}
			else {
				wp_send_json_success( _x( 'Modal options data not ok', 'vb', 'dht' ) );
			}
		}
		else {
			wp_send_json_success( _x( 'Something went wrong, please refresh the page', 'vb', 'dht' ) );
		}
		
		die();
	}
	
}