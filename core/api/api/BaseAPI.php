<?php

declare( strict_types = 1 );

namespace DHT\Core\Api\Api;

use PPHT\helpers\traits\SingletonTrait;

if ( ! defined( 'DHT_MAIN' ) ) {
	die( 'Forbidden' );
}

/**
 * Singleton Class that is used as a base class for all API classes
 */
abstract class BaseAPI {
	
	use SingletonTrait;
	
	//route namespace
	protected string $_namespace = 'devhunters';
	
	//route version
	protected string $_version = 'v1';
	
	
	public abstract function registerAPIEndpoints( array $config ) : void;
	
}