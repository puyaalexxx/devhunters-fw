<?php
declare( strict_types = 1 );

namespace DHT\Helpers\Config;

use function DHT\Helpers\dht_get_variables_from_file;
use function DHT\Helpers\dht_print_r;

if ( !defined( 'DHT_MAIN' ) ) die( 'Forbidden' );

class Config {
    
    /**
     *
     * include all the configuration files from the plugin/src/config folder
     * or specific configurations from a specific config file
     *
     * @param $config_name - configuration to be retrieved
     *
     * @return array of configurations from all the files
     * @since     1.0.0
     */
    public static function get_plugin_configurations( string $config_name = '' ) : array {
        
        return match ( $config_name ) {
            'menu_pages' => [ 'menu_pages' => self::get_configurations_by_name( PPHT_CONFIG_DIR . 'extensions/dashmenus.php', 'dashmenus' ) ],
            'cpt' => [ 'cpt' => self::get_configurations_by_name( PPHT_CONFIG_DIR . 'extensions/cpt.php', 'cpt_config' ) ],
            'sidebars' => [ 'sidebars' => self::get_configurations_by_name( PPHT_CONFIG_DIR . 'extensions/sidebars.php', 'sidebars' ) ],
            'options' => self::get_options_configurations(),
            //if no option specified, retrieve nothing
            default => [
                'menu_pages' => [],
                'cpt' => [],
                'sidebars' => [],
                'options' => [],
            ],
        };
    }
    
    /**
     *
     * get specific plugin configurations
     *
     * @param string $file_path - file from where to get the configurations
     * @param string $conf_name - configuration name that you want to extract
     *
     * @return array of dashboard menu configurations
     * @since     1.0.0
     */
    public static function get_configurations_by_name( string $file_path, string $conf_name ) : array {
        
        return dht_get_variables_from_file( $file_path, $conf_name );
    }
    
    /**
     *
     * get options types from specific areas (config/options folder)
     *
     * @param string $path      - get specific configuration directly from this path
     * @param string $conf_name - get specific configuration directly with this name
     *
     * @return array of dashboard menu configurations
     * @since     1.0.0
     */
    public static function get_options_configurations( string $path = '', string $conf_name = '' ) : array {
        
        $options = [];
        
        if ( !empty( $path ) && !empty( $conf_name ) ) return self::get_configurations_by_name( $path, $conf_name );
        
        $options = self::get_configurations_by_name( PPHT_CONFIG_DIR . 'extensions/options/dashmenus/ppht-general-settings.php', 'options' );
        
        dht_print_r( $options );
        
        /*//if it is a WordPress page
        if ( isset( $_GET[ 'page' ] ) ) {
            
            //main (general) page settings
            if ( ( $_GET[ 'page' ] === PPHT_PREFIX . '-general-settings' ) || ( $_GET[ 'page' ] === PPHT_PREFIX . '-main-settings' ) ) {
                
                $options = self::get_configurations_by_name( PPHT_CONFIG_DIR . 'extensions/options/dashboard-pages/general-settings.php', 'options' );
                
            } //text module page settings
            elseif ( $_GET[ 'page' ] === PPHT_PREFIX . '-text-module-settings' ) {
                
                $options = self::get_configurations_by_name( PPHT_CONFIG_DIR . 'extensions/options/dashboard-pages/text-module-settings.php', 'options' );
            }
            
        }*/
        
        return $options;
    }
    
}