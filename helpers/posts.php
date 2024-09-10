<?php
declare( strict_types = 1 );

namespace DHT\Helpers;

if ( !defined( 'DHT_MAIN' ) ) die( 'Forbidden' );

/**
 * Check if it is a post/page/cpt editing area
 *
 * When editing the post you can use the $_GET to get its id and grab the post type
 * On save_post hook, the $_GET is not available so you can use the $_PODt for this
 *
 * @return string
 */
if ( !function_exists( 'dht_is_post_editing_area' ) ) {
    function dht_is_post_editing_area() : bool {
        
        if (!is_admin()) {
            return false; // Exit if not in admin area
        }
        
        return isset( $_GET[ 'post' ] ) || isset( $_POST[ 'post_type' ] );
    }
}

/**
 * Get post type from admin editing post/page/cpt areas
 *
 * When editing the post you can use the $_GET to get its id and grab the post type
 * On save_post hook, the $_GET is not available so you can use the $_POSt for this
 *
 * @return string
 */
if ( !function_exists( 'dht_get_current_admin_post_type_from_url' ) ) {
    function dht_get_current_admin_post_type_from_url() : string {
        
        if (!is_admin()) {
            return ''; // Exit if not in admin area
        }
        
        //get current post id from the $_GET if exists
        $post_id = isset( $_GET[ 'post' ] ) ? intval( $_GET[ 'post' ] ) : 0;
        
        return $post_id ? get_post( $post_id )->post_type : ( isset( $_POST[ 'post_type' ] ) ? sanitize_text_field( $_POST[ 'post_type' ] ) : '' );
    }
}

/**
 * Get current post type from admin area
 *
 * @return string
 */
if ( !function_exists( 'dht_get_current_admin_post_type' ) ) {
    function dht_get_current_admin_post_type() : string {
        
        if (!is_admin()) {
            return ''; // Exit if not in admin area
        }
        
        $screen = get_current_screen();
        
        // Check if we are on a post edit screen
        if ( !$screen || !in_array( $screen->base, [ 'post', 'edit' ], true ) ) {
            return '';
        }
        
        // Get the current post type from the screen object
        return $screen->post_type;
    }
}
