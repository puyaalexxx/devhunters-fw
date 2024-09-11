<?php
declare( strict_types=1 );

namespace DHT\Helpers\Traits\Options;

if( !defined( 'DHT_MAIN' ) ) die( 'Forbidden' );

use function DHT\Helpers\dht_get_db_settings_option;
use function DHT\Helpers\dht_print_r;
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
        
        return isset( $_POST[ $this->_nonce[ 'name' ] ] ) && wp_verify_nonce( sanitize_key( wp_unslash( $_POST[ $this->_nonce[ 'name' ] ] ) ), $this->_nonce[ 'action' ] );
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
        if( isset( $options[ 'type' ], $this->_optionContainerClasses[ $options[ 'type' ] ] ) ) {
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
        
        foreach( $options as $option ) {
            
            if( array_key_exists( $option[ 'id' ], $_POST ) ) {
                
                if( isset( $this->_optionGroupsClasses[ $option[ 'type' ] ] ) ) {
                    $value = $this->_optionGroupsClasses[ $option[ 'type' ] ]->saveValue( $option, $_POST[ $option[ 'id' ] ] );
                }
                elseif( isset( $this->_optionTogglesClasses[ $option[ 'type' ] ] ) ) {
                    $value = $this->_optionTogglesClasses[ $option[ 'type' ] ]->saveValue( $option, $_POST[ $option[ 'id' ] ] );
                }
                else {
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
            if( $location == 'post' ) {
                update_post_meta( $id, $option_id, $values );
            } //save term data
            elseif( $location == 'term' ) {
                update_term_meta( $id, $option_id, $values );
            } //save dashboard page options data
            else {
                dht_set_db_settings_option( $option_id, $values );
            }
        };
        
        if( is_save_options_separately( $options ) ) {
            foreach( $values[ $options[ 'id' ] ] as $option_id => $option_values ) {
                $saveData( $option_values, $option_id, $location, $id );
            }
        }
        else {
            $saveData( $values, $options[ 'id' ], $location, $id );
        }
    }
    
    /**
     * get options saved values in one array
     *
     * @param array  $options  Options array
     * @param string $location Where to save the data - dashboard/post or term
     * @param int    $id       post id or term id
     *
     * @return mixed
     * @since     1.0.0
     */
    private function _getOptionsSavedValues( array $options, string $location = 'dashboard', int $id = 0 ) : array {
        
        $is_simple_container = $this->_isSimpleContainer( $options );
        $values = $saved_values = [];
        
        if( is_save_options_separately( $options ) ) {
            foreach( $options[ 'options' ] as $option ) {
                if( $location == 'post' || $location == 'term' ) {
                    $values = array_merge( $values, $this->_getOptionsSavedValuesSeparately( $option, $is_simple_container, $location, $id ) );
                }
                else {
                    $values = array_merge( $values, $this->_getDashPagesOptionsSavedValuesSeparately( $option, $is_simple_container ) );
                }
            }
            
            $saved_values[ $options[ 'id' ] ] = $values;
        }
        else {
            $saved_values = $this->_getOptionsSavedValuesGrouped( $options, $location, $id );
        }
        
        return $saved_values;
    }
    
    /**
     * get post options saved values that are saved separately
     *
     * @param array  $option              Options array
     * @param bool   $is_simple_container If it is a simple container type
     * @param string $location            from where to get the data - post or term
     * @param int    $id                  post id or term id
     *
     * @return mixed
     * @since     1.0.0
     */
    private function _getOptionsSavedValuesSeparately( array $option, bool $is_simple_container, string $location, int $id = 0 ) : array {
        
        $saved_values = [];
        
        //if not a simple container
        if( isset( $option[ 'options' ] ) && !$is_simple_container ) {
            foreach( $option[ 'options' ] as $opt ) {
                $saved_values = array_merge( $saved_values, $this->_getSavedValue( $opt[ 'id' ], $location, $id ) );
            }
        } // Check for other potential nested arrays, such as 'pages' - sidemenu container
        elseif( isset( $option[ 'pages' ] ) && is_array( $option[ 'pages' ] ) ) {
            foreach( $option[ 'pages' ] as $page ) {
                if( isset( $page[ 'options' ] ) ) {
                    foreach( $page[ 'options' ] as $opt ) {
                        $saved_values = array_merge( $saved_values, $this->_getSavedValue( $opt[ 'id' ], $location, $id ) );
                    }
                }
            }
        }
        else {
            $saved_values = array_merge( $saved_values, $this->_getSavedValue( $option[ 'id' ], $location, $id ) );
        }
        
        return $saved_values;
    }
    
    /**
     * get dashboard pages options saved values that are saved separately
     *
     * @param array $option              Options array
     * @param bool  $is_simple_container If it is a simple container type
     *
     * @return mixed
     * @since     1.0.0
     */
    private function _getDashPagesOptionsSavedValuesSeparately( array $option, bool $is_simple_container ) : array {
        
        $saved_values = [];
        
        //if not a simple container
        if( isset( $option[ 'options' ] ) && !$is_simple_container ) {
            foreach( $option[ 'options' ] as $opt ) {
                //get option value
                if( isset( $option[ 'subtype' ] ) && $option[ 'subtype' ] == 'tabs' ) {
                    $saved_values[ $option[ 'id' ] ][ $opt[ 'id' ] ] = dht_get_db_settings_option( $opt[ 'id' ] );
                }
                else {
                    $saved_values[ $opt[ 'id' ] ] = dht_get_db_settings_option( $opt[ 'id' ] );
                }
            }
        } // Check for other potential nested arrays, such as 'pages' - sidemenu container
        elseif( isset( $option[ 'pages' ] ) && is_array( $option[ 'pages' ] ) ) {
            foreach( $option[ 'pages' ] as $page ) {
                if( isset( $page[ 'options' ] ) ) {
                    foreach( $page[ 'options' ] as $opt ) {
                        //get option value
                        $saved_values[ $opt[ 'id' ] ] = dht_get_db_settings_option( $opt[ 'id' ] );
                    }
                }
            }
        }
        else {
            //get option value
            $option_value = dht_get_db_settings_option( $option[ 'id' ] );
            
            if( !empty( $option_value ) ) $saved_values[ $option[ 'id' ] ] = $option_value;
        }
        
        return $saved_values;
    }
    
    /**
     * get dashboard pages/post/terms options saved values that are grouped under one id
     *
     * @param array  $options  Options array
     * @param string $location Where to save the data - dashboard/post or term
     * @param int    $id       post id or term id
     *
     * @return mixed
     * @since     1.0.0
     */
    private function _getOptionsSavedValuesGrouped( array $options, string $location = 'dashboard', int $id = 0 ) : array {
        
        $saved_values = [];
        
        if( $location == 'post' ) {
            //get option value
            $option_values = get_post_meta( $id, $options[ 'options_id' ], true );
            
            //retrieve grouped container values
            $saved_values[ $options[ 'id' ] ] = $option_values[ $options[ 'options_id' ] ] ?? [];
        }
        elseif( $location == 'term' ) {
            //get option value
            $option_values = get_term_meta( $id, $options[ 'id' ], true );
            
            //retrieve grouped container values
            $saved_values[ $options[ 'id' ] ] = $option_values[ $options[ 'id' ] ] ?? [];
        }
        else {
            //get saved options if settings id present
            if( isset( $options[ 'id' ] ) ) {
                $saved_values = dht_get_db_settings_option( $options[ 'id' ] );
            } // if simple options without container
            else {
                foreach( $options as $option ) {
                    //get option value
                    $option_value = dht_get_db_settings_option( $option[ 'id' ] );
                    
                    if( empty( $option_value ) ) continue; //skip non existent values
                    
                    $saved_values[ $option[ 'id' ] ] = $option_value;
                }
            }
        }
        
        return $saved_values;
    }
    
    /**
     * Get term or post individual saved value
     *
     * @param string $option_id
     * @param string $location
     * @param int    $id
     *
     * @return array
     */
    private function _getSavedValue( string $option_id, string $location, int $id ) : array {
        
        $values = [];
        
        //get option value
        if( $location == 'term' ) {
            $option_value = get_term_meta( $id, $option_id, true );
        }
        else {
            $option_value = get_post_meta( $id, $option_id, true );
        }
        
        if( $option_value !== '' ) $values[ $option_id ] = $option_value;
        
        return $values;
    }
    
}