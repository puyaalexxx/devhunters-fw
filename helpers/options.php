<?php
declare( strict_types = 1 );

namespace DHT\Helpers;

if( !defined( 'DHT_MAIN' ) ) {
	die( 'Forbidden' );
}


if( !function_exists( 'dht_get_db_settings_option' ) ) {
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
		
		if( empty( $option_id ) ) {
			return [];
		}
		
		return get_option( $option_id, $default_value );
	}
}


if( !function_exists( 'dht_set_db_settings_option' ) ) {
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
		
		if( empty( $option_id ) || empty( $value ) ) {
			return false;
		}
		
		//this is useful for array of arrays of options
		if( !empty( $array_key ) ) {
			
			//get saved value first to not override all the settings
			$saved_values = dht_get_db_settings_option( $option_id );
			
			$saved_values[ $array_key ] = $value;
			
			return update_option( $option_id, $saved_values );
		}
		
		return update_option( $option_id, $value );
	}
}


if( !function_exists( 'dht_parse_option_attributes' ) ) {
	/**
	 * parse option attributes to add them to the HTML field
	 *
	 * @param array $attr
	 *
	 * @return string
	 * @since     1.0.0
	 */
	function dht_parse_option_attributes( array $attr ) : string {
		
		if( isset( $attr[ 'class' ] ) ) {
			unset( $attr[ 'class' ] );
		}
		
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
}


if( !function_exists( 'dht_sanitize_wpeditor_value' ) ) {
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
}


if( !function_exists( 'dht_remove_font_name_prefix' ) ) {
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
}

if( !function_exists( 'dht_get_dimension_field_css_properties' ) ) {
	/**
	 * Construct dimensions field css properties from the saved values
	 *
	 * @param array  $values
	 * @param string $css_property
	 *
	 * @return string
	 * @since     1.0.0
	 */
	function dht_get_dimension_field_css_properties( array $values, string $css_property ) : string {
		
		if( empty( $values ) ) return "";
		
		$unit = $sizes_values[ 'unit' ] ?? "px";
		
		$top_size    = isset( $values[ 'size-1' ] ) ? (int) $values[ 'size-1' ] . $unit : "";
		$right_size  = isset( $values[ 'size-2' ] ) ? (int) $values[ 'size-2' ] . $unit : "";
		$bottom_size = isset( $values[ 'size-3' ] ) ? (int) $values[ 'size-3' ] . $unit : "";
		$left_size   = isset( $values[ 'size-4' ] ) ? (int) $values[ 'size-4' ] . $unit : "";
		
		if( $css_property === "border" ) {
			$borders = 'border-width: ' . esc_attr( $top_size ) . " " . esc_attr( $right_size ) . " " . esc_attr( $bottom_size ) . " " . esc_attr( $left_size ) . ';';
			$borders .= !empty( $values[ 'border-style' ] ) ? 'border-style: ' . esc_attr( $values[ 'border-style' ] ) . ';' : "";
			$borders .= !empty( $values[ 'color' ] ) ? 'border-color: ' . esc_attr( $values[ 'color' ] ) . ';' : "";
			
			return $borders;
		}
		else {
			return $css_property . ': ' . esc_attr( $top_size ) . " " . esc_attr( $right_size ) . " " . esc_attr( $bottom_size ) . " " . esc_attr( $left_size ) . ';';
		}
	}
}

if( !function_exists( 'dht_get_typography_field_css_properties' ) ) {
	/**
	 * Construct typography field css properties from the saved values
	 *
	 * @param array $values
	 *
	 * @return string
	 * @since     1.0.0
	 */
	function dht_get_typography_field_css_properties( array $values ) : string {
		
		$preview_styles = '';
		if( !empty( $values ) ) {
			$preview_styles = !empty( $values[ 'font-family' ] ) ? 'font-family:"' . dht_remove_font_name_prefix( $values[ 'font-family' ][ 'font' ] ) . ', Helvetica, Arial, Lucida, sans-serif";' : '';
			$preview_styles .= !empty( $values[ 'font-weight' ] ) ? 'font-weight:' . $values[ 'font-weight' ] . ';' : '';
			$preview_styles .= !empty( $values[ 'font-style' ] ) ? 'font-style:' . $values[ 'font-style' ] . ';' : '';
			$preview_styles .= !empty( $values[ 'text-transform' ] ) ? 'text-transform:' . $values[ 'text-transform' ] . ';' : '';
			$preview_styles .= !empty( $values[ 'text-decoration' ] ) ? 'text-decoration:' . $values[ 'text-decoration' ] . ';' : '';
			$preview_styles .= !empty( $values[ 'text-align' ] ) ? 'text-align:' . $values[ 'text-align' ] . ';' : '';
			$preview_styles .= !empty( $values[ 'font-size' ] ) ? 'font-size:' . (int) $values[ 'font-size' ][ 'value' ] . $values[ 'font-size' ][ 'size' ] . ';' : '';
			$preview_styles .= !empty( $values[ 'line-height' ] ) ? 'line-height:' . (int) $values[ 'line-height' ][ 'value' ] . $values[ 'line-height' ][ 'size' ] . ';' : '';
			$preview_styles .= !empty( $values[ 'letter-spacing' ] ) ? 'letter-spacing:' . (int) $values[ 'letter-spacing' ][ 'value' ] . $values[ 'letter-spacing' ][ 'size' ] . ';' : '';
			$preview_styles .= !empty( $values[ 'color' ] ) ? 'color:' . $values[ 'color' ] . ';' : '';
		}
		
		return $preview_styles;
	}
}