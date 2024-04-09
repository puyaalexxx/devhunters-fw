<?php
declare(strict_types=1);

namespace DHT\Helpers\Exceptions;

use Throwable;

/**
 *
 * Custom class exception for ContainerBuilder class container instantiation
 */
class DIContainerException extends BaseException
{
    public function __construct($message, $code = 0, Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
    
    public function __toString()
    {
        return __CLASS__ . ": [{$this->code}]: {$this->message}\n";
    }
}