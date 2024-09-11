<?php

declare( strict_types = 1 );

if( !defined( 'DHT_MAIN' ) ) die( 'Forbidden' );

//framework manifest
//name, version, requirements and other useful things

$manifest = [];

$manifest[ 'name' ] = _x( 'Framework', 'manifest', DHT_PREFIX );
$manifest[ 'uri' ] = 'https://github.com/puyaalexxx/devhunters-fw';
$manifest[ 'description' ] = _x( 'Framework for DevHunters plugins', DHT_PREFIX );
$manifest[ 'version' ] = '1.0.0';
$manifest[ 'author' ] = 'DevHunters';
$manifest[ 'author_uri' ] = 'https://devhunters.dev';
$manifest[ 'requirements' ] = [
    'wordpress' => [
        'min_version' => '6.5'
    ],
    'php'       => [
        'min_version' => '8.0'
    ]
];

$manifest[ 'extensions' ] = [
    'cpt'             => [
        'description' => _x( 'Creating custom post types dynamically from option configurations', 'manifest', DHT_PREFIX )
    ],
    'dashboard-pages' => [
        'description' => _x( 'Creating dashboard menu pages and subpages dynamically from option configurations', 'manifest', DHT_PREFIX )
    ],
    'sidebars'        => [
        'description' => _x( 'Creating sidebars dynamically from option configurations also adding a dynamic form to wigets area to create sidebars on the fly', 'manifest', DHT_PREFIX )
    ],
    'widgets'         => [
        'description' => _x( 'Small extension to create widgets dynamically from an array of widget names', 'manifest', DHT_PREFIX )
    ],
    'options'         => [
        'description' => _x( 'An extension to create different options to be used on dashboard area and different post types', 'manifest', DHT_PREFIX )
    ],
];