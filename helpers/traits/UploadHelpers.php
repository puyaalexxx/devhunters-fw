<?php
declare( strict_types = 1 );

namespace DHT\Helpers\Traits;

if ( !defined( 'DHT_MAIN' ) ) die( 'Forbidden' );

trait UploadHelpers {
    
    /**
     * save upload fields manipulations to save the values after that
     *
     * @param array  $field
     * @param array  $field_value
     * @param string $link_key
     * @param string $id_key
     *
     * @return array
     * @since     1.0.0
     */
    private function _saveUploadFieldHelper( array $field, array $field_value, string $link_key, string $id_key ) : array {
        
        if ( empty( $field_value[ $link_key ] ) && empty( $field_value[ $id_key ] ) ) {
            
            return $field[ 'value' ];
        }
        
        //escape item link
        if ( !empty( $field_value[ $link_key ] ) ) {
            
            $field_value[ $link_key ] = esc_url( $field_value[ $link_key ] );
        }
        
        //image id must be always an int
        if ( !empty( $field_value[ $id_key ] ) ) {
            
            $field_value[ $id_key ] = absint( sanitize_text_field( $field_value[ $id_key ] ) );
        }
        
        //get attachment id from the item link
        if ( !empty( $field_value[ $link_key ] ) && empty( $field_value[ $id_key ] ) ) {
            
            $attachment_id = attachment_url_to_postid( $field_value[ $link_key ] );
            
            if ( $attachment_id ) {
                
                $field_value[ $id_key ] = $attachment_id;
            }
        }
        
        //see if the attachment url matches the one from the $_POST array
        if ( !empty( $field_value[ $link_key ] ) && !empty( $field_value[ $id_key ] ) ) {
            
            $attachment_url = wp_get_attachment_url( $field_value[ $id_key ] );
            
            if ( $attachment_url != trim( $field_value[ $link_key ] ) ) {
                
                $field_value[ $id_key ] = '';
            }
        }
        
        return $field_value;
    }
    
}