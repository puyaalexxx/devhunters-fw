<?php

namespace DHT\DI;

if (!defined('DHT_MAIN')) die('Forbidden');

use DI\Container;
use DI\DependencyException;
use DI\NotFoundException;
use function DI\create;

/**
 * Class to create the class container and used further
 */
final class ContainerCreate
{
    private Container $_container;
    
    public function __construct()
    {
        //it is based on container initialization
        $this->_container = (new ContainerInit())->getContainer();
    }
    
    /**
     * Build class instance with the passed parameters
     *
     * @param string $class_name - name of the class to create instance for
     * @param array $configurations - plugin configurations
     * @param string $exception_thrown - exception to be thrown
     * @return object - class instance upcasted to object
     */
    public function buildClassInstance(string $class_name, array $configurations, string $exception_thrown): object
    {
        try {
            
            $this->_container->set($class_name, create($class_name)->constructor($configurations));
            
            //return class instance
            return $this->_container->get($class_name);
            
        } catch (DependencyException|NotFoundException $e) {
            throw new $exception_thrown(sprintf(_x('%s class instance could not be retrieved: %s', 'exceptions', 'dht'), $class_name, $e->getMessage()));
        }
    }
}