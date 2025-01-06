<?php
declare( strict_types = 1 );

namespace DHT\Helpers;

if( !defined( 'DHT_MAIN' ) ) {
	die( 'Forbidden' );
}

use DHT\Helpers\Classes\Dumper;

if( !function_exists( 'dht_print_r' ) ) {
	/**
	 * print_r alternative with styling
	 * A nicer way to print values
	 *
	 * @param mixed $value the value to be printed
	 *
	 * @return void
	 * @since     1.0.0
	 */
	function dht_print_r( mixed $value ) : void {
		
		static $first_time = true;
		
		if( $first_time ) {
			ob_start();
			echo '<style>
		div.dht_print_r {
			max-height: 500px;
			overflow-y: scroll;
			background: #23282d;
			margin: 10px 30px;
			padding: 0;
			border: 1px solid #F5F5F5;
			border-radius: 3px;
			position: relative;
			z-index: 11111;
		}

		div.dht_print_r pre {
			color: #78FF5B;
			background: #23282d;
			text-shadow: 1px 1px 0 #000;
			font-family: Consolas, monospace;
			font-size: 12px;
			margin: 0;
			padding: 5px;
			display: block;
			line-height: 16px;
			text-align: left;
		}

		div.dht_print_r_group {
			background: #f1f1f1;
			margin: 10px 30px;
			padding: 1px;
			border-radius: 5px;
			position: relative;
			z-index: 11110;
		}
		div.dht_print_r_group div.dht_print_r {
			margin: 9px;
			border-width: 0;
		}
		</style>';
			echo str_replace( array(
				'  ',
				"\n"
			), '', ob_get_clean() );
			
			$first_time = false;
		}
		
		if( func_num_args() == 1 ) {
			echo '<div class="dht_print_r"><pre>';
			echo htmlspecialchars( Dumper::dump( $value ), ENT_QUOTES, 'UTF-8' );
			echo '</pre></div>';
		}
		else {
			echo '<div class="dht_print_r_group">';
			foreach ( func_get_args() as $param ) {
				dht_print_r( $param );
			}
			echo '</div>';
		}
	}
}


if( !function_exists( 'dht_fix_path' ) ) {
	/**
	 * Convert to Unix style directory separators
	 *
	 * @param string $path - dir path
	 *
	 * @return string
	 * @since     1.0.0
	 */
	function dht_fix_path( string $path ) : string {
		
		$windows_network_path = isset( $_SERVER[ 'windir' ] ) && in_array( substr( $path, 0, 2 ), array(
				'//',
				'\\\\'
			), true );
		$fixed_path           = untrailingslashit( str_replace( array(
			'//',
			'\\'
		), array(
			'/',
			'/'
		), $path ) );
		
		if( empty( $fixed_path ) && !empty( $path ) ) {
			$fixed_path = '/';
		}
		
		if( $windows_network_path ) {
			$fixed_path = '//' . ltrim( $fixed_path, '/' );
		}
		
		return $fixed_path;
	}
}


if( !function_exists( 'dht_load_view' ) ) {
	/**
	 * load file with passed arguments and display it or return its content
	 *
	 * @param string $path   - dir path
	 * @param string $file   - file name
	 * @param array  $args   - arguments to be passed into the view
	 * @param bool   $return - return the file content or display it
	 *
	 * @return string
	 * @since     1.0.0
	 */
	function dht_load_view( string $path, string $file, array $args = [], bool $return = true ) : string {
		
		$file_path = $path . $file;
		
		if( !is_file( $file_path ) && !file_exists( $file_path ) ) {
			
			require_once( DHT_VIEWS_DIR . "main-view.php" );
			
			return '';
		}
		
		if( $return ) {
			ob_start();
			require $file_path;
			
			return ob_get_clean();
		}
		else {
			require $file_path;
		}
		
		return '';
	}
}


if( !function_exists( 'dht_get_variables_from_file' ) ) {
	/**
	 * Safe load variables from a file
	 * Use this function to not include files directly and to not give access to current context variables (like $this)
	 *
	 * @param string $file_path        File path
	 * @param string $extract_variable Extract these from file array('variable_name' => 'default_value')
	 * @param array  $set_variables    Set these to be available in file (like variables in view)
	 * @param bool   $return_array     return array or only the value
	 *
	 * @return array
	 * @since     1.0.0
	 */
	function dht_get_variables_from_file( string $file_path, string $extract_variable, array $set_variables = [], bool $return_array = false ) : array {
		
		if( !file_exists( $file_path ) ) return [];
		
		extract( $set_variables, EXTR_REFS );
		unset( $set_variables );
		
		require $file_path;
		
		if( $return_array ) {
			foreach ( $$extract_variable as $variable_name => $default_value ) {
				
				if( isset( $$variable_name ) ) {
					$$extract_variable[ $variable_name ] = $$variable_name;
				}
			}
			
			$option = (array) $$extract_variable;
		}
		else {
			$option = $$extract_variable;
		}
		
		return $option;
	}
}

if( !function_exists( 'dht_get_returned_variables_from_file' ) ) {
	/**
	 * Safe load the returned variables from a file without knowing its name
	 *
	 * @param string $file_path
	 *
	 * @return array
	 * @since     1.0.0
	 */
	function dht_get_returned_variables_from_file( string $file_path ) : array {
		
		if( !file_exists( $file_path ) ) return [];
		
		// Include the file and capture the return value
		return require $file_path; // Return the complete array
	}
}


if( !function_exists( 'dht_parse_css_classes_into_array' ) ) {
	/**
	 * Parse CSS icons classes and content codes to a PHP array with key value pairs
	 *
	 * @param string $css              CSS code
	 * @param string $before_delimiter :before pseudo css delimiter it could be : or ::
	 *
	 * @return array
	 * @since     1.0.0
	 */
	function dht_parse_css_classes_into_array( string $css, string $before_delimiter = ':' ) : array {
		
		// Regular expression pattern to extract class name and content
		$pattern = '/\.([a-zA-Z0-9_-]+)' . $before_delimiter . 'before\s*{\s*content:\s*"([^"]+)"/';
		
		// Initialize an array to store class names and content values
		$classContentArray = array();
		
		// Perform the regular expression match
		preg_match_all( $pattern, $css, $matches, PREG_SET_ORDER );
		
		// Loop through matches and store in the array
		foreach ( $matches as $match ) {
			// $match[1] contains class name, $match[2] contains content
			$classContentArray[ $match[ 1 ] ] = $match[ 2 ];
		}
		
		return $classContentArray;
	}
}

if( !function_exists( 'dht_get_font_weight_Label' ) ) {
	/**
	 * gent font weight label from its value (ex: 400, 500) - 200 == 'Extra Light'
	 *
	 * @param int $font_weight Font weight number
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
}

if( !function_exists( 'dht_get_css_units' ) ) {
	/**
	 * get available sizes like px, em, rem
	 *
	 * @param array $disable_units What values from the to disable - ["px"  => true]
	 *
	 * @return array
	 * @since     1.0.0
	 */
	function dht_get_css_units( array $disable_units = [] ) : array {
		
		$default_units = [
			"px"  => true,
			"%"   => true,
			"em"  => true,
			"rem" => true,
			"vw"  => true,
			"vh"  => true
		];
		
		// Merge the provided $disable_units with $default_units (with priority to the provided array)
		$default_units = array_merge( $default_units, $disable_units );
		
		// Filter out units that have the value false and return the key => key format
		$enabled_units = array_filter( $default_units, function( $value ) {
			return $value !== false; // Retain only values that are not false
		} );
		
		$units = [];
		foreach ( $enabled_units as $unit => $enabled ) {
			$units[ $unit ] = $unit;
		}
		
		return $units;
	}
}

if( !function_exists( 'dht_border_styles' ) ) {
	/**
	 * get available border styles
	 *
	 * @return array
	 * @since     1.0.0
	 */
	function dht_border_styles() : array {
		
		return apply_filters( 'dht:options:fields:borders_styles_args', [
			"none"   => _x( 'None', 'options', DHT_PREFIX ),
			"solid"  => _x( 'Solid', 'options', DHT_PREFIX ),
			"dashed" => _x( 'Dashed', 'options', DHT_PREFIX ),
			"dotted" => _x( 'Dotted', 'options', DHT_PREFIX ),
			"double" => _x( 'Double', 'options', DHT_PREFIX ),
			"groove" => _x( 'Groove', 'options', DHT_PREFIX ),
			"ridge"  => _x( 'Ridge', 'options', DHT_PREFIX ),
			"inset"  => _x( 'Inset', 'options', DHT_PREFIX ),
			"outset" => _x( 'Outset', 'options', DHT_PREFIX ),
		] );
	}
}

if( !function_exists( 'dht_get_font_format_by_its_extension' ) ) {
	/**
	 * Get font format from the font link extensions
	 * Used for format('truetype')
	 *
	 * @param string $font_url Font URL
	 *
	 * @return string
	 * @since     1.0.0
	 */
	function dht_get_font_format_by_its_extension( string $font_url ) : string {
		// Extract the file extension from the URL
		$file_extension = pathinfo( $font_url, PATHINFO_EXTENSION );
		
		// Determine the font format based on the extension
		return match ( $file_extension ) {
			'otf' => 'opentype',
			'ttf' => 'truetype',
			'woff' => 'woff',
			'woff2' => 'woff2',
			default => 'truetype',
		};
	}
}