<?php
declare( strict_types = 1 );

namespace DHT\Helpers;

if( !defined( 'DHT_MAIN' ) ) {
	die( 'Forbidden' );
}


if( !function_exists( 'dht_enable_vb_editor_area' ) ) {
	/**
	 * Enable the Visual Builder editor area by adding this
	 * method to an HTML tag. The attribute will do the rest
	 *
	 * @param string $modal_name   Modal Name to retrieve its options
	 * @param array  $btn_settings Button Group icons enable/disable
	 *
	 * @return void
	 * @since     1.0.0
	 */
	function dht_enable_vb_editor_area( string $modal_name, array $btn_settings = [] ) : void {
		
		$default_btn_settings = [
			"drag"           => false,
			"settings"       => false,
			"duplicate"      => false,
			"delete"         => false,
			"other-settings" => false
		];
		
		$btn_settings = array_merge( $default_btn_settings, $btn_settings );
		
		// Start building the data attributes
		$data_attributes = 'data-dht-vb-editor="true" data-dht-vb-modal-name="' . esc_attr( $modal_name ) . '"';
		
		// Add data attributes for each setting
		foreach ( $btn_settings as $key => $value ) {
			
			if( !$value ) continue;
			
			$data_attributes .= ' data-dht-vb-button-' . esc_attr( $key ) . '="true"';
		}
		
		// Output the data attributes
		echo $data_attributes;
	}
}
