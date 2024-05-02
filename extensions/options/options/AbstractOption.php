<?php
declare( strict_types = 1 );

namespace DHT\Extensions\Options\Options;

if ( !defined( 'DHT_MAIN' ) ) die( 'Forbidden' );

abstract class AbstractOption {
    
    //options templates directory
    protected string $template_dir = DHT_TEMPLATES_DIR . 'options/';
    
    //field type
    protected string $_field = 'unknown';
    
    /**
     *
     * return option type
     **
     * @return string
     * @since     1.0.0
     */
    public abstract function getField() : string;
    
    /**
     *
     * return option template
     *
     * @param array $option
     *
     * @return string
     * @since     1.0.0
     */
    public abstract function getTemplate(array $option) : string;
    
}