<?php

declare( strict_types = 1 );

if ( !defined( 'DHT_MAIN' ) ) die( 'Forbidden' );

//framework manifest
//name, version, requirements and other useful things

$manifest = [];

$manifest['name']         = _x('Framework', 'manifest' , DHT_PREFIX);
$manifest['uri']          = 'https://github.com/puyaalexxx/devhunters-fw';
$manifest['description']  = _x('Framework for DevHunters plugins', DHT_PREFIX);
$manifest['version']      = '1.0.0';
$manifest['author']       = 'DevHunters';
$manifest['author_uri']   = 'https://devhunters.dev';
$manifest['requirements'] = array(
    'wordpress' => array(
        'min_version' => '6.5'
    ),
    'php' => array(
        'min_version' => '8.0'
    ),
);
$manifest['extensions'] = array(
    'cpt' => array(
        'description' => _x('Creating custom post types dynamically from option configurations', DHT_PREFIX)
    ),
    'dashboard-pages' => array(
        'description' => _x('Creating dashboard menu pages and subpages dynamically from option configurations', DHT_PREFIX)
    ),
    'sidebars' => array(
        'description' => _x('Creating sidebars dynamically from option configurations also adding a dynamic form to wigets area to create sidebars on the fly', DHT_PREFIX)
    ),
    'widgets' => array(
        'description' => _x('Small extension to create widgets dynamically from an array of widget names', DHT_PREFIX)
    ),
    'options' => array(
        'description' => _x('An extension to create different options to be used on dashboard area and different post types', DHT_PREFIX)
    ),
);