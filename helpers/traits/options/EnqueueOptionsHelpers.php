<?php
declare( strict_types = 1 );

namespace DHT\Helpers\Traits\Options;

if ( !defined( 'DHT_MAIN' ) ) die( 'Forbidden' );

trait EnqueueOptionsHelpers {
    
    /**
     * enqueue styles/scripts for each option received from the plugin
     *
     * @param array $options                  - options from the plugin configuration files
     * @param array $registeredOptionsClasses - registered option types
     *
     * @return void
     * @since     1.0.0
     */
    private function _enqueueOptionsScripts( array $options, array $registeredOptionsClasses ) : void {
        
        //enqueue the scripts for the container type
        if ( isset( $options[ 'pages' ] ) ) {
            //pass the container array to the enqueue method
            $this->_enqueueOptionScriptsHook( $registeredOptionsClasses, $options );
        }
        
        //extract options in one array from the plugin option configurations
        $option_fields = $this->_extractOptions( $options );
        
        //enqueue the scripts for each group, toggle and field
        foreach ( $option_fields as $option ) {
            $this->_enqueueScriptsForOptionType( $registeredOptionsClasses, $option );
        }
    }
    
    /**
     * enqueue the scripts for each field
     *
     * @param array $registeredOptionsClasses - registered option types
     * @param array $option
     *
     * @return void
     * @since     1.0.0
     */
    private function _enqueueScriptsForOptionType( array $registeredOptionsClasses, array $option ) : void {
        
        // Enqueue scripts for the option itself
        $this->_enqueueOptionScriptsHook( $registeredOptionsClasses, $option );
        
        // If the option has sub-options , handle them recursively (if it is a group or toggle)
        if ( isset( $option[ 'options' ] ) ) {
            
            foreach ( $option[ 'options' ] as $subOption ) {
                
                if ( !isset( $subOption[ 'type' ] ) ) continue;
                
                //call this method again recursively
                $this->_enqueueScriptsForOptionType( $registeredOptionsClasses, $subOption );
            }
        }
    }
    
    /**
     * pass the option array to the specific option enqueue script hook to enqueue its scripts
     *
     * @param array $registeredOptionsClasses - registered container/group/option types
     * @param array $option                   - specific option array
     *
     * @return void
     * @since     1.0.0
     */
    private function _enqueueOptionScriptsHook( array $registeredOptionsClasses, array $option ) : void {
        
        if ( isset( $registeredOptionsClasses[ $option[ 'type' ] ] ) ) {
            $registeredOptionsClasses[ $option[ 'type' ] ]->enqueueOptionScriptsHook( $option );
        }
    }
    
    /**
     * extract group, toggles and fields in one array from the plugin option configurations
     *
     * this method will add the groups , toggles, fields to one array
     * also if the groups have toggles, it will also traverse it and add to the array
     * if the groups or toggles have fields, it will travers them also
     * and add the fields to the array
     * ! if the same type is added to the array, it will not add it again
     *
     * @param array $options - options to retrieve from
     *
     * @return mixed
     * @since     1.0.0
     */
    private function _extractOptions( array $options ) : array {
        
        // This static array will keep track of processed types across recursive calls
        static $processed_types = [];
        
        $result = [];
        
        // Inner function to extract unique options recursively
        $extractUniqueOptions = function ( array $option ) use ( &$extractUniqueOptions, &$processed_types ) : array {
            
            $result = [];
            
            if ( isset( $option[ 'type' ] ) && !in_array( $option[ 'type' ], $processed_types ) ) {
                $result[] = $option; // Add to the result array
                $processed_types[] = $option[ 'type' ]; // Mark this type as processed
            }
            
            // Recursively process nested options
            if ( isset( $option[ 'options' ] ) && is_array( $option[ 'options' ] ) ) {
                foreach ( $option[ 'options' ] as $nestedOption ) {
                    $result = array_merge( $result, $extractUniqueOptions( $nestedOption ) );
                }
            }
            
            // Recursively process nested choices (left-choice, right-choice)
            if ( isset( $option[ 'left-choice' ][ 'options' ] ) && is_array( $option[ 'left-choice' ][ 'options' ] ) ) {
                foreach ( $option[ 'left-choice' ][ 'options' ] as $nestedOption ) {
                    $result = array_merge( $result, $extractUniqueOptions( $nestedOption ) );
                }
            }
            
            if ( isset( $option[ 'right-choice' ][ 'options' ] ) && is_array( $option[ 'right-choice' ][ 'options' ] ) ) {
                foreach ( $option[ 'right-choice' ][ 'options' ] as $nestedOption ) {
                    $result = array_merge( $result, $extractUniqueOptions( $nestedOption ) );
                }
            }
            
            return $result;
        };
        
        //if it is a container type
        if ( isset( $options[ 'pages' ] ) ) {
            // If the 'pages' key exists, process nested pages
            foreach ( $options[ 'pages' ] as $page ) {
                if ( isset( $page[ 'options' ] ) && is_array( $page[ 'options' ] ) ) {
                    foreach ( $page[ 'options' ] as $option ) {
                        $result = array_merge( $result, $extractUniqueOptions( $option ) );
                    }
                }
                
                // Check for other potential nested arrays, such as 'pages'
                if ( isset( $page[ 'pages' ] ) && is_array( $page[ 'pages' ] ) ) {
                    $result = array_merge( $result, $this->_extractOptions( $page[ 'pages' ] ) );
                }
            }
        } // other option types
        else {
            
            //extract the correct options
            $options = $options[ 'options' ] ?? $options;
            
            // Process the options directly
            foreach ( $options as $option ) {
                $result = array_merge( $result, $extractUniqueOptions( $option ) );
            }
        }
        
        return $result;
    }
    
}