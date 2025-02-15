<?php
declare( strict_types = 1 );

namespace DHT\Helpers\Classes;

use FontLib\Exception\FontNotFoundException;
use FontLib\Font;
use function DHT\Helpers\dht_get_font_weight_Label;

if( !defined( 'DHT_MAIN' ) ) {
	die( 'Forbidden' );
}

/**
 * Helper methods for Typography option field
 */
final class TypographyHelpers {
	
	/**
	 * get Google fonts stored in assets/fonts area
	 *
	 * @return array
	 * @since     1.0.0
	 */
	public static function getGoogleFonts() : array {
		
		$google_fonts_path = DHT_ASSETS_DIR . 'fonts/google-fonts/google-fonts.json';
		
		if( !file_exists( $google_fonts_path ) ) {
			return [];
		}
		
		$data  = file_get_contents( $google_fonts_path );
		$fonts = json_decode( $data, true );
		
		$fonts_family = $font_weights = $font_subsets = [];
		foreach ( $fonts[ 'items' ] as $font ) {
			$fonts_family[ $font[ 'family' ] ][ 'family' ] = $font[ 'family' ];
			$font_weights[ $font[ 'family' ] ]             = $fonts_family[ $font[ 'family' ] ][ 'weights' ] = self::prepareFontWeights( $font[ 'variants' ] );
			$font_subsets[ $font[ 'family' ] ]             = $fonts_family[ $font[ 'family' ] ][ 'subsets' ] = $font[ 'subsets' ];
		}
		
		$google_fonts = [
			'google-fonts' => $fonts_family,
			'font-weights' => $font_weights,
			'font-subsets' => $font_subsets
		];
		
		return apply_filters( 'dht:options:fields:typography_google_fonts', $google_fonts );
	}
	
	/**
	 * prepare font weights to be used in the typography option
	 *
	 * @param int | array $font_weights
	 *
	 * @return array
	 * @since     1.0.0
	 */
	public static function prepareFontWeights( $font_weights ) : array {
		
		if( is_array( $font_weights ) ) {
			
			$font_weights_result = [];
			foreach ( $font_weights as $font_weight ) {
				
				//skip the italic ones
				if( str_contains( $font_weight, 'italic' ) ) {
					continue;
				}
				
				//change to a number to be consistent
				if( $font_weight == 'regular' ) {
					$font_weight = 400;
				}
				
				$font_weight_label = dht_get_font_weight_Label( (int) $font_weight );
				
				$font_weights_result[ $font_weight ] = $font_weight_label;
			}
		}
		else {
			
			$font_weight_label = dht_get_font_weight_Label( $font_weights );
			
			$font_weights_result[ $font_weights ] = $font_weight_label;
		}
		
		return $font_weights_result;
	}
	
	/**
	 * get Divi fonts info from the et-fonts folder
	 *
	 * @return array
	 * @since     1.0.0
	 */
	public static function getDiviFonts() : array {
		
		$upload_dir = wp_upload_dir();
		
		// Specify the folder name you want to check
		$et_folder_name = 'et-fonts';
		$et_folder_path = $upload_dir[ 'basedir' ] . '/' . $et_folder_name;
		
		$et_fonts = [];
		if( is_dir( $et_folder_path ) ) {
			
			// Get the list of files and directories in the folder
			$et_folder_contents = scandir( $et_folder_path );
			
			// Remove "." and ".." from the list
			$et_folder_contents = array_diff( $et_folder_contents, array(
				'.',
				'..'
			) );
			
			// Check if the folder is not empty
			if( !empty( $et_folder_contents ) ) {
				
				// Filter files with .ttf and .otf extensions
				$et_font_files = array_filter( $et_folder_contents, function( $file ) {
					
					// Check if the file has either .ttf or .otf extension
					return pathinfo( $file, PATHINFO_EXTENSION ) === 'ttf' || pathinfo( $file, PATHINFO_EXTENSION ) === 'otf';
				} );
				
				// Create a Font object
				foreach ( $et_font_files as $et_font_name ) {
					
					$font      = '';
					$font_path = $et_folder_path . '/' . $et_font_name;
					$font_uri  = $upload_dir[ 'baseurl' ] . '/' . $et_folder_name . '/' . $et_font_name;
					
					//get font info
					try {
						$font = Font::load( $font_path );
					} catch( FontNotFoundException $e ) {
						
						echo _x( "Error: Font file not found or could not be loaded.\n", 'options', 'dht' );
					}
					//this is to get the font weight
					$font->parse();
					
					//////Font prefix added to the font name because if the font name match the other font, from Google maybe,/////
					//////then it will pick the Google font and not the custom one on page reload/////
					$font_name = DHT_PREFIX . '-' . $font->getFontName();
					
					// set the font path
					$et_fonts[ $font_name ][ 'path' ] = $font_uri;
					// set the font name
					$et_fonts[ $font_name ][ 'name' ] = $font->getFontName();
					// set the font weights
					$et_fonts[ $font_name ][ 'weight' ] = self::prepareFontWeights( (int) $font->getFontWeight() );
					
					$font->close();
				}
			}
		}
		
		return $et_fonts;
	}
	
	/**
	 * get all option values default or saved ones
	 *
	 * @param array $value
	 * @param bool  $associativeArray Return an associative array
	 *
	 * @return array
	 * @since     1.0.0
	 */
	public static function getOptionValues( array $value, bool $associativeArray = false ) : array {
		
		$font_family_value = !empty( $value[ 'font-family' ] ) ? $value[ 'font-family' ] : '';
		
		//font values
		$font_value      = !empty( $font_family_value[ 'font' ] ) ? $font_family_value[ 'font' ] : '';
		$font_type_value = !empty( $font_family_value[ 'font-type' ] ) ? $font_family_value[ 'font-type' ] : '';
		$font_path_value = !empty( $font_family_value[ 'font-path' ] ) ? $font_family_value[ 'font-path' ] : '';
		
		//other dropdown values
		$font_weight_value     = !empty( $value[ 'font-weight' ] ) ? $value[ 'font-weight' ] : '';
		$font_subsets_value    = !empty( $value[ 'font-subsets' ] ) ? $value[ 'font-subsets' ] : '';
		$font_style_value      = !empty( $value[ 'font-style' ] ) ? $value[ 'font-style' ] : '';
		$text_transform_value  = !empty( $value[ 'text-transform' ] ) ? $value[ 'text-transform' ] : '';
		$text_decoration_value = !empty( $value[ 'text-decoration' ] ) ? $value[ 'text-decoration' ] : '';
		$text_align_value      = !empty( $value[ 'text-align' ] ) ? $value[ 'text-align' ] : '';
		$font_size_value       = !empty( $value[ 'font-size' ] ) ? $value[ 'font-size' ] : '';
		$line_height_value     = !empty( $value[ 'line-height' ] ) ? $value[ 'line-height' ] : '';
		$letter_spacing_value  = !empty( $value[ 'letter-spacing' ] ) ? $value[ 'letter-spacing' ] : '';
		$text_color_value      = !empty( $value[ 'color' ] ) ? $value[ 'color' ] : '';
		
		return [
			$font_value,
			$font_type_value,
			$font_path_value,
			$font_weight_value,
			$font_subsets_value,
			$font_style_value,
			$text_transform_value,
			$text_decoration_value,
			$text_align_value,
			$font_size_value,
			$line_height_value,
			$letter_spacing_value,
			$text_color_value
		];
	}
	
	/**
	 * get font type
	 *
	 * @param string $font_value
	 * @param array  $google_fonts
	 * @param array  $et_fonts
	 *
	 * @return string
	 * @since     1.0.0
	 */
	public static function getFontType( string $font_value, array $google_fonts, array $et_fonts ) : string {
		
		$font_type = 'standard';
		if( array_key_exists( $font_value, $google_fonts ) ) {
			$font_type = 'google';
		}
		elseif( array_key_exists( $font_value, $et_fonts ) ) {
			$font_type = 'divi';
		}
		
		return $font_type;
	}
	
}