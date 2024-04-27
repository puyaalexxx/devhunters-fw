<?php
declare( strict_types = 1 );

namespace DHT;

if ( !defined( 'ABSPATH' ) ) die( 'Forbidden' );

/*
 * Directory PATHs
 *
 * */

define( 'DHT_MAIN', true );

//core folder
define( 'DHT_DIR', plugin_dir_path( __FILE__ ) );

define( 'DHT_ASSETS_DIR', DHT_DIR . 'assets/' );

define( 'DHT_HELPERS_DIR', DHT_DIR . 'helpers/' );

//extensions folder
define( 'DHT_EXTENSIONS_DIR', DHT_DIR . 'extensions/' );
define( 'DHT_OPTIONS_DIR', DHT_EXTENSIONS_DIR . 'options/' );

define( 'DHT_TEMPLATES_DIR', DHT_DIR . 'templates/' );


/*
 * URL PATHs
 *
 * */
define( 'DHT_URI', plugin_dir_url( __FILE__ ) );

define( 'DHT_ASSETS_URI', DHT_URI . 'assets/' );
