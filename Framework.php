<?php
declare(strict_types=1);

namespace DHT;

use DHT\Di\ClassInstantiation;
use DHT\Extensions\Extensions;
use DHT\Helpers\Exceptions\{DIContainerException, DIDashMenuException};
use function DHT\Helpers\{dht_print_r, dht_validate_container};

/**
 *
 * Singleton Class that is used to include the core devhunters-fw functionality that should be used further up
 * (in a custom plugin)
 * Instantiate all DI containers
 */
final class Framework
{
    //class instances for Singleton Pattern
    private static array $_instances = [];
    
    //DI container reference
    private ClassInstantiation $_diContainer;
    
    //dash menu class reference
    public Extensions $extensions;
    
    protected function __construct()
    {
        //di registration
        $this->_initDI();
        
        //instantiate framework Extensions
        $this->extensions = Extensions::init($this->_diContainer);
        
        //other initializations
        //include the test file to test different things quickly (remove at the end)
        require_once (plugin_dir_path(__FILE__)  . "test.php");
    }

    
    /**
     * Register the PHP-DI containers
     */
    private function _initDI(): void
    {
        $this->_diContainer = new ClassInstantiation();
    }
    
    /**
     * This is the static method that controls the access to the singleton
     * instance. On the first run, it creates a singleton object and places it
     * into the static field. On subsequent runs, it returns the client existing
     * object stored in the static field.
     * @return Framework - current class
     */
    public static function init(): self
    {
        $cls = static::class;
        if (!isset(self::$_instances[$cls])) {
            self::$_instances[$cls] = new static();
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
