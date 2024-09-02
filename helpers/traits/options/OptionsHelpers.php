<?php
declare( strict_types = 1 );

namespace DHT\Helpers\Traits\Options;

if ( !defined( 'DHT_MAIN' ) ) die( 'Forbidden' );

trait OptionsHelpers {
    
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