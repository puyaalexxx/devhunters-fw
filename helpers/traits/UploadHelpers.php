<?php
declare( strict_types = 1 );

namespace DHT\Helpers\Traits;

if ( !defined( 'DHT_MAIN' ) ) die( 'Forbidden' );

trait UploadHelpers {
    
    /**
     * save upload options manipulations to save the values after that
     *
     * @param array  $option
     * @param array  $option_value
     * @param string $link_key
     * @param string $id_key
     *
     * @return array
     * @since     1.0.0
     */
    private function _saveUploadOptionHelper( array $option, array $option_value, string $link_key, string $id_key ) : array {
        
        if ( empty( $option_value[ $link_key ] ) && empty( $option_value[ $id_key ] ) ) {
            
            return $option[ 'value' ];
        }
        
        //escape item link
        if ( !empty( $option_value[ $link_key ] ) ) {
            
            $option_value[ $link_key ] = esc_url( $option_value[ $link_key ] );
        }
        
        //image id must be always an int
        if ( !empty( $option_value[ $id_key ] ) ) {
            
            $option_value[ $id_key ] = absint( sanitize_text_field( $option_value[ $id_key ] ) );
        }
        
        //get attachment id from the item link
        if ( !empty( $option_value[ $link_key ] ) && empty( $option_value[ $id_key ] ) ) {
            
            $attachment_id = attachment_url_to_postid( $option_value[ $link_key ] );
            
            if ( $attachment_id ) {
                
                $option_value[ $id_key ] = $attachment_id;
            }
        }
        
        //see if the attachment url matches the one from the $_POST array
        if ( !empty( $option_value[ $link_key ] ) && !empty( $option_value[ $id_key ] ) ) {
            
            $attachment_url = wp_get_attachment_url( $option_value[ $id_key ] );
            
            if ( $attachment_url != trim( $option_value[ $link_key ] ) ) {
                
                $option_value[ $id_key ] = '';
            }
        }
        
        return $option_value;
    }
    
}