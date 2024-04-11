<?php
declare(strict_types=1);

namespace DHT\DI;

use DI\{Container};

class ContainerInit
{
    private Container $_container;
    
    public function __construct()
    {
        //create the main container builder
        $this->_initializeContainer();
    }
    
    /**
     * register container settings
     *
     * @return void
     */
    private function _initializeContainer(): void
    {
        $this->_container = new Container();
    }
    
    /**
     * get Container instance
     *
     * @return Container - instance of this class
     */
    public function getContainer(): Container
    {
        return $this->_container;
    }
}