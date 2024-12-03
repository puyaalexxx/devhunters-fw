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
	}
	
	/**
	 * Get translation strings
	 *
	 * @return array
	 * @since     1.0.0
	 */
	public static function getTranslationStrings() : array {
		
		return [
			'vb' => [
				'icon_drag'           => _x( 'Move Item', "vb", DHT_PREFIX ),
				'icon_settings'       => _x( 'Module Settings', "vb", DHT_PREFIX ),
				'icon_duplicate'      => _x( 'Duplicate Module', "vb", DHT_PREFIX ),
				'icon_delete'         => _x( 'Delete Module', "vb", DHT_PREFIX ),
				'icon_other_settings' => _x( 'Other Settings', "vb", DHT_PREFIX ),
				'modal_title'         => _x( 'Settings', "vb", DHT_PREFIX ),
			]
		];
	}
	
}