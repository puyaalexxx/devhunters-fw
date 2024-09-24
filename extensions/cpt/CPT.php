<?php
declare( strict_types = 1 );

namespace DHT\Extensions\CPT;

if ( ! defined( 'DHT_MAIN' ) ) {
	die( 'Forbidden' );
}

/**
 *
 * Class that is used to register custom post types and taxonomies
 */
final class CPT implements ICPT {
	
	//extension name
	public string $ext_name = 'cpts';
	
	//config array
	private array $_cpt_config;
	
	/**
	 * @param array $cpt_config
	 *
	 * @since     1.0.0
	 */
	public function __construct( array $cpt_config ) {
		$this->_cpt_config = $cpt_config;
	}
	
	/**
	 * External Method
	 * register custom post types by receiving the plugin configurations
	 *
	 * @return void
	 * @since     1.0.0
	 */
	public function create() : void {
		
		//register posts types if exist
		if ( isset( $this->_cpt_config[ 'post_types' ] ) ) {
			add_action( 'init', function() {
				$this->registerPostTypes( $this->_cpt_config[ 'post_types' ] );
			} );
		}
		
		//register taxonomies if exist
		if ( isset( $this->_cpt_config[ 'taxonomies' ] ) ) {
			add_action( 'init', function() {
				$this->registerTaxonomy( $this->_cpt_config[ 'taxonomies' ] );
			} );
		}
	}
	
	/**
	 * Register the post type
	 *
	 * @param array $post_types_args - post type arguments to register
	 *
	 * @return void
	 * @since     1.0.0
	 */
	public function registerPostTypes( array $post_types_args ) : void {
		
		if ( empty( $post_types_args ) ) {
			return;
		}
		
		foreach ( $post_types_args as $post_type => $post_type_args ) {
			
			if ( ! isset( $post_type_args[ 'args' ] ) ) {
				break;
			}
			
			register_post_type( $post_type, $post_type_args[ 'args' ] );
		}
	}
	
	/**
	 * Register Taxonomy
	 *
	 * @param array $taxonomies_args - taxonomy arguments to register
	 *
	 * @return void
	 * @since     1.0.0
	 */
	public function registerTaxonomy( array $taxonomies_args ) : void {
		
		if ( empty( $taxonomies_args ) ) {
			return;
		}
		
		foreach ( $taxonomies_args as $post_type => $taxonomies ) {
			
			foreach ( $taxonomies as $taxonomy_name => $taxonomy_args ) {
				
				register_taxonomy( $taxonomy_name, $post_type, $taxonomy_args );
			}
		}
	}
	
}