<?php
declare( strict_types = 1 );

namespace DHT\Extensions\CPT;

use DHT\Helpers\Exceptions\ConfigExceptions\EmptyCPTConfigurationsException;

if ( !defined( 'DHT_MAIN' ) ) die( 'Forbidden' );

/**
 *
 * Class that is used to register custom post types and taxonomies
 */
class CPT implements ICPT {
    
    /**
     * @since     1.0.0
     */
    public function __construct() {}
    
    /**
     * External Method
     * register custom post types by receiving the plugin configurations
     *
     * @param array $cpt_config
     *
     * @return void
     * @throws EmptyCPTConfigurationsException
     * @since     1.0.0
     */
    public function registerCPT( array $cpt_config ) : void {
        
        $config_args = $this->_validateCPTConfigurations( $cpt_config );
        
        //register posts types if exist
        if ( isset( $config_args[ 'post_types' ] ) ) {
            add_action( 'init', function () use ( $config_args ) {
                
                $this->registerPostTypes( $config_args[ 'post_types' ] );
            } );
        }
        
        //register taxonomies if exist
        if ( isset( $config_args[ 'taxonomies' ] ) ) {
            add_action( 'init', function () use ( $config_args ) {
                
                $this->registerTaxonomy( $config_args[ 'taxonomies' ] );
            } );
        }
    }
    
    /**
     *
     * Register the post type
     *
     * @param array $post_types_args - post type arguments to register
     *
     * @return void
     * @since     1.0.0
     */
    public function registerPostTypes( array $post_types_args ) : void {
        
        if ( empty( $post_types_args ) ) return;
        
        foreach ( $post_types_args as $post_type => $post_type_args ) {
            
            if ( !isset( $post_type_args[ 'args' ] ) ) break;
            
            register_post_type( $post_type, $post_type_args[ 'args' ] );
        }
    }
    
    
    /**
     *
     * Register Taxonomy
     *
     * @param array $taxonomies_args - taxonomy arguments to register
     *
     * @return void
     * @since     1.0.0
     */
    public function registerTaxonomy( array $taxonomies_args ) : void {
        
        if ( empty( $taxonomies_args ) ) return;
        
        foreach ( $taxonomies_args as $post_type => $taxonomies ) {
            
            foreach ( $taxonomies as $taxonomy_name => $taxonomy_args ) {
                
                register_taxonomy( $taxonomy_name, $post_type, $taxonomy_args );
            }
        }
    }
    
    /**
     *
     * validate the cpt configurations received from plugin
     *
     * @param array $cpt_config
     *
     * @return array
     * @throws EmptyCPTConfigurationsException
     * @since     1.0.0
     */
    private function _validateCPTConfigurations( array $cpt_config ) : array {
        
        if ( !empty( $cpt_config[ 'cpt' ] ) ) {
            
            return apply_filters( 'cpt_configurations', $cpt_config[ 'cpt' ] );
        } else {
            
            throw new EmptyCPTConfigurationsException( _x( 'Empty cpt configurations array provided', 'exceptions', DHT_PREFIX ) );
        }
    }
}