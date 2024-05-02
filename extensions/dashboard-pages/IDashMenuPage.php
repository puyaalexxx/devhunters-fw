<?php
declare( strict_types = 1 );

namespace DHT\Extensions\DashPages;

if ( !defined( 'DHT_MAIN' ) ) die( 'Forbidden' );

/**
 *
 * Interface  that is used for the DashMenuPage.
 * used for return types to not couple the code to the actual class
 */
interface IDashMenuPage {
    
    /**
     *
     * create the dashboard menu items and submenu items by receiving the plugin configurations
     *
     * @param array $dash_menus_config
     *
     * @return void
     * @since     1.0.0
     */
    public function registerDashboardMenuPages( array $dash_menus_config ) : void;
    
}