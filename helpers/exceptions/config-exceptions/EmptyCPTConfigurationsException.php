<?php
declare(strict_types=1);

namespace DHT\Helpers\Exceptions\ConfigExceptions;

use DHT\Helpers\Exceptions\BaseException;
use Throwable;

/**
 *
 * Custom class exception thrown when the custom post types configuration array is empty
 */
class EmptyCPTConfigurationsException extends BaseException
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