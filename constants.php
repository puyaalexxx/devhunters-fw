<?php
declare( strict_types = 1 );

namespace DHT;

if( !defined( 'ABSPATH' ) ) {
	die( 'Forbidden' );
}

define( 'DHT_MAIN', true );

//framework prefix used as translation text domain, enqueue scripts
define( 'DHT_PREFIX', 'dht' );

//used to add a prefix for enqueued js files
define( 'DHT_PREFIX_JS', 'dht-script' );
//used to add a prefix for enqueued css files
define( 'DHT_PREFIX_CSS', 'dht-style' );
//main js file handle
define( 'DHT_MAIN_SCRIPT_HANDLE', DHT_PREFIX_JS . '-main-bundle' );

//core folder
define( 'DHT_DIR', plugin_dir_path( __FILE__ ) );

define( 'DHT_ASSETS_DIR', DHT_DIR . 'assets/' );

define( 'DHT_CONFIG_DIR', DHT_DIR . 'config/' );

define( 'DHT_HELPERS_DIR', DHT_DIR . 'helpers/' );

//core folder
define( 'DHT_CORE_DIR', DHT_DIR . 'core/' );
define( 'DHT_OPTIONS_DIR', DHT_CORE_DIR . 'options/' );
//extensions folder
define( 'DHT_EXTENSIONS_DIR', DHT_DIR . 'extensions/' );

define( 'DHT_VIEWS_DIR', DHT_DIR . 'views/' );

define( 'DHT_LANG', plugin_basename( dirname( __FILE__ ) ) . '/languages' );

/*
 * URL PATHs
 *
*/
define( 'DHT_URI', plugin_dir_url( __FILE__ ) );
define( 'DHT_ASSETS_URI', DHT_URI . 'assets/' );

//define( 'DHT_REACT_APP_URI', DHT_URI . 'src/' );
