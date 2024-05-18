<?php

namespace DHT\Core\DI;

if ( !defined( 'DHT_MAIN' ) ) die( 'Forbidden' );

/**
 * Class to initialise all the Classes that requires dependecy injections
 */
final class DIInit {
    
    private ContainerCreate $_containerCreate;
    public ExtensionClassInstance $extensionClassInstance;
    public ComponentClassInstance $compoponentClassInstance;
    
    /**
     * @since     1.0.0
     */
    public function __construct() {
        
        $this->_containerCreate = new ContainerCreate();
        
        //get all Extension classes instances
        $this->extensionClassInstance = new ExtensionClassInstance( $this->_containerCreate );
        
        //get all Component classes instances
        $this->compoponentClassInstance = new ComponentClassInstance( $this->_containerCreate );
    }
    
}