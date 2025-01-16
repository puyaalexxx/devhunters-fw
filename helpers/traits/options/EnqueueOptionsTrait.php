<?php
declare( strict_types = 1 );

namespace DHT\Helpers\Traits\Options;

if( !defined( 'DHT_MAIN' ) ) die( 'Forbidden' );

trait EnqueueOptionsTrait {
	
	/**
	 * enqueue styles/scripts for each option received from the plugin
	 *
	 * @param array $options options from the plugin configuration files
	 *
	 * @return void
	 * @since     1.0.0
	 */
	private function _enqueueOptionsScripts( array $options ) : void {
		
		//extract options in one array from the plugin option configurations
		$option_fields = $this->_extractOptions( $options );
		
		//enqueue the scripts for each group, toggle and field (and metaboxes containers)
		foreach ( $option_fields as $option ) {
			$this->_enqueueScriptsForOptionType( $option );
		}
	}
	
	/**
	 * enqueue the scripts for each field
	 *
	 * @param array $option
	 *
	 * @return void
	 * @since     1.0.0
	 */
	private function _enqueueScriptsForOptionType( array $option ) : void {
		
		// Enqueue scripts for the option itself
		$this->_enqueueOptionScriptsHook( $option );
		
		// If the option has sub-options , handle them recursively (if it is a group or toggle)
		if( isset( $option[ 'options' ] ) ) {
			foreach ( $option[ 'options' ] as $subOption ) {
				
				if( !isset( $subOption[ 'type' ] ) ) continue;
				
				//call this method again recursively
				$this->_enqueueScriptsForOptionType( $subOption );
			}
		}
	}
	
	/**
	 * pass the option array to the specific option enqueue script hook to enqueue its scripts
	 *
	 * @param array $option specific option array
	 *
	 * @return void
	 * @since     1.0.0
	 */
	private function _enqueueOptionScriptsHook( array $option ) : void {
		
		if( !isset( $option[ 'type' ] ) ) return;
		
		if( isset( $this->_optionContainerClasses[ $option[ 'type' ] ] ) ) {
			$this->_optionContainerClasses[ $option[ 'type' ] ]->enqueueOptionScriptsHook( $option );
		}
		elseif( isset( $this->_optionGroupsClasses[ $option[ 'type' ] ] ) ) {
			$this->_optionGroupsClasses[ $option[ 'type' ] ]->enqueueOptionScriptsHook( $option );
		}
		elseif( isset( $this->_optionTogglesClasses[ $option[ 'type' ] ] ) ) {
			$this->_optionTogglesClasses[ $option[ 'type' ] ]->enqueueOptionScriptsHook( $option );
		}
		elseif( isset( $this->_optionFieldsClasses[ $option[ 'type' ] ] ) ) {
			$this->_optionFieldsClasses[ $option[ 'type' ] ]->enqueueOptionScriptsHook( $option );
		}
	}
	
	/**
	 * extract group, toggles and fields in one array from the plugin option configurations
	 *
	 * this method will add the groups , toggles, fields to one array
	 * also if the groups have toggles, it will also traverse it and add to the array
	 * if the groups or toggles have fields, it will travers them also
	 * and add the fields to the array
	 * !if the same type is added to the array, it will not add it again
	 *
	 * @param array $options options to retrieve from
	 *
	 * @return mixed
	 * @since     1.0.0
	 */
	private function _extractOptions( array $options, bool $extract_only_types = false ) : array {
		
		// Static array will still track processed types across recursive calls, but without references.
		static $processed_types = [];
		
		$getOptions = function( array $options, $processed_types, $extract_only_types ) : array {
			$result = [];
			
			// If it is a container type, extract options recursively from the container
			if( $this->_isContainerType( $options ) ) {
				//add container
				$result[] = $extract_only_types ? $options[ 'type' ] : array_merge( $options, [ 'options' => [] ] ); // without redundant options subarray
				// add container fields
				$result = array_merge( $result, $this->_extractUniqueOptionsFromContainer( $options, $processed_types, $extract_only_types ) );
			}
			else {
				// Process the options directly
				$options = $options[ 'options' ] ?? $options;
				
				// Process the options
				foreach ( $options as $option ) {
					list( $newResult, $processed_types ) = $this->_extractUniqueOptions( $option, $processed_types, $extract_only_types );
					$result = array_merge( $result, $newResult );
					
					// If it's a container type, process it separately
					if( $this->_isContainerType( $option ) ) {
						$result = array_merge( $result, $this->_extractUniqueOptionsFromContainer( $option, $processed_types, $extract_only_types ) );
					}
				}
			}
			
			return $result;
		};
		
		return $getOptions( $options, $processed_types, $extract_only_types );
	}
	
	/**
	 * Helper function to extract unique options recursively from container type
	 *
	 * @param array $options            Options to retrieve from
	 * @param array $processed_types    Already processed types to not repeat them
	 * @param bool  $extract_only_types Extract only the option type instead of the entire option array
	 *
	 * @return mixed
	 * @since     1.0.0
	 */
	private function _extractUniqueOptionsFromContainer( array $options, array $processed_types, bool $extract_only_types = false ) : array {
		$result = [];
		
		// If the 'options' key exists, process nested settings
		foreach ( $options[ 'options' ] as $page ) {
			// If it is the sidemenu container
			if( isset( $page[ 'options' ] ) && is_array( $page[ 'options' ] ) ) {
				foreach ( $page[ 'options' ] as $option ) {
					// Combine the results of recursively extracting unique options
					list( $newResult, $processed_types ) = $this->_extractUniqueOptions( $option, $processed_types, $extract_only_types );
					$result = array_merge( $result, $newResult );
				}
			}
			
			// If it is the simple container
			if( isset( $page[ 'type' ] ) ) {
				list( $newResult, $processed_types ) = $this->_extractUniqueOptions( $page, $processed_types, $extract_only_types );
				$result = array_merge( $result, $newResult );
			}
			
			// Check for other potential nested arrays, such as 'pages' (sidemenu container)
			if( isset( $page[ 'pages' ] ) && is_array( $page[ 'pages' ] ) ) {
				$result = array_merge( $result, $this->_extractOptions( $page[ 'pages' ], $extract_only_types ) );
			}
		}
		
		return $result;
	}
	
	/**
	 * Helper function to extract unique options recursively
	 *
	 * @param array $option             Options to retrieve from
	 * @param array $processed_types    Already processed types to not repeat them
	 * @param bool  $extract_only_types Extract only the option type instead of the entire option array
	 *
	 * @return mixed
	 * @since     1.0.0
	 */
	private function _extractUniqueOptions( array $option, array $processed_types, bool $extract_only_types = false ) : array {
		$result = [];
		
		if( $extract_only_types ) {
			if( isset( $option[ 'type' ] ) && !in_array( $option[ 'type' ], $processed_types ) ) {
				// Add only the type or subtype to the result
				$result[] = $processed_types[] = $option[ 'type' ];  // Store only the type
			}
		}
		else {
			if( isset( $option[ 'type' ] ) && !in_array( $option[ 'type' ], $processed_types ) || isset( $option[ 'subtype' ] ) && !in_array( $option[ 'subtype' ], $processed_types ) ) {
				$result[]          = isset( $option[ 'options' ] ) ? array_merge( $option, [ 'options' => [] ] ) : $option; // Add to the result array without redundant options subarray
				$processed_types[] = $option[ 'subtype' ] ?? $option[ 'type' ]; // Mark this type as processed
			}
		}
		
		// Recursively process nested options
		if( isset( $option[ 'options' ] ) && is_array( $option[ 'options' ] ) ) {
			foreach ( $option[ 'options' ] as $nestedOption ) {
				list( $newResult, $processed_types ) = $this->_extractUniqueOptions( $nestedOption, $processed_types, $extract_only_types );
				$result = array_merge( $result, $newResult );
			}
		}
		
		// Recursively process nested choices (left-choice, right-choice)
		if( isset( $option[ 'left-choice' ][ 'options' ] ) && is_array( $option[ 'left-choice' ][ 'options' ] ) ) {
			foreach ( $option[ 'left-choice' ][ 'options' ] as $nestedOption ) {
				list( $newResult, $processed_types ) = $this->_extractUniqueOptions( $nestedOption, $processed_types, $extract_only_types );
				$result = array_merge( $result, $newResult );
			}
		}
		if( isset( $option[ 'right-choice' ][ 'options' ] ) && is_array( $option[ 'right-choice' ][ 'options' ] ) ) {
			foreach ( $option[ 'right-choice' ][ 'options' ] as $nestedOption ) {
				list( $newResult, $processed_types ) = $this->_extractUniqueOptions( $nestedOption, $processed_types, $extract_only_types );
				$result = array_merge( $result, $newResult );
			}
		}
		
		return [ $result, $processed_types ];
	}
	
}