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
     *
     * render options passed from the plugin
     *
     * @param array  $options   - option fields
     * @param array  $saved_values
     * @param string $prefix_id - options prefix id
     *
     * @return void
     * @since     1.0.0
     */
    public function renderOptions( array $options, array $saved_values, string $prefix_id = '' ) : void;
    
    
    public function registerOptionType(BaseOption $optionClass);
}