<?php
declare(strict_types=1);

namespace DHT\Helpers\Exceptions;

use Throwable;

/**
 *
 * Custom class exception for DasMenuPage class container instantiation
 */
class DICPTException extends BaseException
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