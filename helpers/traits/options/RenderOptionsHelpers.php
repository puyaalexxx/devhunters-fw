<?php
declare( strict_types = 1 );

namespace DHT\Helpers\Traits\Options;

use function DHT\Helpers\dht_render_options;

if ( !defined( 'DHT_MAIN' ) ) die( 'Forbidden' );

trait RenderOptionsHelpers {
    
    /**
     * Renders the HTML for container type options.
     *
     * @param array $saved_values The saved values for the options.
     *
     * @return void
     * @since     1.0.0
     */
    private function _renderContainerOptions( array $saved_values ) : void {
        
        if ( array_key_exists( $this->_options[ 'type' ], $this->_optionContainerClasses ) ) {
            // Render the respective container class
            echo $this->_optionContainerClasses[ $this->_options[ 'type' ] ]
                ->render( $this->_options, $saved_values, [
                    'groupClasses' => $this->_optionGroupsClasses,
                    'optionClasses' => $this->_optionClasses
                ] );
        }
    }
    
    /**
     * Renders the HTML for group or option type options.
     *
     * @param array $saved_values The saved values for the options.
     *
     * @return void
     * @since     1.0.0
     */
    private function _renderGroupOrOptionTypes( array $saved_values ) : void {
        
        echo dht_render_options(
            $this->_options[ 'options' ],
            $this->_settings_id,
            $saved_values,
            $this->_optionGroupsClasses,
            $this->_optionClasses
        );
    }
    
}