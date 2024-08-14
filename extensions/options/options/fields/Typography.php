<?php
declare( strict_types = 1 );

namespace DHT\Extensions\Options\Options\fields;

use DHT\Extensions\Options\Options\BaseOption;
use function DHT\fw;

if ( !defined( 'DHT_MAIN' ) ) die( 'Forbidden' );

final class Typography extends BaseOption {
    
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
     * @param array $option
     *
     * @return void
     * @since     1.0.0
     */
    public function enqueueOptionScripts( array $option ) : void {
        
        wp_register_style( DHT_PREFIX . '-select2-option', DHT_ASSETS_URI . 'styles/libraries/select2.min.css', array(), fw()->manifest->get( 'version' ) );
        wp_enqueue_style( DHT_PREFIX . '-select2-option' );
        
        wp_register_style( DHT_PREFIX . '-typography-option', DHT_ASSETS_URI . 'styles/css/extensions/options/options/typography-style.css', array(), fw()->manifest->get( 'version' ) );
        wp_enqueue_style( DHT_PREFIX . '-typography-option' );
        
        wp_enqueue_script( DHT_PREFIX . '-select2-option', DHT_ASSETS_URI . 'scripts/libraries/select2.full.min.js', array( 'jquery' ), fw()->manifest->get( 'version' ), true );
        
        wp_enqueue_script( DHT_PREFIX . '-typography-option', DHT_ASSETS_URI . 'scripts/js/extensions/options/options/typography-script.js', array( 'jquery', DHT_PREFIX . '-select2-option' ), fw()->manifest->get( 'version' ), true );
    }
    
    /**
     *  In this method, you receive $option_value (from form submit or whatever)
     *  and must return the correct and safe value that will be stored in a database.
     *
     *  $option_value can be null.
     *  In this case, you should return default value from $option['value']
     *
     * @param array $option       - option field
     * @param mixed $option_value - saved option value
     *
     * @return mixed - changed option value
     * @since     1.0.0
     */
    public function saveValue( array $option, mixed $option_value ) : mixed {
        
        if ( empty( $option_value ) ) {
            return $option[ 'value' ];
        }
        
        //for the range field
        if ( !empty( $option_value[ 'font-family' ] ) ) {
            
            $option_value[ 'font-family' ][ 'font' ] = stripslashes( $option_value[ 'font-family' ][ 'font' ] );
            
        }
        
        return $option_value;
    }
    
    /**
     * return option template
     *
     * @param array  $option
     * @param mixed  $saved_value
     * @param string $prefix_id
     * @param array  $additional_args
     *
     * @return string
     * @since     1.0.0
     */
    public function render( array $option, mixed $saved_value, string $prefix_id, array $additional_args = [] ) : string {
        
        $additional_args = [
            $this->_getStandardFonts(),
            $this->_getStandardFontWeights(), $this->_getStandardFontStyles(),
            $this->_getTextDecorationValues(), $this->_getTextTransformValues()
        ];
        
        return parent::render( $option, $saved_value, $prefix_id, $additional_args );
    }
    
    /**
     * get standard fonts
     *
     * @return array
     * @since     1.0.0
     */
    private function _getStandardFonts() : array {
        
        return [
            "Arial, Helvetica, sans-serif" => "Arial, Helvetica,sans-serif",
            "'Arial Black', Gadget, sans-serif" => "Arial Black, Gadget, sans-serif",
            "'Bookman Old Style', serif" => "Bookman Old Style, serif",
            "'Comic Sans MS', cursive" => "Comic Sans MS, cursive",
            "Courier, monospace" => "Courier, monospace",
            "Garamond, serif" => "Garamond, serif",
            "Georgia, serif" => "Georgia, serif",
            "Impact, Charcoal, sans-serif" => "Impact, Charcoal, sans-serif",
            "'Lucida Console', Monaco, monospace" => "Lucida Console, Monaco, monospace",
            "'Lucida Sans Unicode', 'Lucida Grande', sans-serif" => "Lucida Sans Unicode, 'Lucida Grande', sans-serif",
            "'MS Sans Serif', Geneva, sans-serif" => "MS Sans Serif, Geneva, sans-serif",
            "'MS Serif', 'New York', sans-serif" => "MS Serif, 'New York', sans-serif",
            "'Palatino Linotype', 'Book Antiqua', Palatino, serif" => "Palatino Linotype, 'Book Antiqua', Palatino, serif",
            "Tahoma,Geneva, sans-serif" => "Tahoma,Geneva, sans-serif",
            "'Times New Roman', Times,serif" => "Times New Roman, Times,serif",
            "'Trebuchet MS', Helvetica, sans-serif" => "Trebuchet MS, Helvetica, sans-serif",
            "Verdana, Geneva, sans-serif" => "Verdana, Geneva, sans-serif"
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
            'underline' => 'Underline',
            'overline' => 'Overline',
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
            'uppercase' => 'Uppercase',
            'lowercase' => 'Lowercase',
            'small-caps' => 'Small Caps',
        ];
    }
    
}