<?php
declare(strict_types=1);

namespace DHT\Extensions\CPT;

if (!defined('DHT_MAIN')) die('Forbidden');

/**
 *
 * Class that is used to register custom post types and taxonomies
 */
class CPT implements ICPT
{
    /**
     * @param array $cpt_config - injected config values from DI container
     */
    public function __construct(array $cpt_config)
    {
        $config_args = apply_filters('cpt_configurations', $cpt_config);
        
        //register posts types if exist
        if (isset($config_args['post_types'])) {
            add_action('init', function () use ($config_args) {
                $this->registerPostTypes($config_args['post_types']);
            });
        }
        
        //register taxonomies if exist
        if (isset($config_args['taxonomies'])) {
            add_action('init', function () use ($config_args) {
                $this->registerTaxonomy($config_args['taxonomies']);
            });
        }
    }
    
    /**
     *
     * Register the post type
     *
     * @param array $post_types_args - post type arguments to register
     * @return void
     */
    public function registerPostTypes(array $post_types_args): void
    {
        if (empty($post_types_args)) return;
        
        foreach ($post_types_args as $post_type => $post_type_args) {
            
            if (!isset($post_type_args['args'])) break;
            
            register_post_type($post_type, $post_type_args['args']);
        }
    }
    
    
    /**
     *
     * Register Taxonomy
     *
     * @param array $taxonomies_args - taxonomy arguments to register
     * @return void
     */
    public function registerTaxonomy(array $taxonomies_args): void
    {
        if (empty($taxonomies_args)) return;
        
        foreach ($taxonomies_args as $post_type => $taxonomies) {
            
            foreach ($taxonomies as $taxonomy_name => $taxonomy_args) {
                
                register_taxonomy($taxonomy_name, $post_type, $taxonomy_args);
            }
        }
    }
}