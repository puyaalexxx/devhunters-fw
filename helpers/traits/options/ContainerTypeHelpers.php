<?php
declare( strict_types = 1 );

namespace DHT\Helpers\Traits\Options;

if( !defined( 'DHT_MAIN' ) ) die( 'Forbidden' );

trait ContainerTypeHelpers {
    
    /**
     * sanitize each option value passed from the $_POST array
     *
     * @param array $options
     * @param array $options_post_values - container options $_POST values passed on save
     *
     * @return mixed
     * @since     1.0.0
     */
    private function _sanitizeValues( array $options, array $options_post_values ) : array {
        
        $values = [];
        foreach( $options as $option ) {
            
            $option_post_value = $options_post_values[ $option[ 'id' ] ] ?? [];
            
            //if it is a group type
            if( isset( $this->_optionGroupsClasses[ $option[ 'type' ] ] ) ) {
                
                $values[ $option[ 'id' ] ] = $this->_optionGroupsClasses[ $option[ 'type' ] ]->saveValue( $option, $option_post_value );
                
            } //if it is a toggle type
            elseif( isset( $this->_optionTogglesClasses[ $option[ 'type' ] ] ) ) {
                
                $values[ $option[ 'id' ] ] = $this->_optionTogglesClasses[ $option[ 'type' ] ]->saveValue( $option, $option_post_value );
                
            } //if it is a simple option type
            else {
                
                $values[ $option[ 'id' ] ] = $this->_optionFieldsClasses[ $option[ 'type' ] ]->saveValue( $option, $option_post_value );
            }
        }
        
        return $values;
    }
    
}