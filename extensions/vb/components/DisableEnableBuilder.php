<?php
declare( strict_types = 1 );

namespace DHT\Extensions\Vb\Components;

use DHT\DHT;
use DHT\Helpers\Classes\Environment;
use DHT\Helpers\Traits\Singletons\SingletonTraitWithStringParam;
use WP_Post;

if( !defined( 'DHT_MAIN' ) ) {
	die( 'Forbidden' );
}

/**
 * Disable/Enable builder buttons component
 *
 * @since     1.0.0
 */
final class DisableEnableBuilder {
	
	use SingletonTraitWithStringParam;
	
	/**
	 * @param string $post_type Post type where to add the metabox
	 *
	 * @since     1.0.0
	 */
	private function __construct( string $post_type ) {
		
		//add enable/disable visual builder buttons
		add_action( 'add_meta_boxes', function() use ( $post_type ) {
			$this->_addEnableDisableVbButtons( $post_type );
		} );
		
		//enqueue scripts
		add_action( 'admin_enqueue_scripts', function() {
			$this->_enqueueScripts();
		} );
	}
	
	/**
	 * Enqueue buttons scripts and styles
	 *
	 * @return void
	 * @since     1.0.0
	 */
	private function _enqueueScripts() : void {
		
		if( Environment::isDevelopment() ) {
			wp_register_style( DHT_PREFIX_CSS . '-disable-enable-vb', DHT_ASSETS_URI . 'dist/css/disable-enable-vb.css', array(), DHT::$version );
			wp_enqueue_style( DHT_PREFIX_CSS . '-disable-enable-vb' );
		}
	}
	
	/**
	 * add enable/disable visual builder buttons
	 *
	 * @param string $post_type Post type where to add the metabox
	 *
	 * @return void
	 * @since     1.0.0
	 */
	private function _addEnableDisableVbButtons( string $post_type ) : void {
		
		/*add_meta_box( 'dht-vb-buttons-builder-box', _x( 'Enable/Disable VB Buttons', 'vb', 'dht' ), [
			$this,
			'_view' //need to change this to a callback
		], $post_type, 'normal', 'high' );*/
	}
	
	/**
	 * buttons view template
	 *
	 * @param WP_Post $post Current post info
	 *
	 * @return void
	 * @since     1.0.0
	 */
	private function _view( WP_Post $post ) : void { ?>

        <a href="#" id="dht-vb-enable-builder-button"><?php _ex( 'Enable Visual Editor', 'vb', 'dht' ); ?></a>
        <a href="#" id="dht-vb-disable-builder-button"><?php _ex( 'Disable Visual Editor', 'vb', 'dht' ); ?></a>
		
		<?php
	}
	
}