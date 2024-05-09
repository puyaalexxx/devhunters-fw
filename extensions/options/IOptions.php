<?php
declare( strict_types = 1 );

namespace DHT\Extensions\Options;

use DHT\Extensions\Options\Options;
use DHT\Extensions\Options\Options\BaseOption;

if ( !defined( 'DHT_MAIN' ) ) die( 'Forbidden' );

/**
 *
 * Interface  that is used for the Option Types.
 * used for return types to not couple the code to the actual class
 */
interface IOptions {
    
    /**
     *
     * render options passed from the plugin
     *
     * @param string $settings_id       - the id passed to update_option() function
     * @param string $options_prefix_id - options prefix id
     *
     * @return void
     * @since     1.0.0
     */
    public function renderOptions( string $settings_id, string $options_prefix_id = '' ) : void;
    
    /**
     *
     * register framework option types with passed option settings
     *
     * @param array  $options
     *
     * @return void
     * @since     1.0.0
     */
    public function registerOptionTypes(array $options) : void;
    
    /**
     *
     * create custom option types located outside the framework
     *
     * @param BaseOption $optionClass
     * @param array      $option
     *
     * @return void
     * @since     1.0.0
     */
    public function registerCustomOptionType(BaseOption $optionClass, array $option) : void;
}