<?php
declare( strict_types = 1 );

namespace DHT\Helpers;

if ( !defined( 'DHT_MAIN' ) ) die( 'Forbidden' );


/**
 * Check if it is a category/tag/term  editing area
 *
 * When editing the term you can use the $_GET or $_POST to get its id and grab the taxonomy
 * $_POST is used when we are updating the term area
 *
 * @return string
 */
if ( !function_exists( 'dht_is_term_editing_area' ) ) {
    function dht_is_term_editing_area() : bool {
        
        if (!is_admin()) {
            return false; // Exit if not in admin area
        }
        
        return (isset( $_GET[ 'tag_ID' ] ) && isset( $_GET[ 'taxonomy' ] )) || ( isset($_POST[ 'tag_ID' ]) && isset( $_POST[ 'taxonomy' ] ));
    }
}

/**
 * Get taxonomy from admin editing category/tag/term areas
 *
 * When editing the term area you can use the $_GET or $_POST to get its id and grab the taxonomy
 * $_POST is used when we are updating the term area
 *
 * @return string
 */
if ( !function_exists( 'dht_get_current_admin_taxonomy_from_url' ) ) {
    function dht_get_current_admin_taxonomy_from_url() : string {
        
        if (!is_admin()) {
            return ''; // Exit if not in admin area
        }
        
        //get current taxonomy from the $_GET or $_POST if exists
        return isset($_GET['tag_ID']) && isset($_GET['taxonomy']) ?
                    sanitize_text_field($_GET['taxonomy']) :
                    (isset($_POST['tag_ID']) && isset($_POST['taxonomy']) ? sanitize_text_field($_POST['taxonomy']) : '');
    }
}

/**
 * Get current taxonomy from admin area
 *
 * @return string
 */
if ( !function_exists( 'dht_get_current_admin_taxonomy' ) ) {
    function dht_get_current_admin_taxonomy() : string {
        
        if (!is_admin()) {
            return ''; // Exit if not in admin area
        }
        
        $screen = get_current_screen();
        
        // Check if we are on a term edit screen
        if ( $screen && $screen->base === 'edit-tags' && isset( $screen->taxonomy ) ) {
            return $screen->taxonomy;
        }
        
        return '';
    }
}