<?php
declare( strict_types = 1 );

namespace DHT\Helpers\Traits\Options;

if ( !defined( 'DHT_MAIN' ) ) die( 'Forbidden' );

use function DHT\Helpers\dht_get_db_settings_option;
use function DHT\Helpers\dht_print_r;

trait OptionsHelpers {
    
    use EnqueueOptionsHelpers;
    
    /**
     * Generates the HTML view for the options.
     *
     * This method retrieves the saved options, determines the type of options being rendered,
     * and generates the appropriate HTML output. It handles both container types and group/toggle/field types.
     *
     *
     * @param array  $options
     * @param string $options_id - options prefix id
     * @param string $location   Where to save the data - dashboard/post or term
     * @param int    $id         post id or term id
     *
     * @return string
     * @since     1.0.0
     */
    private function _getOptionsView( array $options, string $options_id, string $location = 'dashboard', int $id = 0 ) : string {
        
        dht_print_r( $options );
        
        $saved_values = [];
        if ( $location == 'post' ) {
            
            // dht_print_r( $options );
            foreach ( $options as $option ) {
                
                //get option value
                $option_value = get_post_meta( $id, $option[ 'id' ], true );
                
                if ( $option_value === '' ) continue; //skip non existent values
                
                $saved_values[ $option[ 'id' ] ] = !empty( $option_value ) ? $option_value : [];
            }
            
        } else {
            //get saved options if settings id present
            $saved_values = !empty( $options_id ) ? dht_get_db_settings_option( $options_id ) : [];
        }
        
        dht_print_r( $saved_values );
        
        // Start output buffering
        ob_start();
        
        // Check if the options are of container type
        if ( isset( $options[ 'pages' ] ) ) {
            // Render container types
            $this->_renderContainerOptions( $options, $saved_values );
        } else {
            // Render group or option types
            $this->_renderGroupOrOptionTypes( $options, $saved_values, $options_id );
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