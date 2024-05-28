<?php
declare( strict_types = 1 );

namespace DHT\Helpers;

if ( !defined( 'DHT_MAIN' ) ) die( 'Forbidden' );

/**
 * get option or options fields from db
 *
 * @param string $option_id
 * @param array  $default_value
 *
 * @return mixed
 * @since     1.0.0
 */
function dht_get_db_settings_option( string $option_id, mixed $default_value = [] ) : mixed {
    
    if ( empty( $option_id ) ) return [];
    
    return get_option( $option_id, $default_value );
}

/**
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

/**
 * remove dht prefix from the font name added because it conflicts with
 * Google font names
 *
 * @param string $font_name
 *
 * @return string
 * @since     1.0.0
 */
function dht_remove_font_name_prefix( string $font_name ) : string {
    
    return preg_replace( '/^' . DHT_PREFIX . '-/', '', $font_name );
}

/**
 * gent font weight label from its value (ex: 400, 500)
 *
 * @param int $font_weight
 *
 * @return string
 * @since     1.0.0
 */
function dht_get_font_weight_Label( int $font_weight ) : string {
    
    return match ( $font_weight ) {
        100 => 'Thin',
        200 => 'Extra Light',
        300 => 'Light',
        400 => 'Regular',
        500 => 'Medium',
        600 => 'Semi Bold',
        700 => 'Bold',
        800 => 'Extra Bold',
        900 => 'Black'
    };
}

/**
 * render option if it is registered (exists)
 *
 * @param array  $option
 * @param mixed  $saved_value
 * @param string $prefix_id
 * @param array  $option_classes
 *
 * @return string
 * @since     1.0.0
 */
function dht_render_option_if_exists( array $option, mixed $saved_value, string $prefix_id, array $option_classes ) : string {
    
    if ( array_key_exists( $option[ 'type' ], $option_classes ) ) {
        
        //render the respective option type class
        return $option_classes[ $option[ 'type' ] ]->render( $option, $saved_value, $prefix_id );
        
    } else {
        
        //display no option template if no match
        return dht_load_view( DHT_TEMPLATES_DIR . 'options/', 'no-option.php' );
    }
}