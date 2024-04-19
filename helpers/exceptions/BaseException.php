<?php
declare( strict_types = 1 );

namespace DHT\Helpers\Exceptions;

if ( !defined( 'DHT_MAIN' ) ) die( 'Forbidden' );

use Exception;
use Throwable;

abstract class BaseException extends Exception {
    
    /**
     * Redefine the exception so message isn't optional
     *
     * @param                $message
     * @param                $code
     * @param Throwable|null $previous
     *
     * @since     1.0.0
     */
    public function __construct( $message, $code = 0, Throwable $previous = null ) {
        
        // make sure everything is assigned properly
        parent::__construct( $message, $code, $previous );
    }
    
    /**
     * custom string representation of object
     *
     * @return string
     * @since     1.0.0
     */
    public function __toString() {
        
        return __CLASS__ . ": [{$this->code}]: {$this->message}\n";
    }
    
}