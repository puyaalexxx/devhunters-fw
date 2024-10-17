<?php
declare( strict_types = 1 );

namespace DHT\Helpers;

if( !defined( 'DHT_MAIN' ) ) {
	die( 'Forbidden' );
}


if( !function_exists( 'dht_is_post_editing_area' ) ) {
	/**
	 * Check if it is a post/page/cpt editing area
	 *
	 * When editing the post you can use the $_GET to get its id and grab the post type
	 * On save_post hook, the $_GET is not available so you can use the $_PODt for this
	 *
	 * @return bool
	 */
	function dht_is_post_editing_area() : bool {
		
		if( !is_admin() ) {
			return false; // Exit if not in admin area
		}
		
		//isset( $_POST[ 'data' ][ 'post_id' ] ) - is for ajax requests
		return ( isset( $_GET[ 'post' ] ) || isset( $_GET[ 'post_type' ] ) || isset( $_POST[ 'post_type' ] ) || isset( $_POST[ 'post_id' ] ) ) && !dht_is_term_editing_area();
	}
}


if( !function_exists( 'dht_get_current_admin_post_type_from_url' ) ) {
	/**
	 * Get post type from admin editing post/page/cpt areas
	 *
	 * When editing the post you can use the $_GET to get its id and grab the post type
	 * On save_post hook, the $_GET is not available so you can use the $_POSt for this
	 *
	 * @return string
	 */
	function dht_get_current_admin_post_type_from_url() : string {
		
		if( !is_admin() ) {
			return ''; // Exit if not in admin area
		}
		
		// Get post ID from GET request and sanitize
		$post_id = isset( $_GET[ 'post' ] ) ? intval( $_GET[ 'post' ] ) : 0;
		//get post id from the ajax content
		$post_id = empty( $post_id ) && isset( $_POST[ 'post_id' ] ) ? intval( $_POST[ 'post_id' ] ) : $post_id;
		
		// Get post type from GET request (if available)
		$post_type = isset( $_GET[ 'post_type' ] ) ? sanitize_text_field( $_GET[ 'post_type' ] ) : '';
		
		// If post_type is provided in the request, return it
		if( $post_type ) {
			return $post_type;
		} // If post ID is provided, retrieve the post type using the post ID
		elseif( $post_id ) {
			$post = get_post( $post_id );
			
			return $post ? $post->post_type : '';
		} // Check for post type in POST request and sanitize it
		elseif( isset( $_POST[ 'post_type' ] ) ) {
			return sanitize_text_field( $_POST[ 'post_type' ] );
		}
		
		// Default return value if no post type is found
		return '';
	}
}


if( !function_exists( 'dht_get_current_admin_post_type' ) ) {
	/**
	 * Get current post type from admin area
	 *
	 * @return string
	 */
	function dht_get_current_admin_post_type() : string {
		
		if( !is_admin() ) {
			return ''; // Exit if not in admin area
		}
		
		$screen = get_current_screen();
		
		// Check if we are on a post edit screen
		if( !$screen || !in_array( $screen->base, [
				'post',
				'edit'
			], true ) ) {
			return '';
		}
		
		// Get the current post type from the screen object
		return $screen->post_type;
	}
}
