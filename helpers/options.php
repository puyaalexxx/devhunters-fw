<?php
declare( strict_types = 1 );

namespace DHT\Helpers;

if ( !defined( 'DHT_MAIN' ) ) die( 'Forbidden' );

/**
 *
 * get option or options fields from db
 *
 * @param string $option_id
 * @param array  $default_value
 *
 * @return mixed
 * @since     1.0.0
 */
function dht_get_db_settings_option( string $option_id, mixed $default_value = [] ) : array {
    
    if ( empty( $option_id ) ) return [];
    
    return get_option( $option_id, $default_value );
}

/**
 *
 * save option field or fields in database
 *
 * @param string $option_id
 * @param mixed  $value     - value to be saved
 * @param string $array_key - save all options under this array key
 *
 * @return bool
 * @since     1.0.0
 */
function dht_set_db_settings_option( string $option_id, mixed $value, string $array_key = '' ) : bool {
    
    if ( empty( $option_id ) || empty( $value ) ) return false;
    
    //this is useful for array of arrays of options
    if ( !empty( $array_key ) ) {
        
        //get saved value first to not override all the settings
        $saved_values = dht_get_db_settings_option( $option_id );
        
        $saved_values[ $array_key ] = $value;
        
        return update_option( $option_id, $saved_values );
    }
    
    return update_option( $option_id, $value );
}

/**
 *
 * parse option attributes to add them to the HTML field
 *
 * @param array $attr
 *
 * @return string
 * @since     1.0.0
 */
function dht_parse_option_attributes( array $attr ) : string {
    
    if ( isset( $attr[ 'class' ] ) ) unset( $attr[ 'class' ] );
    
    $attributes = '';
    foreach ( $attr as $key => $value ) {
        
        // Sanitize the key and value
        $key = htmlspecialchars( $key );
        
        $value = htmlspecialchars( $value );
        
        // Concatenate the key-value pairs to form the attribute string
        $attributes .= " $key=\"$value\"";
    }
    
    return $attributes;
}

/**
 *
 * add allowed HTML tags to the wp editor value
 *
 * @param string $value
 *
 * @return string
 * @since     1.0.0
 */
function dht_sanitize_wpeditor_value( string $value ) : string {
    
    // Get the list of allowed HTML tags and attributes
    $allowed_html = wp_kses_allowed_html( 'post' );
    
    // Remove the <script> tag from the list of allowed tags
    unset( $allowed_html[ 'script' ] );
    
    // Sanitize content with allowed HTML tags and excluding <script> tag
    return wp_kses( $value, $allowed_html );
}
