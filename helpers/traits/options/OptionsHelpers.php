<?php
declare( strict_types = 1 );

namespace DHT\Helpers\Traits\Options;

if ( ! defined( 'DHT_MAIN' ) ) {
	die( 'Forbidden' );
}

trait OptionsHelpers {
	
	/**
	 * generate form nonce fields (name and action)
	 *
	 * @return array
	 * @since     1.0.0
	 */
	private function _generateNonce() : array {
		
		$nonce = '';
		
		if ( isset( $_POST ) ) {
			$nonce = array_filter( array_keys( $_POST ), function( $key ) {
				
				return str_contains( $key, '_dht_fw_nonce' );
			} );
			
			$nonce = ! empty( $nonce ) ? str_replace( "_name", "", implode( "", $nonce ) ) : '';
		}
		
		$nonce = empty( $nonce ) ? 'dht_' . md5( uniqid( (string) mt_rand(), true ) ) . '_dht_fw_nonce' : $nonce;
		
		return [
			'name'   => $nonce . '_name',
			'action' => $nonce . '_action'
		];
	}
	
	/**
	 * Check if it is the simple container option type
	 *
	 * @param array $option option to be checked
	 *
	 * @return bool
	 * @since     1.0.0
	 */
	private function _isSimpleContainer( array $option ) : bool {
		
		return isset( $option[ 'type' ] ) && $option[ 'type' ] == 'simple';
	}
	
	/**
	 * Check if it is a container option type
	 *
	 * @param array $option option to be checked
	 *
	 * @return bool
	 * @since     1.0.0
	 */
	private function _isContainerType( array $option ) : bool {
		
		return isset( $option[ 'type' ] ) && isset( $this->_optionContainerClasses[ $option[ 'type' ] ] );
	}
	
	/**
	 * Get the correct option template
	 *
	 * @param string $location Where the options are located (dashboard/post/term)
	 *
	 * @return string
	 * @since     1.0.0
	 */
	private function _getOptionsTemplate( string $location ) : string {
		
		if ( $location == 'post' ) {
			$template = 'posts.php';
		} elseif ( $location == 'term' ) {
			$template = 'terms.php';
		} elseif ( $location == 'vb' ) {
			$template = 'modal.php';
		} else {
			$template = 'dashboard-page.php';
		}
		
		return $template;
	}
	
	/**
	 * Add custom class to the metabox area
	 *
	 * @param array  $metabox Metabox options
	 * @param string $post_type
	 * @param string $metabox_id
	 *
	 * @return void
	 * @since     1.0.0
	 */
	private function _addMetaboxCustomClass( array $metabox, string $post_type, string $metabox_id ) : void {
		
		if ( isset( $metabox[ 'attr' ][ 'class' ] ) ) {
			add_filter( 'postbox_classes_' . $post_type . '_' . $metabox_id, function( $classes ) use ( $metabox ) {
				$classes[] = $metabox[ 'attr' ][ 'class' ];
				
				return $classes;
			} );
		}
	}
	
}