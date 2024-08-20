<?php
declare( strict_types = 1 );

namespace DHT\Helpers\Traits\Options;

if ( !defined( 'DHT_MAIN' ) ) die( 'Forbidden' );

trait EnqueueOptionsHelpers {
    
    /**
     * enqueue the scripts for each option field
     *
     * @param array $optionClasses - registered option types
     * @param array $option
     *
     * @return void
     * @since     1.0.0
     */
    private function _enqueueOptionScriptsForOption( array $optionClasses, array $option ) : void {
        
        // Enqueue scripts for the option itself
        $this->_enqueueOptionScriptsHook( $optionClasses, $option );
        
        // If the option has sub-options, handle them recursively
        if ( isset( $option[ 'options' ] ) ) {
            
            foreach ( $option[ 'options' ] as $subOption ) {
                
                $this->_enqueueOptionScriptsForOption( $optionClasses, $subOption );
                
            }
        }
    }
    
    /**
     * pass the option array to the specific option enqueue script hook to enqueue its scripts
     *
     * @param array $optionClasses - registered container/group/option types
     * @param array $option        - specific option array
     *
     * @return void
     * @since     1.0.0
     */
    private function _enqueueOptionScriptsHook( array $optionClasses, array $option ) : void {
        
        if ( isset( $optionClasses[ $option[ 'type' ] ] ) ) {
            
            $optionClasses[ $option[ 'type' ] ]->enqueueOptionScriptsHook( $option );
        }
    }
    
    /**
     * get groups and options from the container option type
     *
     * @param array $container_options - container options to retreive from
     *
     * @return mixed
     * @since     1.0.0
     */
    private function _extractOptions( array $container_options ) : array {
        
        $options = [];
        
        foreach ( $container_options as $page ) {
            if ( isset( $page[ 'options' ] ) && is_array( $page[ 'options' ] ) ) {
                // Append the options found at the current level
                $options = array_merge( $options, $page[ 'options' ] );
                
                // Recursively process nested options
                foreach ( $page[ 'options' ] as $option ) {
                    if ( isset( $option[ 'options' ] ) && is_array( $option[ 'options' ] ) ) {
                        // Recursively extract options from nested options
                        $options = array_merge( $options, $this->_extractOptions( $option[ 'options' ] ) );
                    }
                }
            }
            
            // Check for other potential nested arrays, such as 'pages'
            if ( isset( $page[ 'pages' ] ) && is_array( $page[ 'pages' ] ) ) {
                // Recursively extract options from pages
                $options = array_merge( $options, $this->_extractOptions( $page[ 'pages' ] ) );
            }
        }
        
        return $options;
    }
    
    /**
     * extract option fields in one array from the plugin option configurations
     *
     * @param array $options
     *
     * @return array
     * @since     1.0.0
     */
    private function _extractOptionFields( array $options ) : array {
        
        //if it is a container type
        if ( isset( $options[ 'pages' ] ) ) {
            
            //ger group and options from the container option type
            $option_fields = $this->_extractOptions( $options[ 'pages' ] );
            
        } else {
            //ger group and options
            $option_fields = $options[ 'options' ] ?? $options;
        }
        
        return $option_fields;
    }
    
}