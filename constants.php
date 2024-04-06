<?php
declare(strict_types=1);

namespace DHT;

/*
 * Directory PATHs
 *
 * */

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
define( 'DHT_PATH', plugin_dir_url( __FILE__ ) );
