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

define( 'DHT_HELPERS_DIR', DHT_DIR . 'helpers/' );

define( 'DHT_INTERFACES_DIR', DHT_DIR . 'interfaces/' );

define( 'DHT_OPTIONS_DIR', DHT_DIR . 'options/' );

define( 'DHT_PAGES_DIR', DHT_DIR . 'pages/' );

define( 'DHT_TEMPLATES_DIR', DHT_DIR . 'templates/' );

/*
 * URL PATHs
 *
 * */
define( 'DHT_URI', plugin_dir_url( __FILE__ ) );

define( 'DHT_ASSETS_URI', DHT_URI . 'assets/' );
