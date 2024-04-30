<?php
declare( strict_types = 1 );

namespace DHT\Extensions\Options\Options;

if ( !defined( 'DHT_MAIN' ) ) die( 'Forbidden' );

interface IOption {
    
    public function getOption( $option );
    
    public function saveOption( $option );
    
    public function getView();
}