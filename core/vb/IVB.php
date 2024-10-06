<?php
declare( strict_types = 1 );

namespace DHT\Core\Vb;

if ( ! defined( 'DHT_MAIN' ) ) {
	die( 'Forbidden' );
}

/**
 * Interface that is used for the VB class.
 * used for return types to not couple the code to the actual class
 */
interface IVB {
	
	/**
	 * enable visual builder on received post types
	 *
	 * @return void
	 * @since     1.0.0
	 */
	public function enable() : void;
	
}