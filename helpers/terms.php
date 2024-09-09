<?php
declare( strict_types = 1 );

namespace DHT\Helpers;

if ( !defined( 'DHT_MAIN' ) ) die( 'Forbidden' );


/**
 * Check if it is a category/tag/term  editing area
 *
 * When editing the term you can use the $_GET to get its id and grab the taxonomy
 *
 * @return string
 */
if ( !function_exists( 'dht_is_term_editing_area' ) ) {
    function dht_is_term_editing_area() : bool {
        
        return isset( $_GET[ 'tag_ID' ] ) && isset( $_GET[ 'taxonomy' ] );
    }
}

/**
 * Get taxonomy from admin editing category/tag/term areas
 *
 * When editing the term area you can use the $_GET to get its id and grab the taxonomy
 *
 * @return string
 */
if ( !function_exists( 'dht_get_current_admin_taxonomy_from_url' ) ) {
    function dht_get_current_admin_taxonomy_from_url() : string {
        
        //get current taxonomy from the $_GET if exists
        return isset( $_GET[ 'tag_ID' ] ) && isset( $_GET[ 'taxonomy' ] ) ? $_GET[ 'taxonomy' ] : '';
    }
}

/**
 * Get current taxonomy from admin area
 *
 * @return string
 */
if ( !function_exists( 'dht_get_current_admin_taxonomy' ) ) {
    function dht_get_current_admin_taxonomy() : string {
        
        $screen = get_current_screen();
        
        // Check if we are on a term edit screen
        if ( $screen && $screen->base === 'edit-tags' && isset( $screen->taxonomy ) ) {
            return $screen->taxonomy;
        }
        
        return '';
    }
}