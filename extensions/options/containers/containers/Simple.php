<?php
declare( strict_types = 1 );

namespace DHT\Extensions\Options\Containers\Containers;

use DHT\Extensions\Options\Containers\BaseContainer;

if( !defined( 'DHT_MAIN' ) ) die( 'Forbidden' );

final class Simple extends BaseContainer {
    
    //field type
    protected string $_container = 'simple';
    
    /**
     * @param array $optionGroupsClasses
     * @param array $optionTogglesClasses
     * @param array $optionFieldsClasses
     *
     * @since     1.0.0
     */
    public function __construct( array $optionGroupsClasses, array $optionTogglesClasses, array $optionFieldsClasses ) {
        
        parent::__construct( $optionGroupsClasses, $optionTogglesClasses, $optionFieldsClasses );
    }
    
    protected function enqueueOptionScripts( array $container ) : void {}
    
}
