<?php
declare( strict_types = 1 );

namespace DHT\Extensions;

if ( !defined( 'DHT_MAIN' ) ) die( 'Forbidden' );

/**
 *
 * Interface  that is used for the Option Types.
 * used for return types to not couple the code to the actual class
 */
interface IExtensions {
    
    /**
     *
     * render options passed from the plugin
     *
     * @return void
     * @since     1.0.0
     */
    public function getExtensionName() : void;
    
    /**
     *
     * create custom option types located outside the framework
     *
     * @param array      $option
     *
     * @return void
     * @since     1.0.0
     */
    public function registerCustomOptionType( array $option) : void;
}