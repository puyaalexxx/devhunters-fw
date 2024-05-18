<?php
declare( strict_types = 1 );

namespace DHT\Helpers;

if ( !defined( 'DHT_MAIN' ) ) die( 'Forbidden' );

/**
 *
 * check if array key exist and if it is empty
 *
 * @param array  $array     - array to be checked
 * @param string $array_key - array key
 *
 * @return bool
 * @since     1.0.0
 */
function dht_array_key_exists( array $array, string $array_key ) : bool {
    
    if ( array_key_exists( $array_key, $array ) && !empty( $array[ $array_key ] ) ) {
        return false;
    }
    
    return true;
}

/**
 * Check if the current admin page is in the available array of pages
 *
 * @param array $init_on
 *
 * @return bool
 * @since     1.0.0
 */
function dht_is_page_available( array $init_on = [] ) : bool {
    
    return !empty( $init_on ) && in_array( dht_get_current_admin_page(), $init_on );
}