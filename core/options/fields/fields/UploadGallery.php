<?php
declare( strict_types = 1 );

namespace DHT\Core\Options\Fields\Fields;

use DHT\Core\Options\Fields\BaseField;
use DHT\DHT;
use DHT\Helpers\Classes\Environment;
use DHT\Helpers\Traits\UploadHelpers;

if ( ! defined( 'DHT_MAIN' ) ) {
	die( 'Forbidden' );
}

final class UploadGallery extends BaseField {
	
	use UploadHelpers;
	
	//field type
	protected string $_field = 'upload-gallery';
	
	/**
	 * @since     1.0.0
	 */
	public function __construct() {
		
		parent::__construct();
	}
	
	/**
	 * Enqueue input scripts and styles
	 *
	 * @param array $field
	 *
	 * @return void
	 * @since     1.0.0
	 */
	public function enqueueOptionScripts( array $field ) : void {
		
		//Enqueue the media uploader
		wp_enqueue_media();
		
		if ( Environment::isDevelopment() ) {
			wp_register_style( DHT_PREFIX_CSS . '-upload-gallery-field', DHT_ASSETS_URI . 'dist/css/upload-gallery.css', array(), DHT::$version );
			wp_enqueue_style( DHT_PREFIX_CSS . '-upload-gallery-field' );
			
			wp_enqueue_script( DHT_PREFIX_JS . '-upload-gallery-field', DHT_ASSETS_URI . 'dist/js/upload-gallery.js', array(
				'jquery',
				'media-editor'
			), DHT::$version, true );
		}
	}
	
	/**
	 *  In this method you receive $field_post_value (from form submit or whatever)
	 *  and must return correct and safe value that will be stored in database.
	 *
	 *  $field_post_value can be null.
	 *  In this case you should return default value from $field['value']
	 *
	 * @param array $field            - field
	 * @param mixed $field_post_value - field $_POST value passed on save
	 *
	 * @return mixed - changed field value
	 * @since     1.0.0
	 */
	public function saveValue( array $field, mixed $field_post_value ) : mixed {
		
		if ( empty( $field_post_value ) ) {
			return $field[ 'value' ];
		}
		
		//value is coming as a string
		$field_post_value = explode( ',', $field_post_value );
		
		//make sure the values are integers
		foreach ( $field_post_value as $key => $attachment_id ) {
			
			$field_post_value[ $key ] = absint( $attachment_id );
		}
		
		return $field_post_value;
	}
	
}
