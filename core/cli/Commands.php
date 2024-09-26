<?php
declare( strict_types = 1 );

namespace DHT\Core\Cli;

if ( ! defined( 'ABSPATH' ) ) {
	die( 'Forbidden' );
}

use WP_CLI;

/**
 * Class for custom WP-CLI commands.
 *
 * @since     1.0.0
 */
class Commands {
	
	/**
	 * Generate assets based on environment via vite utility
	 * wp dht init
	 *
	 * @return void
	 */
	public function init() : void {
		$this->install();
		$this->vite();
		WP_CLI::success( WP_CLI::colorize( "%GInitialization completed!%n" ) );
	}
	
	/**
	 * Install dependencies (Composer and NPM)
	 * wp dht install
	 *
	 * @return void
	 */
	public function install() : void {
		// Array of commands to execute
		$commands = [
			'composer clear-cache --ansi',
			'composer update --ansi',
			'composer install --ansi',
			'script -q /dev/null npm install'
		];
		
		foreach ( $commands as $command ) {
			WP_CLI::log( "Running: $command" );
			
			// Execute the shell command
			$output     = [];
			$return_var = 0;
			exec( "$command 2>&1", $output, $return_var );
			
			// Log the output of the command
			foreach ( $output as $line ) {
				echo $line . "\n";
			}
			
			// Check if the command was successful
			if ( $return_var !== 0 ) {
				WP_CLI::error( WP_CLI::colorize( "%RError occurred while running: $command%n" ) );
				
				return; // Exit the method on error
			}
		}
		
		WP_CLI::success( WP_CLI::colorize( "%GDependencies installed!%n" ) );
	}
	
	/**
	 * Generate assets based on environment
	 * wp dht vite [watch]
	 *
	 * @param array $args Command arguments (optional watch mode)
	 *
	 * @return void
	 */
	public function vite( array $args = [] ) : void {
		
		if ( in_array( 'watch', $args ) ) {
			if ( in_array( 'main', $args ) ) {
				$command = 'script -q /dev/null npm run watch:main';
			} else {
				$command = 'script -q /dev/null npm run watch';
			}
			$successMessage = "Assets generated in watch mode!";
		} else {
			if ( in_array( 'main', $args ) ) {
				$command = 'script -q /dev/null npm run build:main';
			} else {
				$command = 'script -q /dev/null npm run build';
			}
			$successMessage = "Assets generated for development!";
		}
		
		// Check if we're in watch mode
		$return_var = "";
		if ( in_array( 'watch', $args ) ) {
			// Use proc_open to handle real-time output for long-running watch mode
			$descriptors = [
				1 => [ 'pipe', 'w' ],  // stdout
				2 => [ 'pipe', 'w' ],  // stderr
			];
			
			// Open the process
			$process = proc_open( $command, $descriptors, $pipes );
			
			if ( is_resource( $process ) ) {
				// Read stdout in real-time
				while( ! feof( $pipes[ 1 ] ) ) {
					$output = fgets( $pipes[ 1 ] );
					if ( $output !== false ) {
						echo $output;
					}
				}
				
				// Close pipes and get the exit status
				fclose( $pipes[ 1 ] );
				$return_var = proc_close( $process );
			}
		} else {
			// Execute the command and capture output
			$output     = [];
			$return_var = 0;
			exec( "$command 2>&1", $output, $return_var );
			
			// Log the output of the command
			foreach ( $output as $line ) {
				echo $line . "\n";
			}
		}
		
		// Check if the command was successful
		if ( $return_var !== 0 ) {
			WP_CLI::error( WP_CLI::colorize( "%RError occurred while running: $command%n" ) );
			
			// After command execution, display success message
			WP_CLI::success( WP_CLI::colorize( "%G$successMessage%n" ) );
		}
		
	}
	
	/**
	 * Clean up generated files
	 * wp dht clean
	 *
	 * @return void
	 */
	public function clean() : void {
		
		WP_CLI::log( 'Cleaning up...' );
		
		// Execute the shell command to remove JS generated files
		$output     = [];
		$return_var = 0;
		exec( 'script -q /dev/null node helpers/node/remove-js-generated-files.js 2>&1', $output, $return_var );
		
		// Log the output of the command
		foreach ( $output as $line ) {
			echo $line . "\n";
		}
		
		// Check if the command was successful
		if ( $return_var === 0 ) {
			WP_CLI::success( WP_CLI::colorize( "%GFiles removed!%n" ) );
		} else {
			WP_CLI::error( WP_CLI::colorize( "%RError occurred while cleaning files!%n" ) );
		}
	}
	
	/**
	 * Display help for available commands
	 * wp dht help
	 *
	 * @return void
	 */
	public function help() : void {
		WP_CLI::log( "" );
		WP_CLI::log( WP_CLI::colorize( "%4 Available commands:                                              %n" ) );
		WP_CLI::log( WP_CLI::colorize( '%G  wp dht init%n             Install dependencies and generate assets' ) );
		WP_CLI::log( "                          ----------------------------------------" );
		WP_CLI::log( WP_CLI::colorize( '%B  wp dht install%n          Install dependencies (Composer & NPM)' ) );
		WP_CLI::log( "                          ----------------------------------------" );
		WP_CLI::log( WP_CLI::colorize( '%P  wp dht vite [watch]%n     Generate assets via the vite utility' ) );
		WP_CLI::log( "                          ----------------------------------------" );
		WP_CLI::log( WP_CLI::colorize( '                          %Y@param watch%n - enable watch mode
			  %Y@param main%n  - compile all files into one main.css and main.js file
			  ( using dynamic module loading )' ) );
		WP_CLI::log( "                          ----------------------------------------" );
		WP_CLI::log( WP_CLI::colorize( '%R  wp dht clean%n            Clean up generated files
			  ( if using tsc compiler, it will generate js files alongside ts files )' ) );
		WP_CLI::log( "                          ----------------------------------------" );
		WP_CLI::log( WP_CLI::colorize( '%C  wp dht help%n             Show this help message' ) );
	}
	
}