<?php
declare( strict_types = 1 );

namespace DHT\Helpers\Traits\Options;

use function DHT\Helpers\dht_render_options;

if ( !defined( 'DHT_MAIN' ) ) die( 'Forbidden' );

trait RenderOptionsHelpers {
    
    /**
     * Renders the HTML for container type options.
     *
     * @param array $options      options to be rendered
     * @param array $saved_values The saved values for the options.
     *
     * @return void
     * @since     1.0.0
     */
    private function _renderContainerOptions( array $options, array $saved_values ) : void {
        
        if ( array_key_exists( $options[ 'type' ], $this->_optionContainerClasses ) ) {
            // Render the respective container class
            echo $this->_optionContainerClasses[ $options[ 'type' ] ]
                ->render( $options, $saved_values );
        }
    }
    
    /**
     * Renders the HTML for group, toggle or option type options.
     *
     * @param array $options      options to be rendered
     * @param array $saved_values The saved values for the options.
     *
     * @return void
     * @since     1.0.0
     */
    private function _renderGroupOrOptionTypes( array $options, array $saved_values ) : void {
        
        echo dht_render_options(
            $options,
            $this->_settings_id,
            $saved_values,
            [
                'groupsClasses' => $this->_optionGroupsClasses,
                'togglesClasses' => $this->_optionTogglesClasses,
                'fieldsClasses' => $this->_optionFieldsClasses,
            ]
        );
    }
    
}