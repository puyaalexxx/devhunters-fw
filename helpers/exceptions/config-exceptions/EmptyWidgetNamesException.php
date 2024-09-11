<?php
declare( strict_types = 1 );

namespace DHT\Helpers\Exceptions\ConfigExceptions;

if( !defined( 'DHT_MAIN' ) ) die( 'Forbidden' );

use DHT\Helpers\Exceptions\BaseException;
use Throwable;

/**
 *
 * Custom class exception thrown when the custom post types configuration array is empty
 */
class EmptyWidgetNamesException extends BaseException {
    
    /**
     * @param                $message
     * @param                $code
     * @param Throwable|null $previous
     *
     * @since     1.0.0
     */
    public function __construct( $message, $code = 0, Throwable $previous = NULL ) {
        
        parent::__construct( $message, $code, $previous );
    }
    
    /**
     * @return string
     * @since     1.0.0
     */
    public function __toString() {
        
        return __CLASS__ . ": [{$this->code}]: {$this->message}\n";
    }
    
}