<?php
declare( strict_types = 1 );

namespace DHT\Core\Options\Fields\Fields;

use DHT\Core\Options\Fields\BaseField;
use DHT\DHT;
use DHT\Helpers\Classes\Environment;
use DHT\Helpers\Traits\UploadFieldTrait;

if( !defined( 'DHT_MAIN' ) ) {
	die( 'Forbidden' );
}

final class Upload extends BaseField {
	
	use UploadFieldTrait;
	
	//field type
	protected string $_field = 'upload';
	
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
		
		if( Environment::isDevelopment() ) {
			wp_register_style( DHT_PREFIX_CSS . '-upload-field', DHT_ASSETS_URI . 'dist/css/upload.css', array(), DHT::$version );
			wp_enqueue_style( DHT_PREFIX_CSS . '-upload-field' );
			
			wp_enqueue_script( DHT_PREFIX_JS . '-upload-field', DHT_ASSETS_URI . 'dist/js/upload.js', array(
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
	public function saveValue( array $field, $field_post_value ) {
		
		if( empty( $field_post_value ) ) {
			return $field[ 'value' ];
		}
		
		return $this->_saveUploadFieldHelper( $field, $field_post_value, 'item', 'item_id' );
	}
	
}
