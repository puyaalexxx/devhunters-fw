<?php
declare( strict_types = 1 );

namespace DHT\Helpers\Classes;

if( !defined( 'DHT_MAIN' ) ) {
	die( 'Forbidden' );
}

/**
 * FW translation helpers
 */
final class Translations {
	
	/**
	 * Load Text Domain for translation
	 *
	 * @return void
	 * @since     1.0.0
	 */
	public static function loadTextdomain() : void {
		
		//change this after creating a composer package
		if( defined( 'DHT_DIR' ) ) {
			// Plugin context
			//load_plugin_textdomain( DHT_PREFIX, false, DHT_DIR . '/lang' );
		}
		else {
			// Composer package context
			//load_textdomain( DHT_PREFIX, __DIR__ . '/lang/your-text-domain.mo' );
		}
		
		load_plugin_textdomain( 'dht', false, DHT_LANG );
	}
	
	/**
	 * Get translation strings
	 *
	 * @return array
	 * @since     1.0.0
	 */
	public static function getTranslationStrings() : array {
		
		//dummy settings
		return [
			'others' => [
				'setting' => _x( 'Dummy settings', "vb", 'dht' ),
			]
		];
	}
	
	/**
	 * Get VB translation strings
	 *
	 * @return array
	 * @since     1.0.0
	 */
	public static function getVBTranslationStrings() : array {
		
		return [
			'vb' => [
				'icon_drag'           => _x( 'Move Item', "vb", 'dht' ),
				'icon_settings'       => _x( 'Module Settings', "vb", 'dht' ),
				'icon_duplicate'      => _x( 'Duplicate Module', "vb", 'dht' ),
				'icon_delete'         => _x( 'Delete Module', "vb", 'dht' ),
				'icon_other_settings' => _x( 'Other Settings', "vb", 'dht' ),
				'modal_title'         => _x( 'Settings', "vb", 'dht' ),
			]
		];
	}
	
}