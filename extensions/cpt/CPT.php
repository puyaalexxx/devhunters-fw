<?php
declare(strict_types=1);

namespace DHT\Extensions\CPT;

/**
 *
 * Class that is used to register custom post types and taxonomies
 */
class CPT implements ICPT
{
    private array $_cptConfig;
    
    /**
     * @param array $cpt_config - injected config values from DI container
     */
    public function __construct(array $cpt_config)
    {
        
        $this->_cptConfig = apply_filters('cpt_configurations', $cpt_config);
        
        //dht_print_r($this->_cptConfig);
        
        // add_action('init', 'registerTaxonomy');
        
        //add_action('init', 'registerPostTypes');
    }
    
    /**
     *
     * Interface  that is used for the DashMenuPage.
     * Marker Interface - used for return types to not couple the code to the actual class
     */
    public function registerPostTypes(): void
    {
        
        register_post_type('bloghunter', []);
    }
    
    
    /**
     *
     * Interface  that is used for the DashMenuPage.
     * Marker Interface - used for return types to not couple the code to the actual class
     */
    public function registerTaxonomy(): void
    {
        
        
        register_taxonomy(
            'bloghunter_taxonomy',
            'bloghunter',
            []
        );
    }
}