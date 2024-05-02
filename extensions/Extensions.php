<?php
declare( strict_types = 1 );

namespace DHT\Extensions;

if ( !defined( 'DHT_MAIN' ) ) die( 'Forbidden' );

use DHT\DI\DIInit;
use DHT\DI\ExtensionClassInstance;
use DHT\Extensions\CPT\ICPT;
use DHT\Extensions\DashPages\IDashMenuPage;
use DHT\Extensions\Options\IOptions;
use DHT\Extensions\Sidebars\{ICreateDynamicSidebars, IRegisterSidebar};
use DHT\Extensions\Widgets\IRegisterWidget;
use function DHT\Helpers\dht_print_r;

/**
 *
 * Singleton Class that is used to include all the framework extensions and initialise them
 */
final class Extensions {
    
    //class instances for Singleton Pattern
    private static array $_instances = [];
    
    private ExtensionClassInstance $_extensionClassInstance;
    
    //dashboard menus class instance
    public IDashMenuPage $dashMenus;
    
    //cpt class instance
    public ICPT $cpts;
    
    //widgets class instance
    public IRegisterWidget $widgets;
    
    //sidebars class instance
    public IRegisterSidebar $sidebars;
    
    //dynamic sidebars class instance
    public ICreateDynamicSidebars|bool $dynamicSidebars;
    
    //options class instance
    public IOptions $options;
    
    /**
     * @param DIInit $diInit
     *
     * @since     1.0.0
     */
    protected function __construct( DIInit $diInit ) {
        
        do_action( 'dht_before_extensions_init' );
        
        //initialize Extension classes DI Container
        $this->_extensionClassInstance = $diInit->extensionClassInstance;
        
        //get all extensions class instances
        $this->dashMenus = $this->_getDashMenusClassInstance();
        $this->cpts = $this->_getCPTClassInstance();
        $this->widgets = $this->_getWidgetsClassInstance();
        $this->sidebars = $this->_getSidebarsClassInstance();
        $this->dynamicSidebars = $this->_getDynamicSidebarsClassInstance();
        $this->options = $this->_getOptionsClassInstance();
    }
    
    /**
     *
     * get dashboard menus extension class instance
     *
     * @return IDashMenuPage - menu instance
     * @since     1.0.0
     */
    private function _getDashMenusClassInstance() : IDashMenuPage {
        
        return $this->_extensionClassInstance->getDashMenuPageInstance();
    }
    
    /**
     *
     * get custom post types extension class instance
     *
     * @return ICPT - cpt instance
     * @since     1.0.0
     */
    private function _getCPTClassInstance() : ICPT {
        
        return $this->_extensionClassInstance->getCPTInstance();
    }
    
    /**
     *
     * get options extension class instance
     *
     * @return IOptions - options instance
     * @since     1.0.0
     */
    private function _getOptionsClassInstance() : IOptions {
        
        return $this->_extensionClassInstance->getOptionsInstance();
    }
    
    /**
     *
     * get widgets extension class instance
     *
     * @return IRegisterWidget - register widgets class instance
     * @since     1.0.0
     */
    private function _getWidgetsClassInstance() : IRegisterWidget {
        
        return $this->_extensionClassInstance->getRegisterWidgetInstance();
    }
    
    /**
     *
     * get sidebars extension class instance
     *
     * @return IRegisterSidebar - register sidebar class instance
     * @since     1.0.0
     */
    private function _getSidebarsClassInstance() : IRegisterSidebar {
        
        return $this->_extensionClassInstance->getRegisterSidebarInstance();
    }
    
    /**
     *
     * get dynamic sidebars extension class instance
     *
     * @return ICreateDynamicSidebars | bool - create sidebar class instance or nothing
     * @since     1.0.0
     */
    private function _getDynamicSidebarsClassInstance() : ICreateDynamicSidebars|bool {
        
        return $this->_extensionClassInstance->getCreateDynamicSidebarsInstance();
    }
    
    /**
     * This is the static method that controls the access to the singleton
     * instance. On the first run, it creates a singleton object and places it
     * into the static field. On subsequent runs, it returns the client existing
     * object stored in the static field.
     *
     * @param $classInstance - ClassInstance object
     *
     * @return Extensions - current class
     * @since     1.0.0
     */
    public static function init( DIInit $classInstance ) : self {
        
        $cls = static::class;
        if ( !isset( self::$_instances[ $cls ] ) ) {
            self::$_instances[ $cls ] = new static( $classInstance );
        }
        
        return self::$_instances[ $cls ];
    }
    
    /**
     * no possibility to clone this class
     *
     * @return void
     * @since     1.0.0
     */
    protected function __clone() : void {}
    
}