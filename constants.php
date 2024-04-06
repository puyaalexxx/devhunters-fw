<?php
declare(strict_types=1);

namespace DHT\src;

/*
 * Directory PATHs
 *
 * */

//core folder
define( 'DHT_CORE_DIR', plugin_dir_path( __FILE__ ) );

define( 'DHT_HELPERS_DIR', DHT_CORE_DIR . 'helpers/' );

define( 'DHT_INTERFACES_DIR', DHT_CORE_DIR . 'interfaces/' );

define( 'DHT_OPTIONS_DIR', DHT_CORE_DIR . 'options/' );

define( 'DHT_PAGES_DIR', DHT_CORE_DIR . 'pages/' );

define( 'DHT_TEMPLATES_DIR', DHT_CORE_DIR . 'templates/' );

/*
 * URL PATHs
 *
 * */
define( 'DHT_CORE_PATH', plugin_dir_url( __FILE__ ) );
