<?php
declare( strict_types = 1 );

namespace DHT\Extensions;

if ( !defined( 'DHT_MAIN' ) ) die( 'Forbidden' );

use DHT\DI\DIInit;
use DHT\DI\ExtensionClassInstance;
use DHT\Extensions\CPT\ICPT;
use DHT\Extensions\DashPages\IDashMenuPage;
use DHT\Extensions\Sidebars\{ICreateDynamicSidebars, IRegisterSidebar};
use DHT\Extensions\Widgets\IRegisterWidget;
use DHT\Helpers\Exceptions\ConfigExceptions\{EmptyCPTConfigurationsException,
    EmptyMenuConfigurationsException,
    EmptyOptionsConfigurationsException,
    EmptySidebarConfigurationsException,
    EmptyWidgetNamesException};
use function DHT\Helpers\dht_print_r;

/**
 *
 * Singleton Class that is used to include all the framework extensions and initialise them
 */
final class Extensions {
    
    //class instances for Singleton Pattern
    private static array $_instances = [];
    
    private ExtensionClassInstance $_extensionClassInstance;
    
    public ICPT $cpt;
    
    /**
     * @param DIInit $diInit
     *
     * @since     1.0.0
     */
    protected function __construct( DIInit $diInit ) {
        
        do_action( 'dht_before_extensions_init' );
        
        //initialize Extension classes DI Container
        $this->_extensionClassInstance = $diInit->extensionClassInstance;
    }
    
    /**
     *
     * create dashboard menus with received plugin configurations
     *
     * @param mixed $dash_menus_config - dashboard menus configurations
     *
     * @return IDashMenuPage - menu instance
     * @throws EmptyMenuConfigurationsException
     * @since     1.0.0
     */
    public function createDashboardMenus( array $dash_menus_config ) : IDashMenuPage {
        
        if ( !empty( $dash_menus_config[ 'menu_pages' ] ) ) {
            
            return $this->_extensionClassInstance->getDashMenuPageInstance( $dash_menus_config[ 'menu_pages' ] );
        }
        
        throw new EmptyMenuConfigurationsException( _x( 'Empty configurations array', 'exceptions', 'dht' ) );
    }
    
    /**
     *
     * create custom post types with received plugin configurations
     *
     * @param mixed $cpt_config - cpt configurations
     *
     * @return ICPT - cpt instance
     * @throws EmptyCPTConfigurationsException
     * @since     1.0.0
     */
    public function createCPT( array $cpt_config ) : ICPT {
        
        if ( !empty( $cpt_config[ 'cpt' ] ) ) {
            
            return $this->_extensionClassInstance->getCPTInstance( $cpt_config[ 'cpt' ] );
        }
        
        throw new EmptyCPTConfigurationsException( _x( 'Empty configurations array', 'exceptions', 'dht' ) );
    }
    
    /**
     *
     * create dashboard menus with received plugin configurations
     *
     * @param mixed $options_config - options configurations
     *
     * @return void - options instance
     * @throws EmptyOptionsConfigurationsException
     * @since     1.0.0
     */
    public function createOptions( array $options_config ) : void {
        
        // TODO - to implement the framework options
        // if(!empty($dash_menus_config['options'])) {
        //return $this->_extensionClassInstance->getOptions($dash_menus_config['options']);
        // }
        
        // throw new EmptyOptionsConfigurationsException(_x('Empty configurations array passed to Options class', 'exceptions', 'dht'));
    }
    
    /**
     *
     * register the plugin widgets
     *
     * @param mixed $widgets - array of widget names
     *
     * @return IRegisterWidget - register widgets class instance
     * @throws EmptyWidgetNamesException
     * @since     1.0.0
     */
    public function registerWidgets( array $widgets ) : IRegisterWidget {
        
        if ( !empty( $widgets ) ) {
            
            return $this->_extensionClassInstance->getRegisterWidgetInstance( $widgets );
        }
        
        throw new EmptyWidgetNamesException( _x( 'Empty widgets array', 'exceptions', 'dht' ) );
    }
    
    /**
     *
     * register the plugin sidebars
     *
     * @param mixed $sidebar_config - array of sidebars
     *
     * @return IRegisterSidebar - register sidebar class instance
     * @throws EmptySidebarConfigurationsException
     * @since     1.0.0
     */
    public function registerSidebars( array $sidebar_config ) : IRegisterSidebar {
        
        if ( !empty( $sidebar_config[ 'sidebars' ] ) ) {
            
            return $this->_extensionClassInstance->getRegisterSidebarInstance( $sidebar_config[ 'sidebars' ] );
        }
        
        throw new EmptySidebarConfigurationsException( _x( 'Empty configurations array', 'exceptions', 'dht' ) );
    }
    
    /**
     *
     * create dynamic sidebars
     *
     * @param bool $createDynamicSidebars - create sidebars or not
     *
     * @return ICreateDynamicSidebars | bool - create sidebar class instance or nothing
     * @since     1.0.0
     */
    public function enableDynamicSidebars( bool $createDynamicSidebars ) : ICreateDynamicSidebars|bool {
        
        if ( $createDynamicSidebars ) {
            
            return $this->_extensionClassInstance->getCreateDynamicSidebarsInstance();
        }
        
        return false;
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