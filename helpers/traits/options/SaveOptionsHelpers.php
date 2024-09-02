<?php
declare( strict_types = 1 );

namespace DHT\Helpers\Traits\Options;

if ( !defined( 'DHT_MAIN' ) ) die( 'Forbidden' );

use function DHT\Helpers\dht_get_db_settings_option;
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
     * Handles saving of container options.
     *
     * Processes options that are in a container, using the appropriate option
     * container to save the values. This method saves the processed
     * values to the database.
     *
     * @param array  $options     The options array containing container settings.
     * @param array  $post_values The POST data for the settings.
     * @param string $options_id  General settings id under which to save the options
     * @param string $location    Where to save the data - dashboard/post or term
     * @param int    $id          post id or term id
     *
     * @return array The processed values to be saved.
     * @since     1.0.0
     */
    private function _handleContainerOptions( array $options, array $post_values, string $options_id, string $location = 'dashboard', int $id = 0 ) : array {
        
        $values = [];
        
        if ( isset( $options[ 'type' ] ) && isset( $this->_optionContainerClasses[ $options[ 'type' ] ] ) ) {
            
            $values[ $options[ 'id' ] ] = $this->_optionContainerClasses[ $options[ 'type' ] ]
                ->saveValue( $options, $post_values );
            
        } /*else {
            foreach ( $options as $option ) {
                
                if ( array_key_exists( $option[ 'id' ], $post_values ) ) {
                    $values[ $option[ 'id' ] ] = $this->_saveOptionValue( $option, $post_values[ $option[ 'id' ] ] );
                }
            }
        }*/
        
        //save the past values to DB
        $this->_saveToDB( $values, $options_id, $location, $id );
        
        return $values;
    }
    
    /**
     * Handles saving of ungrouped options.
     *
     * Processes individual options that are not grouped, using the appropriate option
     * classes to save the values directly to the database.
     *
     * @param array  $options  The options array containing individual settings.
     * @param string $location Where to save the data - dashboard/post or term
     * @param int    $id       post id or term id
     *
     * @return void
     * @since     1.0.0
     */
    private function _handleUngroupedOptions( array $options, string $location = 'dashboard', int $id = 0 ) : void {
        
        foreach ( $options as $option ) {
            
            if ( array_key_exists( $option[ 'id' ], $_POST ) ) {
                
                $value = $this->_saveOptionValue( $option, $_POST[ $option[ 'id' ] ] );
                
                //save the past values to DB
                $this->_saveToDB( $value, $option[ 'id' ], $location, $id );
            }
        }
    }
    
    /**
     * save the past values to DB
     *
     * Save dashboard pages, posts and terms data
     *
     * @param array  $values     The options sanitized values.
     * @param string $options_id Dashboard page options id
     * @param string $location   Where to save the data - dashboard/post or term
     * @param int    $id         post id or term id
     *
     * @return void
     * @since     1.0.0
     */
    private function _saveToDB( mixed $values, string $options_id, string $location = 'dashboard', int $id = 0 ) : void {
        
        //save post data
        if ( $location == 'post' ) {
            foreach ( $values as $option_id => $option_value ) {
                update_post_meta( $id, $option_id, $option_value );
            }
            
        } //save term data
        elseif ( $location == 'term' ) {
            
            //update_term_meta((int)$id, 'custom_field_key', $custom_field_value);
            
        } //save dashboard page options data
        else {
            dht_set_db_settings_option( $options_id, $values );
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
            return $this->_optionGroupsClasses[ $option[ 'type' ] ]->saveValue( $option, $post_value );
        } elseif ( isset( $this->_optionTogglesClasses[ $option[ 'type' ] ] ) ) {
            return $this->_optionTogglesClasses[ $option[ 'type' ] ]->saveValue( $option, $post_value );
        } else {
            return $this->_optionFieldsClasses[ $option[ 'type' ] ]->saveValue( $option, $post_value );
        }
    }
    
    /**
     * get options saved values in one array
     *
     * @param array  $options
     * @param string $location Where to save the data - dashboard/post or term
     * @param int    $id       post id or term id
     *
     * @return mixed The processed value to be saved.
     * @since     1.0.0
     */
    private function _getOptionsSavedValues( array $options, string $location = 'dashboard', int $id = 0 ) : array {
        
        $saved_values = [];
        if ( $location == 'post' ) {
            foreach ( $options as $option ) {
                //get option value
                $option_value = get_post_meta( $id, $option[ 'id' ], true );
                
                if ( $option_value === '' ) continue; //skip non existent values
                
                $saved_values[ $option[ 'id' ] ] = !empty( $option_value ) ? $option_value : [];
            }
            
        } else {
            //get saved options if settings id present
            if ( isset( $options[ 'id' ] ) ) {
                $saved_values = dht_get_db_settings_option( $options[ 'id' ] );
            } else {
                foreach ( $options as $option ) {
                    //get option value
                    $option_value = dht_get_db_settings_option( $option[ 'id' ] );
                    
                    if ( empty( $option_value ) ) continue; //skip non existent values
                    
                    $saved_values[ $option[ 'id' ] ] = $option_value;
                }
            }
        }
        
        return $saved_values;
    }
    
}