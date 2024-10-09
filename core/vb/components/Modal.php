<?php
declare( strict_types = 1 );

namespace DHT\Core\Vb\Components;

use DHT\Helpers\Classes\Environment;
use DHT\Helpers\Traits\SingletonTrait;
use function DHT\dht;

if ( ! defined( 'DHT_MAIN' ) ) {
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
		add_action( 'wp_ajax_nopriv_getModalOptions', [ $this, 'getModalOptions' ] ); // For non-logged in users
	}
	
	/**
	 * Enqueue modal scripts and styles
	 *
	 * @return void
	 * @since     1.0.0
	 */
	public function enqueueScripts() : void {
		
		if ( Environment::isDevelopment() ) {
			wp_register_style( DHT_PREFIX_CSS . '-modal', DHT_ASSETS_URI . 'dist/css/modal.css', array(), dht()->manifest->get( 'version' ) );
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
		
		if ( isset( $_POST[ 'action' ] ) && $_POST[ 'action' ] == "getModalOptions" && isset( $_POST[ 'data' ][ 'modalType' ] ) && isset( $_POST[ 'post_id' ] ) ) {
			
			//retrieve box number
			$modal_type = ! empty( $_POST[ 'data' ][ 'modalType' ] ) ? $_POST[ 'data' ][ 'modalType' ] : "";
			$post_id    = ! empty( $_POST[ 'post_id' ] ) ? intval( $_POST[ 'post_id' ] ) : 0;
			
			ob_start();
			
			//options are rendered via this hook from the Options class
			do_action( 'dht_vb_render_modal_content', $post_id, $modal_type );
			
			$content = ob_get_clean();
			
			wp_send_json_success( $content );
			
		} else {
			wp_send_json_success( _x( 'Something went wrong, please refresh the page', 'vb', DHT_PREFIX ) );
		}
		
		die();
	}
	
}