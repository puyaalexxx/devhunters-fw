<?php
declare(strict_types=1);

namespace DHT\DI;

if (!defined('DHT_MAIN')) die('Forbidden');

class OtherClassInstance
{
    private ContainerCreate $_containerCreate;
    
    public function __construct(ContainerCreate $_containerCreate)
    {
        $this->_containerCreate = $_containerCreate;
    }
}