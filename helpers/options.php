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
		
		if( empty( $option_id ) /*|| empty( $value )*/ ) {
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
			$borders = 'border-width:' . trim( esc_attr( $top_size ) . " " . esc_attr( $right_size ) . " " . esc_attr( $bottom_size ) . " " . esc_attr( $left_size ) ) . ';';
			$borders .= !empty( $values[ 'border-style' ] ) ? 'border-style:' . esc_attr( $values[ 'border-style' ] ) . ';' : "";
			$borders .= !empty( $values[ 'color' ] ) ? 'border-color:' . esc_attr( $values[ 'color' ] ) . ';' : "";
			
			return $borders;
		}
		else {
			return $css_property . ':' . trim( esc_attr( $top_size ) . " " . esc_attr( $right_size ) . " " . esc_attr( $bottom_size ) . " " . esc_attr( $left_size ) ) . ';';
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
			$preview_styles .= !empty( $values[ 'font-family' ] ) && !empty( $values[ 'font-family' ][ 'font' ] ) ? 'font-family:' . dht_remove_font_name_prefix( $values[ 'font-family' ][ 'font' ] ) . ', Arial, Helvetica, Lucida, sans-serif;' : '';
			$preview_styles .= !empty( $values[ 'font-weight' ] ) ? 'font-weight:' . $values[ 'font-weight' ] . ';' : 'font-weight:400;';
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

if( !function_exists( 'dht_get_background_field_css_properties' ) ) {
	/**
	 * Construct background fields css properties from the saved values.
	 * Pass the array of the values that you want for your background and the
	 * needed CSS will be returned
	 *
	 *   Expected bg array (several fields combined):
	 *
	 * <code>
	 * $array = [
	 *     'bg_image' => [
	 *          'image'    => 'https://testhunters:8890/wp-content/uploads/2024/09/2.webp',
	 *          'image_id' => 11
	 *     ],
	 *     'bg_color'      => 'rgb(30, 115, 190)',
	 *     'bg_repeat'     => 'no-repeat',
	 *     'bg_size'       => 'initial',
	 *     'bg_position'   => 'left top',
	 *     'bg_blend_mode' => 'overlay'
	 * ];
	 * </code>
	 *
	 * @param array $values
	 *
	 * @return string
	 * @since     1.0.0
	 */
	function dht_get_background_field_css_properties( array $values ) : string {
		
		$bg = '';
		if( !empty( $values ) ) {
			$bg .= !empty( $values[ 'bg_image' ] ) ? 'background-image:url(' . esc_url( $values[ 'bg_image' ][ 'image' ] ) . ');' : "";
			$bg .= !empty( $values[ 'bg_color' ] ) ? 'background-color:' . esc_attr( $values[ 'bg_color' ] ) . ';' : "";
			$bg .= !empty( $values[ 'bg_repeat' ] ) ? 'background-repeat:' . esc_attr( $values[ 'bg_repeat' ] ) . ';' : "";
			$bg .= !empty( $values[ 'bg_size' ] ) ? 'background-size:' . esc_attr( $values[ 'bg_size' ] ) . ';' : "";
			$bg .= !empty( $values[ 'bg_position' ] ) ? 'background-position:' . esc_attr( $values[ 'bg_position' ] ) . ';' : "";
			$bg .= !empty( $values[ 'bg_blend_mode' ] ) ? 'background-blend-mode:' . esc_attr( $values[ 'bg_blend_mode' ] ) . ';' : "";
		}
		
		return $bg;
	}
}


if( !function_exists( 'dht_build_google_fonts_enqueue_link' ) ) {
	/**
	 * Build the Google fonts link that needs to be enqueued
	 * This function will add all the passed google fonts
	 * in one link with their font weights and subsets
	 *
	 * Result Link: https://fonts.googleapis.com/css2?family=Felipa:wght@400&family=Graduate:wght@400&subset&display=swap
	 *
	 *  Expected fonts array (typography fields combined):
	 *
	 * <code>
	 *   $array = [
	 *   [
	 *       'font-family' => [
	 *           'font-type' => 'google',
	 *           'font-path' => '',
	 *           'font' => 'Felipa',
	 *       ],
	 *       'font-weight' => '',
	 *   ],
	 *   [
	 *       'font-family' => [
	 *           'font-type' => 'google',
	 *           'font-path' => '',
	 *           'font' => 'Felipa',
	 *       ],
	 *       'font-weight' => '',
	 *       'font-subsets' => '',
	 *   ],
	 *  ];
	 * </code>
	 *
	 * @param array $fonts Array of fonts
	 *
	 * @return string
	 * @since     1.0.0
	 */
	function dht_build_google_fonts_enqueue_link( array $fonts ) : string {
		
		$google_fonts_url = "";
		
		if( !empty( $fonts ) ) {
			//build fonts array with weights and subsets
			$font_values = [];
			foreach ( $fonts as $font ) {
				if( ( $font[ 'font-family' ][ 'font-type' ] ?? "" ) === "google" ) {
					//if font empty, skip iteration
					if( empty( $font[ 'font-family' ][ 'font' ] ) ) continue;
					
					$font_name   = $font[ 'font-family' ][ 'font' ];
					$font_weight = $font[ 'font-weight' ] ?? "";
					$font_subset = $font[ 'font-subsets' ] ?? "";
					
					if( !in_array( $font_weight, $font_values[ $font_name ][ "font-weights" ] ?? [] ) ) {
						$font_values[ $font_name ][ 'font-weights' ][] = !empty( $font_weight ) ? $font_weight : 400;
					}
					
					if( !in_array( $font_subset, $font_values[ $font_name ][ 'font-subsets' ] ?? [] ) ) {
						$font_values[ $font_name ][ 'font-subsets' ][] = $font_subset;
					}
				}
			}
			
			//build google fonts url to be enqueued
			if( !empty( $font_values ) ) {
				$fonts_family   = [];
				$unique_subsets = [];
				foreach ( $font_values as $font_name => $font_data ) {
					sort( $font_data[ 'font-weights' ], SORT_NUMERIC );
					
					// Handle font weights (only add if unique)
					if( !empty( $font_data[ 'font-weights' ] ) ) {
						$weights = implode( ';', array_map( 'trim', $font_data[ 'font-weights' ] ) );
						// Add font weights to the family (format: font-family:wght@...)
						$fonts_family[] = "{$font_name}:wght@{$weights}";
					}
					else {
						// Add the font family (without weights) to the family list
						$fonts_family[] = $font_name;
					}
					
					// Handle subsets (if defined)
					if( !empty( $font_data[ 'font-subsets' ] ) ) {
						// Ensure 'font-subsets' is always an array
						$subsets = is_array( $font_data[ 'font-subsets' ] ) ? $font_data[ 'font-subsets' ] : [ $font_data[ 'font-subsets' ] ];
						
						// Filter out empty subsets
						$filtered_subsets = array_filter( $subsets );
						$unique_subsets   = array_merge( $unique_subsets, $filtered_subsets );
					}
				}
				
				// Remove duplicate subsets
				$unique_subsets = array_unique( $unique_subsets );
				
				// Construct the Google Fonts URL
				$google_fonts_url_args = [
					'family'  => implode( '&family=', $fonts_family ),
					'subset'  => implode( ',', $unique_subsets ),
					'display' => 'swap'
				];
				
				// Build the final URL
				$google_fonts_url = esc_url_raw( add_query_arg( $google_fonts_url_args, 'https://fonts.googleapis.com/css2' ) );
			}
		}
		
		return $google_fonts_url;
	}
}

if( !function_exists( 'dht_build_custom_fonts_enqueue_styles' ) ) {
	/**
	 * Build the Custom fonts font face styles that needs to be enqueued
	 * This function will add all the passed custom fonts
	 * in one style with their font face styles
	 *
	 * Result: <style>@font-face {font-family:'dht-Monsieur La Doulaise';src:url('uploads/et-fonts/MonsieurLaDoulaise-Regular.ttf') format('truetype');font-display:swap;}</style>'
	 *
	 *  Expected fonts array (typography fields combined):
	 *
	 *  ```php
	 * $array = [
	 *  [
	 *      'font-family' => [
	 *          'font-type' => 'divi',
	 *          'font-path' => 'uploads/et-fonts/MonsieurLaDoulaise-Regular.ttf',
	 *          'font' => 'Felipa',
	 *      ],
	 *      'font-weight' => '',
	 *  ],
	 *  [
	 *      'font-family' => [
	 *          'font-type' => 'custom',
	 *          'font-path' => 'uploads/et-fonts/MonsieurLaDoulaise-Regular.ttf',
	 *          'font' => 'Felipa',
	 *      ],
	 *      'font-weight' => '',
	 *      'font-subsets' => '',
	 *  ],
	 * ];
	 *  ```
	 *
	 * @param array $fonts Array of fonts
	 *
	 * @return string
	 * @since     1.0.0
	 */
	function dht_build_custom_fonts_enqueue_styles( array $fonts ) : string {
		
		$font_face_styles = "";
		
		//custom uploaded fonts
		if( !empty( $fonts ) ) {
			//build fonts array
			$font_values = [];
			foreach ( $fonts as $font ) {
				if( ( $font[ 'font-family' ][ 'font-type' ] ?? "" ) !== "google" && ( $font[ 'font-family' ][ 'font-type' ] ?? "" ) !== "standard" ) {
					//if font empty, skip iteration
					if( empty( $font[ 'font-family' ][ 'font' ] ) ) continue;
					if( empty( $font[ 'font-family' ][ 'font-path' ] ) ) continue;
					
					$font_name                                = dht_remove_font_name_prefix( $font[ 'font-family' ][ 'font' ] );
					$font_values[ $font_name ][ 'font-path' ] = $font[ 'font-family' ][ 'font-path' ];
				}
			}
			
			//build font face styles
			if( !empty( $font_values ) ) {
				foreach ( $font_values as $font_name => $font_data ) {
					if( !empty( $font_data[ 'font-path' ] ) ) {
						$font_url         = esc_url( $font_data[ 'font-path' ] );
						$font_face_styles .= "@font-face {font-family: '" . $font_name . "';src: url('" . $font_url . "') format('" . dht_get_font_format_by_its_extension( $font_url ) . "');font-display: swap;}";
					}
				}
			}
		}
		
		return $font_face_styles;
	}
}

if( !function_exists( 'dht_get_icon_style_by_type' ) ) {
	/**
	 * Get icon style file link by its type
	 *
	 * @param string $icon_type Icon type to return style for
	 *
	 * @return array|string
	 * @since     1.0.0
	 */
	function dht_get_icon_style_by_type( string $icon_type = "all" ) : array|string {
		
		$icon_styles = apply_filters( 'dht:options:fields:icon_style_links', [
			"fontawesome" => DHT_ASSETS_URI . 'styles/libraries/fontawesome-icons.min.css',
			"divi"        => DHT_ASSETS_URI . 'styles/libraries/divi-icons.min.css',
			"elusive"     => DHT_ASSETS_URI . 'styles/libraries/elusive-icons.min.css',
			"line"        => DHT_ASSETS_URI . 'styles/libraries/line-icons.min.css',
			"dev"         => DHT_ASSETS_URI . 'styles/libraries/devicon-icons.min.css',
			"bootstrap"   => DHT_ASSETS_URI . 'styles/libraries/bootstrap-icons.min.css'
		] );
		
		if( $icon_type == "all" ) {
			return $icon_styles;
		}
		elseif( array_key_exists( $icon_type, $icon_styles ) ) {
			return $icon_styles[ $icon_type ];
		}
		
		return "";
	}
}