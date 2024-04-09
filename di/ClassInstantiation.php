<?php
declare(strict_types=1);

namespace DHT\DI;

use DHT\Extensions\DashPages\DashMenuPage;
use DHT\Extensions\DashPages\IDashMenuPage;
use DHT\Extensions\Options\IOptions;
use DHT\Extensions\Options\Options;
use DHT\Helpers\Exceptions\{DIContainerException, DIDashMenuException, DIOptionsException};
use DI\DependencyException;
use DI\NotFoundException;
use function DHT\Helpers\dht_print_r;

class ClassInstantiation
{
    private DIRegistration $_diRegistration;
    
    public function __construct()
    {
        //get DIRegistration class instance
        $this->_diRegistration = new DIRegistration();
    }
    
    /**
     *
     * return the DashMenuPage class instance
     *
     * @param array $dash_menus_config - dashboard menus configurations
     * @return IDashMenuPage - dashboard menu instance
     *
     * @throws DIContainerException
     */
    public function getDashMenuPageInstance(array $dash_menus_config) : IDashMenuPage {
        
        //build class instance with the passed parameters
        return  $this->_buildClassInstance(DashMenuPage::class, $dash_menus_config, DIDashMenuException::class);
    }
    
    /**
     *
     * return the Options class instance
     *
     * @param array $options_config - plugin configurations
     * @return IOptions - Options class instance
     *
     * @throws DIContainerException
     */
    public function getOptionsInstance(array $options_config) : IOptions {
        
        //build class instance with the passed parameters
        return $this->_buildClassInstance(Options::class, $options_config, DIOptionsException::class);
    }
    
    /**
     *
     * @param string $class_name - name of the class to create instance for
     * @param array $configurations - plugin configurations
     * @throws DIContainerException
     */
    private function _buildClassInstance(string $class_name, array $configurations, string $exception_thrown) : object {
        
        try {
            $container = $this->_diRegistration->createContainer($class_name, $configurations);
            
            //return class instance
            return $container->get($class_name);
            
        } catch (DependencyException | NotFoundException $e) {
            throw new $exception_thrown(sprintf(_x('%s class instance could not be retrieved: %s', 'exceptions', 'dht'), $class_name, $e->getMessage()));
        }
    }
}