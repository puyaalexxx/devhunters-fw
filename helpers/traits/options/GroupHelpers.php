<?php

namespace DHT\Helpers\Traits\Options;

trait GroupHelpers {
    
    /**
     * group option save helper to deal with toggles and field options
     *
     * @param array $option               - option array
     * @param array $group_post_values    - group post values
     * @param array $option_post_value    - group option post values (toggle or field)
     * @param array $optionTogglesClasses - registered toggles classes
     * @param array $optionFieldsClasses  - registered field classes
     *
     * @return mixed  - sanitized group post values
     * @since     1.0.0
     */
    private function _saveGroupHelper( array $option, array $group_post_values, mixed $option_post_value, array $optionTogglesClasses, array $optionFieldsClasses ) : array {
        
        //if it is a toogle option type
        if ( array_key_exists( $option[ 'type' ], $optionTogglesClasses ) ) {
            
            $group_post_values[ $option[ 'id' ] ] = $optionTogglesClasses[ $option[ 'type' ] ]->saveValue( $option, $option_post_value );
        } //if it is a field option type
        else {
            $group_post_values[ $option[ 'id' ] ] = $optionFieldsClasses[ $option[ 'type' ] ]->saveValue( $option, $option_post_value );
        }
        
        return $group_post_values;
    }
    
}