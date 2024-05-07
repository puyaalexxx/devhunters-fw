<?php
declare( strict_types = 1 );

namespace DHT\Core\DI;

if ( !defined( 'DHT_MAIN' ) ) die( 'Forbidden' );

class OtherClassInstance {
    
    private ContainerCreate $_containerCreate;
    
    /**
     * @param ContainerCreate $_containerCreate
     *
     * @since     1.0.0
     */
    public function __construct( ContainerCreate $_containerCreate ) {
        
        $this->_containerCreate = $_containerCreate;
    }
    
}