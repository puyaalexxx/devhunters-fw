<?php
declare( strict_types = 1 );

namespace DHT\Helpers\Traits\Options;

if( !defined( 'DHT_MAIN' ) ) {
	die( 'Forbidden' );
}

use function DHT\Helpers\dht_fw_is_save_options_separately;
use function DHT\Helpers\dht_get_db_settings_option;

trait GetOptionsHelpers {
	
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
		
		if( dht_fw_is_save_options_separately( $options ) && $location !== 'vb' ) {
			$values              = $saved_values = [];
			$is_simple_container = $this->_isSimpleContainer( $options );
			
			foreach ( $options[ 'options' ] as $option ) {
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
			foreach ( $option[ 'options' ] as $opt ) {
				$saved_values = array_merge( $saved_values, $this->_getSavedValue( $opt[ 'id' ], $location, $id ) );
			}
		} // Check for other potential nested arrays, such as 'pages' - sidemenu container
		elseif( isset( $option[ 'pages' ] ) && is_array( $option[ 'pages' ] ) ) {
			foreach ( $option[ 'pages' ] as $page ) {
				if( isset( $page[ 'options' ] ) ) {
					foreach ( $page[ 'options' ] as $opt ) {
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
			foreach ( $option[ 'options' ] as $opt ) {
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
			foreach ( $option[ 'pages' ] as $page ) {
				if( isset( $page[ 'options' ] ) ) {
					foreach ( $page[ 'options' ] as $opt ) {
						//get option value
						$saved_values[ $opt[ 'id' ] ] = dht_get_db_settings_option( $opt[ 'id' ] );
					}
				}
			}
		}
		else {
			//get option value
			$option_value = dht_get_db_settings_option( $option[ 'id' ] );
			
			if( !empty( $option_value ) ) {
				$saved_values[ $option[ 'id' ] ] = $option_value;
			}
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
		elseif( $location == 'vb' ) {
			//get option value
			$option_values = get_post_meta( $id, $options[ 'id' ], true );
			
			//retrieve grouped container values
			$saved_values[ $options[ 'id' ] ] = !empty( $option_values ) ? $option_values : [];
		}
		else {
			//get saved options if settings id present
			if( isset( $options[ 'id' ] ) ) {
				$saved_values = dht_get_db_settings_option( $options[ 'id' ] );
			} // if simple options without container
			else {
				foreach ( $options as $option ) {
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
		
		if( $option_value !== '' ) {
			$values[ $option_id ] = $option_value;
		}
		
		return $values;
	}
	
}