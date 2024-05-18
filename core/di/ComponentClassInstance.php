<?php
declare( strict_types = 1 );

namespace DHT\Core\DI;

if ( !defined( 'DHT_MAIN' ) ) die( 'Forbidden' );

use DHT\Components\Preloader\{IPreloader, Preloader};
use DHT\Helpers\Exceptions\{DIExceptions\DIException};

/**
 * Class to get instances of Extension classes
 */
final class ComponentClassInstance {
    
    private ContainerCreate $_containerCreate;
    
    /**
     * @param ContainerCreate $_containerCreate
     *
     * @since     1.0.0
     */
    public function __construct( ContainerCreate $_containerCreate ) {
        
        $this->_containerCreate = $_containerCreate;
    }
    
    /**
     * return the Preloader class instance
     *
     * @return IPreloader - Preloader instance
     * @since     1.0.0
     */
    public function getPreloaderInstance() : IPreloader {
        
        //build class instance with the passed parameters
        return $this->_containerCreate->buildClassInstance( Preloader::class, [], DIException::class );
    }
    
}