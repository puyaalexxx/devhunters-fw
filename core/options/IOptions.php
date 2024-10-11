<?php
declare( strict_types = 1 );

namespace DHT\Core\Options;

use DHT\Core\Options\Fields\BaseField;

if ( ! defined( 'DHT_MAIN' ) ) {
	die( 'Forbidden' );
}

/**
 *
 * Interface  that is used for the Option Types.
 * used for return types to not couple the code to the actual class
 */
interface IOptions {
	
	/**
	 * initialize framework option fields
	 *
	 * @return void
	 * @since     1.0.0
	 */
	public function register() : void;
	
	/**
	 * Render dashboard page options
	 *
	 * @param array $options Custom options
	 *
	 * @return void
	 * @since     1.0.0
	 */
	//public function renderDashBoardPagesOptions( array $options );
	
	/**
	 * create custom option types located outside the framework
	 *
	 * @param BaseField $optionClass
	 * @param array     $option
	 *
	 * @return void
	 * @since     1.0.0
	 */
	public function registerCustomOptionType( BaseField $optionClass, array $option ) : void;
	
}