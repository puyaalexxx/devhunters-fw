<?php
declare(strict_types=1);

namespace DHT\Helpers\Exceptions\DIExceptions;

if (!defined('DHT_MAIN')) die('Forbidden');

use DHT\Helpers\Exceptions\BaseException;
use Throwable;

/**
 *
 * Custom class exception for Options class container instantiation
 */
class DIOptionsException extends BaseException
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