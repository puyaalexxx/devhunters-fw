<?php
declare( strict_types = 1 );

use DHT\Helpers\Classes\FWHelpers;

if( !defined( 'DHT_MAIN' ) ) {
	die( 'Forbidden' );
}

//framework manifest
//name, version, requirements and other useful things

$composer_info = FWHelpers::getComposerInfo();

$manifest[ 'name' ]         = $composer_info[ 'extra' ][ 'name' ] ?? '';
$manifest[ 'package_name' ] = $composer_info[ 'package_name' ] ?? '';
$manifest[ 'description' ]  = $composer_info[ 'description' ] ?? '';
$manifest[ 'version' ]      = $composer_info[ 'version' ];
$manifest[ 'package_uri' ]  = $composer_info[ 'support' ][ 'url' ] ?? '';
$manifest[ 'license' ]      = $composer_info[ 'license' ] ?? '';

$manifest[ 'support' ][ 'email' ]  = $composer_info[ 'support' ][ 'email' ] ?? '';
$manifest[ 'support' ][ 'issues' ] = $composer_info[ 'support' ][ 'issues' ] ?? '';
$manifest[ 'support' ][ 'docs' ]   = $composer_info[ 'support' ][ 'docs' ] ?? '';

$manifest[ 'author' ][ 'name' ]     = $composer_info[ 'author' ][ 'name' ] ?? '';
$manifest[ 'author' ][ 'homepage' ] = $composer_info[ 'author' ][ 'homepage' ] ?? '';

$manifest[ 'require' ] = [
	'wordpress' => $composer_info[ 'extra' ][ 'wordpress-version' ] ?? '',
	'php'       => $composer_info[ 'require' ][ 'php' ] ?? ''
];

$manifest[ 'core' ] = [
	'cli' => [
		'description' => _x( 'Creating custom wp cli commands', 'manifest', DHT_PREFIX )
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
		'description' => _x( 'An extension to create different option fields that can be used on dashboard pages, terms and post types', 'manifest', DHT_PREFIX )
	],
];