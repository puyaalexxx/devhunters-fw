<?php
declare(strict_types=1);

namespace DHT\Helpers;

if (!defined('DHT_MAIN')) die('Forbidden');

/**
 *
 * get option or options fields from db
 *
 * @param string     $option_id
 * @param mixed|null $default_value
 *
 * @return mixed
 * @since     1.0.0
 */
function dht_get_db_settings_option( string $option_id, mixed $default_value = null  ) : mixed {
    
    if(empty($option_id)) return false;
    
    return get_option( $option_id, $default_value );
}

/**
 *
 * save option field or fields in database
 *
 * @param string $option_name
 * @param mixed $value - value to be saved
 *
 * @return bool
 * @since     1.0.0
 */
function dht_set_db_settings_option( string $option_name, mixed $value ) : bool  {
    
    if(empty($option_name) or empty($value)) return false;
    
    return update_option( $option_name, $value );
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
function dht_parse_option_attributes( array $attr ) : string  {
    
    if(isset($attr['class'])) unset($attr['class']);
    
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

