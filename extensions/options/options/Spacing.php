<?php
declare( strict_types = 1 );

namespace DHT\Extensions\Options\Options;

use function DHT\fw;

if ( !defined( 'DHT_MAIN' ) ) die( 'Forbidden' );

final class Spacing extends BaseOption {
    
    //field type
    protected string $_field = 'spacing';
    
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
        
        // Register the style
        wp_register_style( DHT_PREFIX . '-spacing-option', DHT_ASSETS_URI . 'styles/css/extensions/options/spacing-style.css', array(), fw()->manifest->get( 'version' ) );
        // Enqueue the style
        wp_enqueue_style( DHT_PREFIX . '-spacing-option' );
    }
    
    /**
     *  In this method you receive $option_value (from form submit or whatever)
     *  and must return correct and safe value that will be stored in database.
     *
     *  $option_value can be null.
     *  In this case you should return default value from $option['value']
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
        if ( is_array( $option_value ) ) {
            
            $option_vals = [];
            foreach ( $option_value as $key => $value ) {
                
                if ( $key == 'size' ) {
                    
                    $option_vals[ $key ] = $value;
                    
                    continue;
                }
                
                $option_vals[ $key ] = absint( sanitize_text_field( $value ) );
            }
            
            $option_value = $option_vals;
            
        }
        
        return $option_value;
    }
    
}
