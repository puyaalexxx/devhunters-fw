<?php
declare( strict_types = 1 );

namespace DHT\Helpers\Traits\Options;

if( !defined( 'DHT_MAIN' ) ) die( 'Forbidden' );

use function DHT\Helpers\dht_render_options;

trait RenderOptionsHelpers {
    
    /**
     * Generates the HTML view for the options.
     *
     * This method retrieves the saved options, determines the type of options being rendered,
     * and generates the appropriate HTML output. It handles both container types and group/toggle/field types.
     *
     *
     * @param array  $options
     * @param string $location Where to save the data - dashboard/post or term
     * @param int    $id       post id or term id
     *
     * @return string
     * @since     1.0.0
     */
    private function _getOptionsView( array $options, string $location = 'dashboard', int $id = 0 ) : string {
        
        $saved_values = $this->_getOptionsSavedValues( $options, $location, $id );
        
        // Start output buffering
        ob_start();
        
        // Render container options
        if( isset( $options[ 'type' ] ) && array_key_exists( $options[ 'type' ], $this->_optionContainerClasses ) ) {
            
            echo $this->_optionContainerClasses[ $options[ 'type' ] ]->render( $options, $saved_values );
            
        } // Render ungrouped option types
        else {
            echo dht_render_options( $options[ 'options' ] ?? $options, $options[ 'id' ] ?? '', $saved_values, [
                    'groupsClasses'  => $this->_optionGroupsClasses,
                    'togglesClasses' => $this->_optionTogglesClasses,
                    'fieldsClasses'  => $this->_optionFieldsClasses,
                ] );
        }
        
        // Return the generated HTML view
        return ob_get_clean();
    }
    
}