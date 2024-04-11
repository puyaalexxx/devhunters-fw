<?php
declare(strict_types=1);

namespace DHT\Extensions;

use DHT\DI\ClassInstance;
use DHT\Extensions\CPT\ICPT;
use DHT\Extensions\DashPages\IDashMenuPage;

/**
 *
 * Singleton Class that is used to include all the framework extensions and initialise them
 */
final class Extensions
{
    //class instances for Singleton Pattern
    private static array $_instances = [];
    
    private ClassInstance $_classInstance;
    
    protected function __construct(ClassInstance $classInstance)
    {
        do_action('dht_before_extensions_init');
        
        $this->_classInstance = $classInstance;
        
        //register the after extensions initialisation hook
        add_action('admin_init', array($this, 'registerAfterExtensionsInitHook'));
    }
    
    /**
     *
     * create dashboard menus with received plugin configurations
     *
     * @param mixed $dash_menus_config - dashboard menus configurations
     * @return IDashMenuPage|null - menu instance
     */
    public function createDashboardMenus(array $dash_menus_config): ?IDashMenuPage
    {
        if (!empty($dash_menus_config['menu_pages'])) {
            
            return $this->_classInstance->getDashMenuPageInstance($dash_menus_config['menu_pages']);
        }
        
        return null;
    }
    
    /**
     *
     * create custom post types with received plugin configurations
     *
     * @param mixed $cpt_config - cpt configurations
     * @return ICPT|null - menu instance
     */
    public function createCPT(array $cpt_config): ?ICPT
    {
        if (!empty($cpt_config['cpt'])) {
            
            return $this->_classInstance->getCPTInstance($cpt_config['cpt']);
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
        //return $this->_classInstance->getOptions($dash_menus_config['options']);
        // }
        
        //return null;
    }
    
    /**
     * register the after extensions initialisation hook
     *
     * @return void
     */
    public function registerAfterExtensionsInitHook(): void
    {
        do_action('dht_after_extensions_init');
    }
    
    /**
     * This is the static method that controls the access to the singleton
     * instance. On the first run, it creates a singleton object and places it
     * into the static field. On subsequent runs, it returns the client existing
     * object stored in the static field.
     *
     * @param $classInstance - ClassInstance object
     * @return Extensions - current class
     */
    public static function get(ClassInstance $classInstance): self
    {
        $cls = static::class;
        if (!isset(self::$_instances[$cls])) {
            self::$_instances[$cls] = new static($classInstance);
        }
        
        return self::$_instances[$cls];
    }
    
    /**
     * no possibility to clone this class
     *
     * @return void
     */
    protected function __clone(): void
    {
    }
}