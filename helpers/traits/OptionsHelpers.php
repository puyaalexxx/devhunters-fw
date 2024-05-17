<?php
declare( strict_types = 1 );

namespace DHT\Helpers\Traits;

if ( !defined( 'DHT_MAIN' ) ) die( 'Forbidden' );

trait OptionsHelpers {
    
    /**
     *
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
    
    /**
     *
     * pass option array to enqueue scripts method
     * (this is needed to enqueue specific script for specific subtype option)
     *
     * @param array $options
     * @param array $optionClasses - registered option types
     *
     * @return void
     * @since     1.0.0
     */
    private function _getEnqueueOptionArgs( array $options, array $optionClasses ) : void {
        
        $options_prefix_id = array_key_first( $options );
        
        foreach ( $options[ $options_prefix_id ] as $option ) {
            
            //pass the option array to the enqueue method
            if ( isset( $optionClasses[ $option[ 'type' ] ] ) ) {
                
                $optionClasses[ $option[ 'type' ] ]->enqueueOptionScriptsHook( $option );
            }
        }
    }
    
}