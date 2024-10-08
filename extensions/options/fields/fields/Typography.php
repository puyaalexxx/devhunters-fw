<?php
declare( strict_types = 1 );

namespace DHT\Extensions\Options\Fields\Fields;

use DHT\Extensions\Options\Fields\BaseField;
use DHT\Helpers\Classes\Environment;
use function DHT\dht;
use function DHT\Helpers\dht_print_r;

if ( ! defined( 'DHT_MAIN' ) ) {
	die( 'Forbidden' );
}

final class Typography extends BaseField {
	
	//field type
	protected string $_field = 'typography';
	
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
		
		//library css
		wp_register_style( DHT_PREFIX_CSS . '-select2-field', DHT_ASSETS_URI . 'styles/libraries/select2.min.css', array(), dht()->manifest->get( 'version' ) );
		wp_enqueue_style( DHT_PREFIX_CSS . '-select2-field' );
		
		//library js
		wp_enqueue_script( DHT_PREFIX_JS . '-select2-field', DHT_ASSETS_URI . 'scripts/libraries/select2.full.min.js', array( 'jquery' ), dht()->manifest->get( 'version' ), true );
		
		if ( Environment::isDevelopment() ) {
			wp_register_style( DHT_PREFIX_CSS . '-typography-field', DHT_ASSETS_URI . 'dist/css/typography.css', array(), dht()->manifest->get( 'version' ) );
			wp_enqueue_style( DHT_PREFIX_CSS . '-typography-field' );
			
			wp_enqueue_script( DHT_PREFIX_JS . '-typography-field', DHT_ASSETS_URI . 'dist/js/typography.js', array(
				'jquery',
				DHT_PREFIX_JS . '-select2-field'
			), dht()->manifest->get( 'version' ), true );
		}
	}
	
	/**
	 * return field template
	 *
	 * @param array  $field
	 * @param mixed  $saved_value
	 * @param string $options_id
	 * @param array  $additional_args
	 *
	 * @return string
	 * @since     1.0.0
	 */
	public function render( array $field, mixed $saved_value, string $options_id, array $additional_args = [] ) : string {
		
		$additional_args = [
			$this->_getStandardFonts(),
			$this->_getStandardFontWeights(),
			$this->_getStandardFontStyles(),
			$this->_getTextDecorationValues(),
			$this->_getTextTransformValues()
		];
		
		return parent::render( $field, $saved_value, $options_id, $additional_args );
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
		
		//for the range field
		if ( ! empty( $field_post_value[ 'font-family' ] ) ) {
			
			$field_post_value[ 'font-family' ][ 'font' ] = stripslashes( $field_post_value[ 'font-family' ][ 'font' ] );
			
		}
		
		return $field_post_value;
	}
	
	/**
	 * get standard fonts
	 *
	 * @return array
	 * @since     1.0.0
	 */
	private function _getStandardFonts() : array {
		
		return [
			"Arial, Helvetica, sans-serif"                         => "Arial, Helvetica,sans-serif",
			"'Arial Black', Gadget, sans-serif"                    => "Arial Black, Gadget, sans-serif",
			"'Bookman Old Style', serif"                           => "Bookman Old Style, serif",
			"'Comic Sans MS', cursive"                             => "Comic Sans MS, cursive",
			"Courier, monospace"                                   => "Courier, monospace",
			"Garamond, serif"                                      => "Garamond, serif",
			"Georgia, serif"                                       => "Georgia, serif",
			"Impact, Charcoal, sans-serif"                         => "Impact, Charcoal, sans-serif",
			"'Lucida Console', Monaco, monospace"                  => "Lucida Console, Monaco, monospace",
			"'Lucida Sans Unicode', 'Lucida Grande', sans-serif"   => "Lucida Sans Unicode, 'Lucida Grande', sans-serif",
			"'MS Sans Serif', Geneva, sans-serif"                  => "MS Sans Serif, Geneva, sans-serif",
			"'MS Serif', 'New York', sans-serif"                   => "MS Serif, 'New York', sans-serif",
			"'Palatino Linotype', 'Book Antiqua', Palatino, serif" => "Palatino Linotype, 'Book Antiqua', Palatino, serif",
			"Tahoma,Geneva, sans-serif"                            => "Tahoma,Geneva, sans-serif",
			"'Times New Roman', Times,serif"                       => "Times New Roman, Times,serif",
			"'Trebuchet MS', Helvetica, sans-serif"                => "Trebuchet MS, Helvetica, sans-serif",
			"Verdana, Geneva, sans-serif"                          => "Verdana, Geneva, sans-serif"
		];
	}
	
	/**
	 * get standard font weights
	 *
	 * @return array
	 * @since     1.0.0
	 */
	private function _getStandardFontWeights() : array {
		
		return [
			'300' => 'Light',
			'400' => 'Regular',
			'600' => 'Semi Bold',
			'700' => 'Bold',
			'800' => 'Ultra Bold'
		];
	}
	
	/**
	 * get standard font styles
	 *
	 * @return array
	 * @since     1.0.0
	 */
	private function _getStandardFontStyles() : array {
		
		return [
			'normal' => 'Normal',
			'italic' => 'Italic',
		];
	}
	
	/**
	 * get text decoration values
	 *
	 * @return array
	 * @since     1.0.0
	 */
	private function _getTextDecorationValues() : array {
		
		return [
			'underline'    => 'Underline',
			'overline'     => 'Overline',
			'line-through' => 'Line Through'
		];
	}
	
	/**
	 * get text transform values
	 *
	 * @return array
	 * @since     1.0.0
	 */
	private function _getTextTransformValues() : array {
		
		return [
			'capitalize' => 'Capitalize',
			'uppercase'  => 'Uppercase',
			'lowercase'  => 'Lowercase',
			'small-caps' => 'Small Caps',
		];
	}
	
}