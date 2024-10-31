<?php
declare( strict_types = 1 );

namespace DHT\Core\Options\Fields\Fields;

use DHT\Core\Options\Fields\BaseField;
use DHT\DHT;
use DHT\Helpers\Classes\Environment;

if( !defined( 'DHT_MAIN' ) ) {
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
		
		if( $field[ 'color' ] ) {
			wp_enqueue_style( 'wp-color-picker' );
			wp_enqueue_script( 'wp-color-picker' );
		}
		
		//library css
		wp_register_style( DHT_PREFIX_CSS . '-select2-field', DHT_ASSETS_URI . 'styles/libraries/select2.min.css', array(), DHT::$version );
		wp_enqueue_style( DHT_PREFIX_CSS . '-select2-field' );
		
		//library js
		wp_enqueue_script( DHT_PREFIX_JS . '-select2-field', DHT_ASSETS_URI . 'scripts/libraries/select2.full.min.js', array( 'jquery' ), DHT::$version, true );
		
		if( Environment::isDevelopment() ) {
			wp_register_style( DHT_PREFIX_CSS . '-typography-field', DHT_ASSETS_URI . 'dist/css/typography.css', array(), DHT::$version );
			wp_enqueue_style( DHT_PREFIX_CSS . '-typography-field' );
			
			wp_enqueue_script_module( DHT_PREFIX_JS . '-typography-field', DHT_ASSETS_URI . 'dist/js/typography.js', array(
				'jquery',
				DHT_PREFIX_JS . '-select2-field'
			), DHT::$version, true );
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
			$this->_getTextTransformValues(),
			$this->_getTextAlignValues()
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
		
		if( empty( $field_post_value ) ) {
			return $field[ 'value' ];
		}
		
		//for the range field
		if( !empty( $field_post_value[ 'font-family' ] ) ) {
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
			'300' => _x( 'Light', 'options', DHT_PREFIX ),
			'400' => _x( 'Regular', 'options', DHT_PREFIX ),
			'600' => _x( 'Semi Bold', 'options', DHT_PREFIX ),
			'700' => _x( 'Bold', 'options', DHT_PREFIX ),
			'800' => _x( 'Ultra Bold', 'options', DHT_PREFIX )
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
			'normal' => _x( 'Normal', 'options', DHT_PREFIX ),
			'italic' => _x( 'Italic', 'options', DHT_PREFIX )
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
			'underline'    => _x( 'Underline', 'options', DHT_PREFIX ),
			'overline'     => _x( 'Overline', 'options', DHT_PREFIX ),
			'line-through' => _x( 'Line Through', 'options', DHT_PREFIX )
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
			'capitalize' => _x( 'Capitalize', 'options', DHT_PREFIX ),
			'uppercase'  => _x( 'Uppercase', 'options', DHT_PREFIX ),
			'lowercase'  => _x( 'Lowercase', 'options', DHT_PREFIX ),
			'small-caps' => _x( 'Small Caps', 'options', DHT_PREFIX )
		];
	}
	
	/**
	 * get text align values
	 *
	 * @return array
	 * @since     1.0.0
	 */
	private function _getTextAlignValues() : array {
		
		return [
			'inherit' => _x( 'Inherit', 'options', DHT_PREFIX ),
			'center'  => _x( 'Center', 'options', DHT_PREFIX ),
			'left'    => _x( 'Left', 'options', DHT_PREFIX ),
			'right'   => _x( 'Right', 'options', DHT_PREFIX ),
			'justify' => _x( 'Justify', 'options', DHT_PREFIX ),
			'initial' => _x( 'Initial', 'options', DHT_PREFIX )
		];
	}
	
}