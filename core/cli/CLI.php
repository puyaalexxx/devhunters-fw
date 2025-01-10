<?php
declare( strict_types = 1 );

namespace DHT\Core\Cli;

if( !defined( 'DHT_MAIN' ) ) {
	die( 'Forbidden' );
}

use WP_CLI;

/**
 * Register available CLI commands
 *
 * @since     1.0.0
 */
final class CLI {
	
	/**
	 * @since     1.0.0
	 */
	public function __construct() {}
	
	/**
	 * Register available CLI commands
	 *
	 * @param array $commands Custom cli commands ['name', 'class']
	 *
	 * @return void
	 * @since     1.0.0
	 */
	public function registerCustomCliCommands( array $commands = [] ) : void {
		
		if( class_exists( 'WP_CLI' ) ) {
			if( !empty( $commands ) ) {
				foreach ( $commands as $command ) {
					WP_CLI::add_command( $command[ 'name' ], $command[ 'class' ] );
				}
			}
			else {
				// Register framework commands
				WP_CLI::add_command( 'dht', 'DHT\Core\Cli\Commands' );
			}
		}
		else {
			WP_CLI::log( _x( 'WP_CLI class does not exist. Make sure you are running from CLI.', 'cli', 'dht' ) );
		}
	}
	
}
