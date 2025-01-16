<?php
declare( strict_types = 1 );

use DHT\Helpers\Classes\FWHelpers;
use function DHT\Helpers\dht_get_composer_info;

if( !defined( 'DHT_MAIN' ) ) {
	die( 'Forbidden' );
}

//framework manifest
//name, version, requirements and other useful things
$composer_info = dht_get_composer_info();

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
	'cli'     => [
		'description' => _x( 'A core feature to create custom wp cli commands', 'manifest', 'dht' )
	],
	'options' => [
		'description' => _x( 'A core feature to create different option fields that can be used on dashboard pages, terms and post types', 'manifest', 'dht' )
	],
];

$manifest[ 'extensions' ] = [
	'cpt'             => [
		'description' => _x( 'Creating custom post types dynamically from option configurations', 'manifest', 'dht' )
	],
	'dashboard-pages' => [
		'description' => _x( 'Creating dashboard menu pages and subpages dynamically from option configurations', 'manifest', 'dht' )
	],
	'sidebars'        => [
		'description' => _x( 'Creating sidebars dynamically from option configurations also adding a dynamic form to wigets area to create sidebars on the fly', 'manifest', 'dht' )
	],
	'vb'              => [
		'description' => _x( 'An extension to create a small visual builder with a popup on specific elements on the page', 'manifest', 'dht' )
	],
];