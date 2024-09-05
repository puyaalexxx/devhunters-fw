<?php
declare( strict_types = 1 );

namespace DHT\Helpers\Traits\Options;

if ( !defined( 'DHT_MAIN' ) ) die( 'Forbidden' );

use function DHT\Helpers\dht_get_db_settings_option;
use function DHT\Helpers\dht_set_db_settings_option;
use function DHT\Helpers\is_save_options_separately;

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
     * @param string $location    Where to save the data - dashboard/post or term
     * @param int    $id          post id or term id
     *
     * @return array The processed values to be saved.
     * @since     1.0.0
     */
    private function _handleContainerOptions( array $options, array $post_values, string $location = 'dashboard', int $id = 0 ) : array {
        
        $values = [];
        // Check if the option type is set and has a corresponding container class
        if ( isset( $options[ 'type' ], $this->_optionContainerClasses[ $options[ 'type' ] ] ) ) {
            $values[ $options[ 'id' ] ] = $this->_optionContainerClasses[ $options[ 'type' ] ]->saveValue( $options, $post_values );
            
            // Save the values to the database
            $this->_saveToDB( $values, $options, $location, $id );
        }
        
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
                
                if ( isset( $this->_optionGroupsClasses[ $option[ 'type' ] ] ) ) {
                    $value = $this->_optionGroupsClasses[ $option[ 'type' ] ]->saveValue( $option, $_POST[ $option[ 'id' ] ] );
                } elseif ( isset( $this->_optionTogglesClasses[ $option[ 'type' ] ] ) ) {
                    $value = $this->_optionTogglesClasses[ $option[ 'type' ] ]->saveValue( $option, $_POST[ $option[ 'id' ] ] );
                } else {
                    $value = $this->_optionFieldsClasses[ $option[ 'type' ] ]->saveValue( $option, $_POST[ $option[ 'id' ] ] );
                }
                
                //save the past values to DB
                $this->_saveToDB( $value, $option, $location, $id );
            }
        }
    }
    
    /**
     * save the past values to DB (save them separately or grouped under one id)
     *
     * Save dashboard pages, posts and terms data
     *
     * @param array  $values   The options sanitized values.
     * @param array  $options  The options array
     * @param string $location Where to save the data - dashboard/post or term
     * @param int    $id       post id or term id
     *
     * @return void
     * @since     1.0.0
     */
    private function _saveToDB( mixed $values, array $options, string $location = 'dashboard', int $id = 0 ) : void {
        
        $saveData = function ( mixed $values, string $option_id, string $location, int $id ) : void {
            
            //save post data
            if ( $location == 'post' ) {
                update_post_meta( $id, $option_id, $values );
            } //save term data
            elseif ( $location == 'term' ) {
                //update_term_meta((int)$id, 'custom_field_key', $values);
            } //save dashboard page options data
            else {
                dht_set_db_settings_option( $option_id, $values );
            }
        };
        
        if ( is_save_options_separately( $options ) ) {
            foreach ( $values[ $options[ 'id' ] ] as $option_id => $option_values ) {
                $saveData( $option_values, $option_id, $location, $id );
            }
        } else {
            $saveData( $values, $options[ 'id' ], $location, $id );
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
        
        $is_simple_container = $this->_isSimpleContainer( $options );
        $saved_values = [];
        
        if ( is_save_options_separately( $options ) ) {
            foreach ( $options[ 'options' ] as $option ) {
                if ( $location == 'post' ) {
                    if ( isset( $option[ 'options' ] ) && !$is_simple_container ) {
                        foreach ( $option[ 'options' ] as $opt ) {
                            //get option value
                            $option_value = get_post_meta( $id, $opt[ 'id' ], true );
                            
                            if ( $option_value !== '' ) $saved_values[ $options[ 'id' ] ][ $opt[ 'id' ] ] = $option_value;
                        }
                    } else {
                        //get option value
                        $option_value = get_post_meta( $id, $option[ 'id' ], true );
                        
                        if ( $option_value !== '' ) $saved_values[ $options[ 'id' ] ][ $option[ 'id' ] ] = $option_value;
                    }
                    
                    // Check for other potential nested arrays, such as 'pages' - sidemenu container
                    if ( isset( $option[ 'pages' ] ) && is_array( $option[ 'pages' ] ) ) {
                        foreach ( $option[ 'pages' ] as $page ) {
                            if ( isset( $page[ 'options' ] ) ) {
                                foreach ( $page[ 'options' ] as $opt ) {
                                    //get option value
                                    $option_value = get_post_meta( $id, $opt[ 'id' ], true );
                                    
                                    if ( $option_value !== '' ) $saved_values[ $options[ 'id' ] ][ $opt[ 'id' ] ] = $option_value;
                                }
                            }
                        }
                    }
                } else {
                    if ( isset( $option[ 'options' ] ) && !$is_simple_container ) {
                        foreach ( $option[ 'options' ] as $opt ) {
                            //get option value
                            if ( isset( $option[ 'subtype' ] ) && $option[ 'subtype' ] == 'tabs' ) {
                                $saved_values[ $options[ 'id' ] ][ $option[ 'id' ] ][ $opt[ 'id' ] ] = dht_get_db_settings_option( $opt[ 'id' ] );
                            } else {
                                $saved_values[ $options[ 'id' ] ][ $opt[ 'id' ] ] = dht_get_db_settings_option( $opt[ 'id' ] );
                            }
                        }
                    } else {
                        //get option value
                        $option_value = dht_get_db_settings_option( $option[ 'id' ] );
                        
                        if ( empty( $option_value ) ) continue; //skip non existent values
                        
                        $saved_values[ $options[ 'id' ] ][ $option[ 'id' ] ] = $option_value;
                    }
                    
                    // Check for other potential nested arrays, such as 'pages' - sidemenu container
                    if ( isset( $option[ 'pages' ] ) && is_array( $option[ 'pages' ] ) ) {
                        foreach ( $option[ 'pages' ] as $page ) {
                            if ( isset( $page[ 'options' ] ) ) {
                                foreach ( $page[ 'options' ] as $opt ) {
                                    //get option value
                                    $saved_values[ $options[ 'id' ] ][ $option[ 'id' ] ][ $page[ 'id' ] ][ $opt[ 'id' ] ] = dht_get_db_settings_option( $opt[ 'id' ] );
                                }
                            }
                        }
                    }
                }
            }
        } else {
            
            if ( $location == 'post' ) {
                //get option value
                $option_values = get_post_meta( $id, $options[ 'options_id' ], true );
                
                //retrieve grouped container values
                $saved_values[ $options[ 'id' ] ] = $option_values[ $options[ 'options_id' ] ] ?? [];
            } else {
                //get saved options if settings id present
                if ( isset( $options[ 'id' ] ) ) {
                    $saved_values = dht_get_db_settings_option( $options[ 'id' ] );
                } // if simple options without container
                else {
                    foreach ( $options as $option ) {
                        //get option value
                        $option_value = dht_get_db_settings_option( $option[ 'id' ] );
                        
                        if ( empty( $option_value ) ) continue; //skip non existent values
                        
                        $saved_values[ $option[ 'id' ] ] = $option_value;
                    }
                }
            }
        }
        
        // dht_print_r( $saved_values );
        
        return $saved_values;
    }
    
}