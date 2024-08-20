<?php
declare( strict_types = 1 );

namespace DHT\Helpers\Traits\Options;

use function DHT\Helpers\dht_set_db_settings_option;

trait SaveOptionsHelpers {
    
    /**
     * Validates the nonce in the POST request.
     *
     * This method checks if the nonce in the POST data is valid to ensure that the
     * request is coming from a legitimate source.
     *
     * @return bool True if the nonce is valid, otherwise false.
     * @since     1.0.0
     */
    private function _isValidRequest() : bool {
        
        return isset( $_POST[ $this->_nonce[ 'name' ] ] ) &&
            wp_verify_nonce( sanitize_key( wp_unslash( $_POST[ $this->_nonce[ 'name' ] ] ) ), $this->_nonce[ 'action' ] );
    }
    
    /**
     * Retrieves the options for saving.
     *
     * This method determines whether to use the grouped options or the default options
     * from the class properties.
     *
     * @return array The options to be used for saving.
     * @since     1.0.0
     */
    private function _getOptions() : array {
        
        return $this->_options[ 'options' ] ?? $this->_options;
    }
    
    /**
     * Handles saving of grouped options.
     *
     * Processes options that are grouped under an ID, using the appropriate option
     * container or group classes to save the values. This method saves the processed
     * values to the database.
     *
     * @param array  $options     The options array containing grouped settings.
     * @param array  $post_values The POST data for the settings.
     * @param string $settings_id The ID of the settings being processed.
     *
     * @return array The processed values to be saved.
     * @since     1.0.0
     */
    private function _handleGroupedOptions( array $options, array $post_values, string $settings_id ) : array {
        
        $values = [];
        
        if ( isset( $options[ 'type' ] ) && isset( $this->_optionContainerClasses[ $options[ 'type' ] ] ) ) {
            
            $values[ $options[ 'id' ] ] = $this->_optionContainerClasses[ $options[ 'type' ] ]
                ->saveValue( $options, $post_values, $this->_optionGroupsClasses, $this->_optionClasses );
            
        } else {
            foreach ( $options as $option ) {
                
                if ( array_key_exists( $option[ 'id' ], $post_values ) ) {
                    $values[ $option[ 'id' ] ] = $this->_saveOptionValue( $option, $post_values[ $option[ 'id' ] ] );
                }
            }
        }
        
        dht_set_db_settings_option( $settings_id, $values );
        
        return $values;
    }
    
    /**
     * Handles saving of ungrouped options.
     *
     * Processes individual options that are not grouped, using the appropriate option
     * classes to save the values directly to the database.
     *
     * @param array $options The options array containing individual settings.
     *
     * @return void
     * @since     1.0.0
     */
    private function _handleUngroupedOptions( array $options ) : void {
        
        foreach ( $options as $option ) {
            
            if ( array_key_exists( $option[ 'id' ], $_POST ) ) {
                
                $value = $this->_optionClasses[ $option[ 'type' ] ]->saveValue( $option, $_POST[ $option[ 'id' ] ] );
                
                dht_set_db_settings_option( $option[ 'id' ], $value );
            }
        }
    }
    
    /**
     * Saves a single option value based on its type.
     *
     * Determines the appropriate method to save the option value based on its type,
     * using either the option groups or option classes.
     *
     * @param array $option     The option configuration array.
     * @param mixed $post_value The value from POST data to be saved.
     *
     * @return mixed The processed value to be saved.
     * @since     1.0.0
     */
    private function _saveOptionValue( array $option, mixed $post_value ) : mixed {
        
        if ( isset( $this->_optionGroupsClasses[ $option[ 'type' ] ] ) ) {
            
            return $this->_optionGroupsClasses[ $option[ 'type' ] ]->saveValue( $option, $post_value, $this->_optionClasses );
        }
        
        return $this->_optionClasses[ $option[ 'type' ] ]->saveValue( $option, $post_value );
    }
    
}