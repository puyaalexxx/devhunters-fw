<?php
declare( strict_types = 1 );

namespace DHT\Extensions;

if ( !defined( 'DHT_MAIN' ) ) die( 'Forbidden' );

use DHT\Core\DI\DIInit;
use DHT\Core\DI\ExtensionClassInstance;
use DHT\Extensions\CPT\ICPT;
use DHT\Extensions\DashPages\IDashMenuPage;
use DHT\Extensions\Options\IOptions;
use DHT\Extensions\Sidebars\{ICreateDynamicSidebars, IRegisterSidebar};
use DHT\Extensions\Widgets\IRegisterWidget;
use DHT\Helpers\Exceptions\ConfigExceptions\EmptyCPTConfigurationsException;
use DHT\Helpers\Exceptions\ConfigExceptions\EmptyMenuConfigurationsException;
use DHT\Helpers\Exceptions\ConfigExceptions\EmptySidebarConfigurationsException;
use DHT\Helpers\Exceptions\ConfigExceptions\EmptyWidgetNamesException;
use DHT\Helpers\Traits\ValidateConfigurations;
use function DHT\Helpers\dht_get_variables_from_file;

/**
 * Singleton Class that is used to include all the framework extensions and initialise them
 */
final class Extensions {
    
    use ValidateConfigurations;
    
    //class instances for Singleton Pattern
    private static array $_instances = [];
    
    private ExtensionClassInstance $_extensionClassInstance;
    
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
     * get dashboard menus extension class instance
     *
     * @param array $dash_menus_config - dashboard menus configurations
     *
     * @return IDashMenuPage - menu instance
     * @since     1.0.0
     */
    public function dashmenus( array $dash_menus_config ) : IDashMenuPage {
        
        $dash_menus_config = $this->_validateConfigurations( $dash_menus_config, '',
            'dash_menus_configurations', EmptyMenuConfigurationsException::class,
            _x( 'Empty dashboard menu configurations array provided', 'exceptions', DHT_PREFIX ) );
        
        return $this->_extensionClassInstance->getDashMenuPageInstance( $dash_menus_config );
    }
    
    /**
     * get custom post types extension class instance
     *
     * @param array $cpt_config
     *
     * @return ICPT - cpt instance
     * @since     1.0.0
     */
    public function cpts( array $cpt_config ) : ICPT {
        
        $cpt_config = $this->_validateConfigurations( $cpt_config, '',
            'dht_cpts_configurations', EmptyCPTConfigurationsException::class,
            _x( 'Empty cpt configurations array provided', 'exceptions', DHT_PREFIX ) );
        
        return $this->_extensionClassInstance->getCPTInstance( $cpt_config );
    }
    
    /**
     * get options extension class instance
     *
     * @return ?IOptions - options instance
     * @since     1.0.0
     */
    public function options() : ?IOptions {
        
        //init class only if on specific pages (set from the plugin) and not ajax request to not block it
        if ( !wp_doing_ajax() && !apply_filters( 'dht_options_init_on_page', true ) ) return null;
        
        return $this->_extensionClassInstance->getOptionsInstance();
    }
    
    /**
     * get widgets extension class instance
     *
     * @param array $widgets_config
     *
     * @return IRegisterWidget - register widgets class instance
     * @since     1.0.0
     */
    public function widgets( array $widgets_config ) : IRegisterWidget {
        
        $widgets_config = $this->_validateConfigurations( $widgets_config, '',
            'dht_widgets_configurations', EmptyWidgetNamesException::class,
            _x( 'Empty widgets configurations array provided', 'exceptions', DHT_PREFIX ) );
        
        return $this->_extensionClassInstance->getRegisterWidgetInstance( $widgets_config );
    }
    
    public function get_option_icons() : void {
        
        if ( isset( $_POST[ 'data' ][ 'icon_type' ] ) ) {
            
            //retrieve icon type
            $icon_type = $_POST[ 'data' ][ 'icon_type' ];
            $icon = !empty( $_POST[ 'data' ][ 'icon' ] ) ? $_POST[ 'data' ][ 'icon' ] : '';
            
            $icons = [];
            
            if ( $icon_type == 'dashicons' ) {
                $icons = dht_get_variables_from_file( DHT_OPTIONS_DIR . 'options/icons/dashicons.php', 'dashicons' );
            }
            
            if ( $icon_type == 'fontawesome' ) {
                $icons = dht_get_variables_from_file( DHT_OPTIONS_DIR . 'options/icons/font-awesome.php', 'font_awesome_icons' );
            }
            
            if ( $icon_type == 'divi' ) {
                $icons = dht_get_variables_from_file( DHT_OPTIONS_DIR . 'options/icons/divi.php', 'divi_icons' );
            }
            
            if ( $icon_type == 'elusive' ) {
                $icons = dht_get_variables_from_file( DHT_OPTIONS_DIR . 'options/icons/elusive.php', 'elusive_icons' );
            }
            
            if ( $icon_type == 'line' ) {
                $icons = dht_get_variables_from_file( DHT_OPTIONS_DIR . 'options/icons/line.php', 'line_icons' );
            }
            
            if ( $icon_type == 'dev' ) {
                $icons = dht_get_variables_from_file( DHT_OPTIONS_DIR . 'options/icons/devicon.php', 'devicon_icons' );
            }
            
            if ( $icon_type == 'bootstrap' ) {
                $icons = dht_get_variables_from_file( DHT_OPTIONS_DIR . 'options/icons/bootstrap.php', 'bootstrap_icons' );
            }
            
            if ( !empty( $icons ) ) {
                
                ob_start();
                
                foreach ( $icons as $icon_class => $icon_code ) {
                    
                    //set active icon
                    $active_icon = $icon == $icon_class ? 'dht-active-icon="true"' : '';
                    
                    echo '<i class="' . $icon_class . '" data-code="' . $icon_code . '" ' . $active_icon . ' ></i>';
                }
                
                $icon_templates = ob_get_clean();
                
            } else {
                
                $icon_templates = 'No icons provided';
            }
            
            wp_send_json_success( $icon_templates );
            
            die();
        }
    }
    
    /**
     * get sidebars extension class instance
     *
     * @param array $sidebar_config
     *
     * @return IRegisterSidebar - register sidebar class instance
     * @since     1.0.0
     */
    public function sidebars( array $sidebar_config ) : IRegisterSidebar {
        
        $sidebar_config = $this->_validateConfigurations( $sidebar_config, '',
            'dht_sidebars_configurations', EmptySidebarConfigurationsException::class,
            _x( 'Empty configurations array provided', 'exceptions', DHT_PREFIX ) );
        
        return $this->_extensionClassInstance->getRegisterSidebarInstance( $sidebar_config );
    }
    
    /**
     * get dynamic sidebars extension class instance
     *
     * @param bool $createDynamicSidebars
     *
     * @return ICreateDynamicSidebars | bool - create sidebar class instance or nothing
     * @since     1.0.0
     */
    public function dynamicSidebars( bool $createDynamicSidebars ) : ICreateDynamicSidebars|bool {
        
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
     * @param DIInit $classInstance - ClassInstance object
     *
     * @return self - current class
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