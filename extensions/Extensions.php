<?php
declare(strict_types=1);

namespace DHT\Extensions;

use DHT\DI\ClassInstantiation;
use DHT\Extensions\DashPages\IDashMenuPage;
use DHT\Framework;
use DHT\Helpers\Exceptions\DIContainerException;
use function DHT\Helpers\dht_print_r;

/**
 *
 * Singleton Class that is used to include all the framework extensions and initialise them
 */
final class Extensions
{
    //class instances for Singleton Pattern
    private static array $_instances = [];
    
    private ClassInstantiation $_diContainer;
    
    protected function __construct(ClassInstantiation $diContainer)
    {
        $this->_diContainer = $diContainer;
    }
    
    /**
     *
     * create dashboard menus with received plugin configurations
     *
     * @param mixed $dash_menus_config - dashboard menus configurations
     * @return IDashMenuPage|null - menu instance
     * @throws DIContainerException
     */
    public function createDashboardMenus(array $dash_menus_config): ?IDashMenuPage
    {
        if(!empty($dash_menus_config['menu_pages'])) {
            return $this->_diContainer->getDashMenuPageInstance($dash_menus_config['menu_pages']);
        }
        
        return null;
    }
    
    /**
     *
     * create dashboard menus with received plugin configurations
     *
     * @param mixed $options_config - options configurations
     * @return void
     */
    public function createOptions(array $options_config): void
    {
        // TODO - to implement the framework options
       // if(!empty($dash_menus_config['options'])) {
            //return $this->_diContainer->getOptions($dash_menus_config['options']);
       // }
        
        //return null;
    }
    
    
    /**
     * This is the static method that controls the access to the singleton
     * instance. On the first run, it creates a singleton object and places it
     * into the static field. On subsequent runs, it returns the client existing
     * object stored in the static field.
     *
     * @param $diContainer - Container class
     * @return Extensions - current class
     */
    public static function init($diContainer): self
    {
        $cls = static::class;
        if (!isset(self::$_instances[$cls])) {
            self::$_instances[$cls] = new static($diContainer);
        }
        
        return self::$_instances[$cls];
    }
    
    /**
     * no possibility to clone this class
     *
     * @return void
     */
    protected function __clone() : void { }
}