<?php
declare( strict_types = 1 );

namespace DHT\Core\Options\Fields\Fields;

use DHT\Core\Options\Fields\BaseField;

if ( ! defined( 'DHT_MAIN' ) ) {
	die( 'Forbidden' );
}

final class Dropdown extends BaseField {
	
	//field type
	protected string $_field = 'dropdown';
	
	/**
	 * @since     1.0.0
	 */
	public function __construct() {
		
		parent::__construct();
	}
	
	/**
	 * Enqueue input scripts and styles
	 *
	 * @param array $field
	 *
	 * @return void
	 * @since     1.0.0
	 */
	public function enqueueOptionScripts( array $field ) : void {}
	
}