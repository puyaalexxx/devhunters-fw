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
        
        return isset( $_GET[ 'post' ] ) || isset( $_POST[ 'post_type' ] );
    }
}

/**
 * Get post type from admin editing post/page/cpt areas
 *
 * When editing the post you can use the $_GET to get its id and grab the post type
 * On save_post hook, the $_GET is not available so you can use the $_PODt for this
 *
 * @return string
 */
if ( !function_exists( 'dht_get_edited_post_type' ) ) {
    function dht_get_edited_post_type() : string {
        
        //get current post id from the $_GET if exists
        $post_id = isset( $_GET[ 'post' ] ) ? intval( $_GET[ 'post' ] ) : 0;
        
        return $post_id ? get_post( $post_id )->post_type : ( isset( $_POST[ 'post_type' ] ) ? sanitize_text_field( $_POST[ 'post_type' ] ) : '' );
    }
}