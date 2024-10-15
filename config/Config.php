<?php
declare( strict_types = 1 );

namespace DHT\Config;

if( !defined( 'PPHT_MAIN' ) ) {
	die( 'Forbidden' );
}

use function DHT\Helpers\dht_get_current_admin_post_type_from_url;
use function DHT\Helpers\dht_get_current_admin_taxonomy_from_url;
use function DHT\Helpers\dht_get_returned_variables_from_file;
use function DHT\Helpers\dht_get_variables_from_file;
use function DHT\Helpers\dht_is_post_editing_area;
use function DHT\Helpers\dht_is_term_editing_area;

/**
 * Static class for grabbing all plugin configurations
 */
final class Config {
	
	/**
	 * get options types for the dashboard pages
	 *
	 * @param string $folder_path Folder path where the options are located
	 *
	 * @return array
	 * @since     1.0.0
	 */
	public static function getDashboardPagesOptions( string $folder_path ) : array {
		
		if( empty( $folder_path ) || !isset( $_GET[ 'page' ] ) ) return [];
		
		$options = [];
		
		$files = glob( $folder_path . '*php' );
		
		foreach ( $files as $file ) {
			$file_name = basename( $file );
			
			//if the filename don't match the path, skip it
			if( $_GET[ 'page' ] != pathinfo( $file_name, PATHINFO_FILENAME ) ) continue;
			
			$options = self::getConfigurations( $file );
		}
		
		return $options;
	}
	
	/**
	 * get options for the post types
	 *
	 * @param string $folder_path Folder path where the options are located
	 *
	 * @return array
	 * @since     1.0.0
	 */
	public static function getPostTypeOptions( string $folder_path ) : array {
		
		if( empty( $folder_path ) || !dht_is_post_editing_area() ) return [];
		
		$options = [];
		
		$files = glob( $folder_path . '*php' );
		
		foreach ( $files as $file ) {
			$file_name = basename( $file );
			
			//if the filename don't match the path, skip it
			if( dht_get_current_admin_post_type_from_url() != pathinfo( $file_name, PATHINFO_FILENAME ) ) continue;
			
			$options = self::getConfigurations( $file );
		}
		
		return $options;
	}
	
	/**
	 * get options for the terms
	 *
	 * @param string $folder_path Folder path where the options are located
	 *
	 * @return array
	 * @since     1.0.0
	 */
	public static function getTermsOptions( string $folder_path ) : array {
		
		if( empty( $folder_path ) || !dht_is_term_editing_area() ) return [];
		
		$options = [];
		
		$files = glob( $folder_path . '*php' );
		
		foreach ( $files as $file ) {
			$file_name = basename( $file );
			
			//if the filename don't match the path, skip it
			if( dht_get_current_admin_taxonomy_from_url() != pathinfo( $file_name, PATHINFO_FILENAME ) ) continue;
			
			$options = self::getConfigurations( $file );
		}
		
		return $options;
	}
	
	/**
	 * get options for vb modals
	 *
	 * @param string $folder_path Folder path where the options are located
	 * @param array  $post_types  Where the options should be added
	 *
	 * @return array
	 * @since     1.0.0
	 */
	public static function getVbOptions( string $folder_path, array $post_types ) : array {
		
		$current_post_type = dht_get_current_admin_post_type_from_url();
		
		// Early return if conditions are not met
		if( empty( $folder_path ) || !dht_is_post_editing_area() || empty( $post_types ) || !in_array( $current_post_type, $post_types ) ) {
			return [];
		}
		
		$options = [];
		
		// Function to process files in a directory
		$processFiles = function( string $path ) use ( &$options ) {
			$files = glob( $path . '/*.php' );
			foreach ( $files as $file ) {
				$file_name             = pathinfo( $file, PATHINFO_FILENAME );
				$options[ $file_name ] = self::getConfigurations( $file );
			}
		};
		
		// Check if specific post type directory exists
		foreach ( $post_types as $post_type ) {
			$post_type_path = $folder_path . $post_type;
			
			if( is_dir( $post_type_path ) ) {
				// Process files only for the current post type
				if( $current_post_type === $post_type ) {
					$processFiles( $post_type_path );
				}
			}
		}
		
		// Process files in the main folder
		$processFiles( $folder_path );
		
		return $options;
	}
	
	/**
	 * get specific plugin configurations
	 *
	 * @param string $file_path - file from where to get the configurations
	 * @param string $conf_name - configuration name that you want to extract
	 *
	 * @return array of dashboard menu configurations
	 * @since     1.0.0
	 */
	public static function getConfigurations( string $file_path, string $conf_name = '' ) : array {
		
		return !empty( $conf_name ) ? dht_get_variables_from_file( $file_path, $conf_name ) : dht_get_returned_variables_from_file( $file_path );
	}
	
}