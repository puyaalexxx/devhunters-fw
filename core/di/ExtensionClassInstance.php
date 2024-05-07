<?php
declare( strict_types = 1 );

namespace DHT\Core\DI;

if ( !defined( 'DHT_MAIN' ) ) die( 'Forbidden' );

use DHT\Extensions\CPT\{CPT, ICPT};
use DHT\Extensions\DashPages\{DashMenuPage, IDashMenuPage};
use DHT\Extensions\Options\{IOptions, Options};
use DHT\Extensions\Sidebars\{CreateDynamicSidebars, ICreateDynamicSidebars, IRegisterSidebar, RegisterSidebar};
use DHT\Extensions\Widgets\{IRegisterWidget, RegisterWidget};
use DHT\Helpers\Exceptions\{DIExceptions\DIException};

/**
 * Class to get instances of Extension classes
 */
final class ExtensionClassInstance {
    
    private ContainerCreate $_containerCreate;
    
    /**
     * @param ContainerCreate $_containerCreate
     *
     * @since     1.0.0
     */
    public function __construct( ContainerCreate $_containerCreate ) {
        
        $this->_containerCreate = $_containerCreate;
    }
    
    /**
     *
     * return the DashMenuPage class instance
     *
     * @param array $dash_menus_config - dashboard menus configurations
     *
     * @return IDashMenuPage - dashboard menu class instance
     * @since     1.0.0
     */
    public function getDashMenuPageInstance( array $dash_menus_config = [] ) : IDashMenuPage {
        
        //build class instance with the passed parameters
        return $this->_containerCreate->buildClassInstance( DashMenuPage::class, $dash_menus_config, DIException::class );
    }
    
    /**
     *
     * return the CPT class instance
     *
     * @param array $cpt_config - cpt configurations
     *
     * @return ICPT - CPT class instance
     * @since     1.0.0
     */
    public function getCPTInstance( array $cpt_config = []) : ICPT {
        
        //build class instance with the passed parameters
        return $this->_containerCreate->buildClassInstance( CPT::class, $cpt_config, DIException::class );
    }
    
    /**
     *
     * return the Options class instance
     *
     * @param array $options_config - plugin configurations
     *
     * @return IOptions - Options class instance
     * @since     1.0.0
     */
    public function getOptionsInstance( array $options_config = [] ) : IOptions {
        
        //build class instance with the passed parameters
        return $this->_containerCreate->buildClassInstance( Options::class, $options_config, DIException::class );
    }
    
    /**
     *
     * return the RegisterWidgets class instance
     *
     * @param array $widgets - widget names
     *
     * @return IRegisterWidget - RegisterWidget instance
     * @since     1.0.0
     */
    public function getRegisterWidgetInstance( array $widgets = []) : IRegisterWidget {
        
        //build class instance with the passed parameters
        return $this->_containerCreate->buildClassInstance( RegisterWidget::class, $widgets, DIException::class );
    }
    
    /**
     *
     * return the RegisterSidebar class instance
     *
     * @param array $sidebar_config - sidebars config
     *
     * @return IRegisterSidebar - RegisterSidebar instance
     * @since     1.0.0
     */
    public function getRegisterSidebarInstance( array $sidebar_config = [] ) : IRegisterSidebar {
        
        //build class instance with the passed parameters
        return $this->_containerCreate->buildClassInstance( RegisterSidebar::class, $sidebar_config, DIException::class );
    }
    
    /**
     *
     * return the CreateSidebar class instance
     *
     * @return ICreateDynamicSidebars - CreateDynamicSidebar instance
     * @since     1.0.0
     */
    public function getCreateDynamicSidebarsInstance() : ICreateDynamicSidebars {
        
        //build class instance with the passed parameters
        return $this->_containerCreate->buildClassInstance( CreateDynamicSidebars::class, [], DIException::class );
    }
    
}