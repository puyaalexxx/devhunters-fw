<?php
declare(strict_types=1);

namespace DHT\DI;

use DHT\Helpers\Exceptions\{DIContainerException};
use DI\{Container, ContainerBuilder};
use Exception;
use function DI\{create};
use function DHT\Helpers\dht_print_r;

class DIRegistration
{
    //container builder instance
    private ContainerBuilder $_containerBuilder;
    
    public function __construct()
    {
        //create the main container builder
        $this->_initializeContainerBuilder();
    }
    
    /**
     * register container settings
     *
     * @param $class_name
     * @param $configurations
     * @return Container
     * @throws DIContainerException
     */
    public function createContainer($class_name, $configurations) : Container {
        //add container builder configurations and the class where to pass them
        $this->_configureContainerBuilder($class_name, $configurations);
        
        return $this->_buildContainer();
    }
    
    /**
     * register container settings
     *
     * @return void
     */
    private function _initializeContainerBuilder() : void {
        $this->_containerBuilder = new ContainerBuilder();
        
        $this->_containerBuilder->useAutowiring(false);
        $this->_containerBuilder->useAttributes(false);
        //optional, if you want to use a config file instead
        //$containerBuilder->addDefinitions(DHT_DIR . 'di/config.php');
    }
    
    /**
     * configure container dependencies
     * (here you add the class to grab an instance for and passing the needed arguments it )
     *
     * @param string $class_name - menu class to be registered
     * @param array $configurations - plugin configurations
     * @return void
     */
    private function _configureContainerBuilder( string $class_name, array $configurations ) : void {
        
        $this->_containerBuilder->addDefinitions([
           // $menu_class => create($menu_class)->method('setDashboardMenusConfigurations', $configurations)
            $class_name => create($class_name)->constructor($configurations)
        ]);
    }
    
    /**
     * build container class
     *
     * @throws DIContainerException
     */
    private function _buildContainer() : Container{
        try {
            return $this->_containerBuilder->build();
            
        } catch (Exception $e) {
            throw new DIContainerException(sprintf(_x('Could not instantiate ContainerBuilder: %s', 'exceptions', 'dht'), $e->getMessage()));
        }
    }

}