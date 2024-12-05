<?php
declare( strict_types = 1 );

namespace DHT\Helpers\Traits\Options;

use function DHT\Helpers\dht_get_current_admin_post_type;

if( !defined( 'DHT_MAIN' ) ) {
	die( 'Forbidden' );
}

trait OptionsTrait {
	
	/**
	 * register post types and pages meta boxes
	 *
	 * @param array $options Options array
	 *
	 * @return void
	 * @since     1.0.0
	 */
	private function _registerPostTypeMetaboxes( array $options ) : void {
		
		$post_type = dht_get_current_admin_post_type();
		
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
					$this->_renderContent( $metabox, 'post', $post->ID );
				}, $post_type, // Post type
				$metabox[ 'context' ] ?? 'normal', // Context (normal, side, advanced)
				$metabox[ 'priority' ] ?? 'high'  // Priority (high, core, default, low)
			);
			
			// Add custom class to the postbox area
			$this->_addMetaboxCustomClass( $metabox, $post_type, $metabox_id );
		}
	}
	
	/**
	 * generate form nonce fields (name and action)
	 *
	 * @return array
	 * @since     1.0.0
	 */
	private function _generateNonce() : array {
		
		$nonce = '';
		
		if( isset( $_POST ) ) {
			$nonce = array_filter( array_keys( $_POST ), function( $key ) {
				
				return str_contains( $key, '_dht_fw_nonce' );
			} );
			
			$nonce = !empty( $nonce ) ? str_replace( "_name", "", implode( "", $nonce ) ) : '';
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
		
		if( isset( $metabox[ 'attr' ][ 'class' ] ) ) {
			add_filter( 'postbox_classes_' . $post_type . '_' . $metabox_id, function( $classes ) use ( $metabox ) {
				$classes[] = $metabox[ 'attr' ][ 'class' ];
				
				return $classes;
			} );
		}
	}
	
	/**
	 * Validates the nonce in the POST request.
	 *
	 * This method checks if the nonce in the POST data is valid to ensure that the
	 * request is coming from a legitimate source.
	 *
	 * @param array $nonce Custom nonce field
	 *
	 * @return bool True if the nonce is valid, otherwise false.
	 * @since     1.0.0
	 */
	private function _isValidRequest( array $nonce = [] ) : bool {
		
		if( !empty( $nonce ) ) {
			return isset( $nonce[ 'name' ] ) && wp_verify_nonce( sanitize_key( wp_unslash( $nonce[ 'name' ] ) ), $nonce[ 'action' ] );
		}
		
		return isset( $_POST[ $this->_nonce[ 'name' ] ] ) && wp_verify_nonce( sanitize_key( wp_unslash( $_POST[ $this->_nonce[ 'name' ] ] ) ), $this->_nonce[ 'action' ] );
	}
	
	/**
	 * check if the options must be saved separately and not grouped under an id
	 *
	 * @param array $options
	 *
	 * @return bool
	 * @since     1.0.0
	 */
	private function _isSaveOptionsSeparately( array $options ) : bool {
		
		return isset( $options[ 'save' ] ) && $options[ 'save' ] == "separately";
	}
	
}