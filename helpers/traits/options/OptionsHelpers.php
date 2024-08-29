<?php
declare( strict_types = 1 );

namespace DHT\Helpers\Traits\Options;

use function DHT\Helpers\dht_get_db_settings_option;

if ( !defined( 'DHT_MAIN' ) ) die( 'Forbidden' );

trait OptionsHelpers {
    
    use EnqueueOptionsHelpers;
    
    /**
     * Generates the HTML view for the options.
     *
     * This method retrieves the saved options, determines the type of options being rendered,
     * and generates the appropriate HTML output. It handles both container types and group/toggle/field types.
     *
     *
     * @param array $options
     *
     * @return string
     * @since     1.0.0
     */
    private function _getOptionsView( array $options ) : string {
        
        //check if the options have other options
        $options = $options[ 'options' ] ?? $options;
        
        //get saved options if settings id present
        $saved_values = !empty( $this->_settings_id ) ? dht_get_db_settings_option( $this->_settings_id ) : [];
        
        // Start output buffering
        ob_start();
        
        // Check if the options are of container type
        if ( isset( $this->_options[ 'pages' ] ) ) {
            // Render container types
            $this->_renderContainerOptions( $options, $saved_values );
        } else {
            // Render group or option types
            $this->_renderGroupOrOptionTypes( $options, $saved_values );
        }
        
        // Return the generated HTML view
        return ob_get_clean();
    }
    
    /**
     * generate form nonce fields (name and action)
     *
     * @return array
     * @since     1.0.0
     */
    private function _generateNonce() : array {
        
        $nonce = '';
        
        if ( isset( $_POST ) ) {
            $nonce = array_filter( array_keys( $_POST ), function ( $key ) {
                
                return str_contains( $key, '_dht_fw_nonce' );
            } );
            
            $nonce = !empty( $nonce ) ? str_replace( "_name", "", implode( "", $nonce ) ) : '';
        }
        
        $nonce = empty( $nonce ) ? 'dht_' . md5( uniqid( (string)mt_rand(), true ) ) . '_dht_fw_nonce' : $nonce;
        
        return [ 'name' => $nonce . '_name', 'action' => $nonce . '_action' ];
    }
    
}