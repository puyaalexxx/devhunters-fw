<?php
declare( strict_types = 1 );

if ( !defined( 'PPHT_MAIN' ) ) die( 'Forbidden' );

$template_path = ''; //PPHT_TEMPLATES_DIR . 'dashboard-pages/';

$main_menu_slug = PPHT_PREFIX . '-main-settings';
$settings_slug = PPHT_PREFIX . '-general-settings';
$text_module_slug = PPHT_PREFIX . '-text-module-settings';

$main_menu = [
    'page_title' => _x( 'PopHunters Page', 'menu settings', PPHT_PREFIX ),
    'menu_title' => _x( 'PopHunters', 'menu settings', PPHT_PREFIX ),
    'capability' => 'manage_options',
    'menu_slug' => $main_menu_slug,
    'callback' => 'main-template',
    'icon_url' => DHT_ASSETS_URI . 'images/devhuntersmain-logo-dashmenu.png',
    'position' => 99,
    'template_path' => $template_path,
    //'api_endpoint' => $main_menu_slug,
    'additional_options' => []
];

$submenu_items_values = [
    'settings' => [
        'parent_slug' => $main_menu_slug,
        'page_title' => _x( 'PopHunters General Settings', 'menu settings', PPHT_PREFIX ),
        'menu_title' => _x( 'General Settings', 'menu settings', PPHT_PREFIX ),
        'capability' => 'manage_options',
        'menu_slug' => $settings_slug,
        'callback' => 'main-template',
        'template_path' => $template_path,
        'api_endpoint' => $settings_slug,
        'additional_options' => []
    ],
    'text-module' => [
        'parent_slug' => $main_menu_slug,
        'page_title' => _x( 'PopHunters Text Module Settings', 'menu settings', PPHT_PREFIX ),
        'menu_title' => _x( 'Text Module', 'menu settings', PPHT_PREFIX ),
        'capability' => 'manage_options',
        'menu_slug' => $text_module_slug,
        'callback' => 'main-template',
        'template_path' => $template_path,
        //'api_endpoint' => $text_module_slug,
        'additional_options' => []
    ],
    
    //cpt - adding cpt in the same parent menu item area
    'popupht' => [
        'parent_slug' => $main_menu_slug,
        'page_title' => _x( 'PopHunters Post Page', 'menu settings', PPHT_PREFIX ),
        'menu_title' => _x( 'Popups', 'menu settings', PPHT_PREFIX ),
        'capability' => 'manage_options',
        'menu_slug' => 'edit.php?post_type=popupht',
        'callback' => '',
        'template_path' => '',
        'additional_options' => [ 'aaaaa' ]
    ],
    //taxonomy - adding taxonomy in the same parent menu item area
    'popup_group_tax' => [
        'parent_slug' => $main_menu_slug,
        'page_title' => _x( 'PopHunters Groups', 'menu settings', PPHT_PREFIX ),
        'menu_title' => _x( 'Groups', 'menu settings', PPHT_PREFIX ),
        'capability' => 'manage_options',
        'menu_slug' => 'edit-tags.php?taxonomy=popup_group_tax&post_type=popupht',
        'callback' => '',
        'template_path' => '',
        'additional_options' => []
    ],
    
    //other plugin pages
    'help' => [
        'parent_slug' => $main_menu_slug,
        'page_title' => _x( 'PopHunters Help Page', 'menu settings', PPHT_PREFIX ),
        'menu_title' => _x( 'Help', 'menu settings', PPHT_PREFIX ),
        'capability' => 'manage_options',
        'menu_slug' => 'ppht-help-page',
        'callback' => 'ppht_help_page',
        'template_path' => $template_path,
        'additional_options' => []
    ]
];

$dashmenus = [
    'main_menu' => $main_menu,
    'submenus' => $submenu_items_values
];
