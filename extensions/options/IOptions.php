<?php
declare( strict_types = 1 );

namespace DHT\Extensions\Options;

use DHT\Extensions\Options\Options\BaseOption;

if ( !defined( 'DHT_MAIN' ) ) die( 'Forbidden' );

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
    public function init() : void;
    
    /**
     * create custom option types located outside the framework
     *
     * @param BaseOption $optionClass
     * @param array      $option
     *
     * @return void
     * @since     1.0.0
     */
    public function registerCustomOptionType( BaseOption $optionClass, array $option ) : void;
    
}