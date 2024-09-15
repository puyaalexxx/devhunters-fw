<?php
declare( strict_types = 1 );

namespace DHT\Helpers\Classes;

if( !defined( 'DHT_MAIN' ) ) die( 'Forbidden' );

class Environment {
    
    // Check if the environment is development
    public static function isDevelopment() : bool {
        
        return defined( 'DHT_FW_ENVIRONMENT' ) && DHT_FW_ENVIRONMENT === 'development';
    }
    
    // Check if the environment is production
    public static function isProduction() : bool {
        
        return defined( 'DHT_FW_ENVIRONMENT' ) && DHT_FW_ENVIRONMENT === 'production';
    }
    
}
