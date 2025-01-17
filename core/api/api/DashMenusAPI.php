<?php
declare( strict_types = 1 );

namespace DHT\Core\API\API;

use WP_REST_Request;

if( !defined( 'DHT_MAIN' ) ) die( 'Forbidden' );

/**
 * Singleton Class that is used to register all framework API endpoints
 */
final class DashMenusAPI extends BaseAPI {
	
	/**
	 * @since     1.0.0
	 */
	public function __construct() {}
	
	/**
	 * register rest api endpoints for dashboard menus
	 *
	 * @param array $config - dashboard menu configurations
	 *
	 * @return void
	 * @since     1.0.0
	 */
	public function registerAPIEndpoints( array $config ) : void {
		
		
		$menu_info = $this->_getDashMenuInfo( $config );
		
		foreach ( $menu_info as $api_endpoint => $menu_args ) {
			
			//add additional argument, here will be added the current page options - to be done
			$menu_args[ 'options' ] = [];
			
			//dashboard menus GET endpoint
			register_rest_route( $this->_namespace . '/' . $this->_version . '/dashboard-pages/', $api_endpoint, [
				'methods'  => 'GET',
				'callback' => function( $request ) use ( $menu_args ) {
					
					return $this->registerGetCallback( $request, $menu_args );
				},
				//change this to access when logged in
				//'permission_callback' => '__return_true',
			] );
		}
	}
	
	/**
	 * callback for the register rest api endpoints method
	 *
	 * @param WP_REST_Request $request
	 * @param array           $args
	 *
	 * @return array
	 * @since     1.0.0
	 */
	public function registerGetCallback( WP_REST_Request $request, array $args ) : array {
		
		return $args;
	}
	
	
	/**
	 * get registered dashboard menu config
	 *
	 * @param array $dashMenusConfig
	 *
	 * @return array
	 * @since     1.0.0
	 */
	private function _getDashMenuInfo( array $dashMenusConfig ) : array {
		
		$menus_info = [];
		
		//create main dashboard page
		foreach ( $dashMenusConfig as $menu_key => $menu_types ) {
			
			if( !isset( $menu_types[ 'api_endpoint' ] ) ) continue;
			
			if( isset( $menu_types[ 'menu_slug' ] ) ) {
				
				$menus_info[ $menu_types[ 'api_endpoint' ] ] = $menu_types;
				
			}
			else {
				
				foreach ( $menu_types as $menu ) {
					
					if( empty( $menu[ 'api_endpoint' ] ) ) continue;
					
					$menus_info[ $menu[ 'api_endpoint' ] ] = $menu;
				}
			}
		}
		
		return $menus_info;
	}
	
}