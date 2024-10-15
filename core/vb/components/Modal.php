<?php
declare( strict_types = 1 );

namespace DHT\Core\Vb\Components;

use DHT\DHT;
use DHT\Helpers\Classes\Environment;
use DHT\Helpers\Traits\SingletonTrait;

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
		
		//add_filter( "dht_options_enqueue_option_scripts", [ $this, "getModalOptionsFilter" ], 99 );
		//add_filter( "dht:options:vb_modal_options", [ $this, "getModalOptionsFilter" ] );
	}
	
	/**
	 * Enqueue modal scripts and styles
	 *
	 * @return void
	 * @since     1.0.0
	 */
	public function enqueueScripts() : void {
		
		if ( Environment::isDevelopment() ) {
			wp_register_style( DHT_PREFIX_CSS . '-modal', DHT_ASSETS_URI . 'dist/css/modal.css', array(), DHT::$version );
			wp_enqueue_style( DHT_PREFIX_CSS . '-modal' );
		}
	}
	
	/**
	 *
	 *
	 * @return array
	 * @since     1.0.0
	 */
	public function getModalOptionsFilter() : array {
		
		return [
			[
				'id'    => 'icon_field',
				'type'  => 'icon',
				'title' => _x( 'Icon field', 'options', 'PPHT_PREFIX' ),
				'value' => [
					'icon-type'  => 'dashicons',
					'icon-class' => 'dashicons dashicons-universal-access-alt',
					'icon-code'  => '\f507'
				],
				
				'attr'        => array( 'class' => 'custom-class', 'data-foo' => 'bar' ),
				'description' => _x( 'Icon description', 'options', 'PPHT_PREFIX' ),
				'tooltip'     => _x( 'This field is used to add some text', 'options', 'PPHT_PREFIX' ),
				'divider'     => true
			],
			//input field
			[
				'id'      => 'input_field22',
				'type'    => 'input',
				'title'   => _x( 'Input field', 'options', PPHT_PREFIX ),
				'label'   => _x( 'Input label', 'options', PPHT_PREFIX ),
				'value'   => 'default value sss',
				'subtype' => '',
				//(can be email, password...)
				
				'attr'        => array(
					'class'    => 'custom-class',
					'data-foo' => 'bar'
				),
				'description' => _x( 'Input description', 'options', PPHT_PREFIX ),
				'tooltip'     => _x( 'This field is used to add some text', 'options', PPHT_PREFIX ),
				'divider'     => true
			]
		];
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
			do_action( 'dht:vb:render_modal_content', $post_id, $modal_type );
			
			$content = ob_get_clean();
			
			wp_send_json_success( $content );
			
		}
		else {
			wp_send_json_success( _x( 'Something went wrong, please refresh the page', 'vb', DHT_PREFIX ) );
		}
		
		die();
	}
	
}