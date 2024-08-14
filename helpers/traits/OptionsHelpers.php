<?php
declare( strict_types = 1 );

namespace DHT\Helpers\Traits;

use function DHT\Helpers\dht_get_db_settings_option;

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
    
    /**
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
        
        //helper local function
        function enqueueOptionScriptsHook( array $optionClasses, array $option ) : void {
            
            if ( isset( $optionClasses[ $option[ 'type' ] ] ) ) {
                
                $optionClasses[ $option[ 'type' ] ]->enqueueOptionScriptsHook( $option );
            }
        }
        
        $options = $options[ 'options' ] ?? $options;
        
        foreach ( $options as $option ) {
            
            //if the option is a group type
            if ( isset( $option[ 'options' ] ) ) {
                
                //pass the group array to the enqueue method
                enqueueOptionScriptsHook( $optionClasses, $option );
                
                // pass the option array to the enqueue method for each group option type
                foreach ( $option[ 'options' ] as $group_option ) {
                    
                    //if it is a group of groups
                    if ( isset( $group_option[ 'options' ] ) ) {
                        
                        foreach ( $group_option[ 'options' ] as $group_group_option ) {
                            
                            //pass the option array to the enqueue method
                            enqueueOptionScriptsHook( $optionClasses, $group_group_option );
                        }
                        
                    } else {
                        //if it is a simple group
                        
                        //pass the option array to the enqueue method
                        enqueueOptionScriptsHook( $optionClasses, $group_option );
                    }
                }
            } else {
                //pass the option array to the enqueue method
                enqueueOptionScriptsHook( $optionClasses, $option );
            }
        }
    }
    
    /**
     * prepare saved values to pass to specific option
     * some options are saved under a settings id others not
     *
     * @param array  $saved_values
     * @param string $option_id
     * @param string $settings_id
     *
     * @return mixed
     * @since     1.0.0
     */
    private function _prepareSavedValues( array $saved_values, string $option_id, string $settings_id ) : mixed {
        
        if ( empty( $settings_id ) ) {
            
            $saved_value = $this->_getSavedOptions( $option_id );
        } else {
            
            $saved_value = $saved_values[ $option_id ] ?? [];
        }
        
        return $saved_value;
    }
    
    /**
     * get saved options values
     *
     * @param string $settings_id - get saved options values with this id
     *
     * @return mixed
     * @since     1.0.0
     */
    private function _getSavedOptions( string $settings_id ) : mixed {
        
        return dht_get_db_settings_option( $settings_id );
    }
    
}