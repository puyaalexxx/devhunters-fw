<?php

namespace DHT\Extensions\CPT;

if ( !defined( 'DHT_MAIN' ) ) die( 'Forbidden' );

/**
 *
 * Interface  that is used for the CPT.
 * used for return types to not couple the code to the actual class
 */
interface ICPT {
    
    /**
     * create custom post types by receiving the plugin configurations
     *
     * @param array $cpt_config
     *
     * @return void
     * @since     1.0.0
     */
    public function registerCPT( array $cpt_config ) : void;
}