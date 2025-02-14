<?php
declare( strict_types = 1 );

namespace DHT\Helpers\Traits\Options;

if( !defined( 'DHT_MAIN' ) ) {
	die( 'Forbidden' );
}

use function DHT\Helpers\dht_set_db_settings_option;

trait SaveOptionsTrait {
	
	/**
	 * Save post metaboxes options
	 *
	 * @param int   $postID     Saved post id
	 * @param array $postValues $_POST values
	 *
	 * @return void
	 * @since     1.0.0
	 */
	public function _savePostTypeMetaboxesOptions( int $postID, array $postValues ) : void {
		//many metaboxes
		if( !isset( $this->_postTypeOptions[ 'options' ] ) ) {
			foreach ( $this->_postTypeOptions as $options ) {
				if( isset( $postValues[ $options[ 'id' ] ] ) ) {
					$this->_saveContainerOptions( $options, $postValues[ $options[ 'id' ] ], 'post', $postID );
				}
			}
		}
		else {
			$this->_saveContainerOptions( $this->_postTypeOptions, $postValues[ $this->_postTypeOptions[ 'id' ] ], 'post', $postID );
		}
	}
	
	/**
	 * Save vb modules options on the current post type
	 *
	 * @param int   $postID     Saved post id
	 * @param array $postValues $_POST values
	 *
	 * @return void
	 * @since     1.0.0
	 */
	private function _saveVBModulesOptions( int $postID, array $postValues ) : void {
		
		foreach ( $postValues as $modalName => $values ) {
			if( isset( $this->_vbOptions[ $modalName ] ) ) {
				foreach ( $values as $modalID => $modalValues ) {
					//modals should be saved under their id specified in ppht_get_module_view function
					$options = array_merge( $this->_vbOptions[ $modalName ], [ "id" => $modalID ] );
					
					if( !empty( $modalValues ) ) {
						$modalValue = json_decode( stripslashes( html_entity_decode( $modalValues, ENT_QUOTES, 'UTF-8' ) ), true );
					}
					else {
						//because the hidden input on refresh will be empty we must add
						//the saved value back to it to no lose the previous saved values
						$modalValue = get_post_meta( $postID, $modalID, true );
						$modalValue = empty( $modalValue ) ? [] : $modalValue;
					}
					
					$this->_saveContainerOptions( $options, $modalValue, 'vb', $postID );
				}
			}
		}
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
	 * @param int    $id          Post id or term id
	 * @param bool   $save        To save the options tp the database or not
	 *
	 * @return array The processed values to be saved.
	 * @since     1.0.0
	 */
	private function _saveContainerOptions( array $options, array $post_values, string $location = 'dashboard', int $id = 0, bool $save = true ) : array {
		
		$values = [];
		
		// Check if the option type is set and has a corresponding container class
		if( isset( $options[ 'type' ], $this->_optionContainerClasses[ $options[ 'type' ] ] ) ) {
			//vb modals do not need the container id
			if( $location == 'vb' ) {
				$values = $this->_optionContainerClasses[ $options[ 'type' ] ]->saveValue( $options, $post_values );
			}
			else {
				$values[ $options[ 'id' ] ] = $this->_optionContainerClasses[ $options[ 'type' ] ]->saveValue( $options, $post_values );
			}
			
			// Save the values to the database
			if( $save ) $this->_saveToDB( $values, $options, $location, $id );
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
	 * @param bool   $save     To save the options or not
	 *
	 * @return void
	 * @since     1.0.0
	 */
	private function _saveUngroupedOptions( array $options, string $location = 'dashboard', int $id = 0, bool $save = true ) : void {
		
		foreach ( $options as $option ) {
			if( isset( $option[ 'id' ] ) && array_key_exists( $option[ 'id' ], $_POST ) ) {
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
				if( $save ) $this->_saveToDB( $value, $option, $location, $id );
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
	private function _saveToDB( array $values, array $options, string $location = 'dashboard', int $id = 0 ) : void {
		
		$saveData = function( $values, string $option_id, string $location, int $id ) : void {
			//save post data
			if( $location == 'post' || $location == 'vb' ) {
				update_post_meta( $id, $option_id, $values );
			} //save term data
			elseif( $location == 'term' ) {
				update_term_meta( $id, $option_id, $values );
			} //save dashboard page options data
			else {
				dht_set_db_settings_option( $option_id, $values );
			}
		};
		
		//vb modals should never save their options separately
		if( $this->_isSaveOptionsSeparately( $options ) && $location !== "vb" ) {
			foreach ( $values[ $options[ 'id' ] ] as $option_id => $option_values ) {
				$saveData( $option_values, $option_id, $location, $id );
			}
		}
		else {
			$saveData( $values, $options[ 'id' ], $location, $id );
		}
	}
	
}