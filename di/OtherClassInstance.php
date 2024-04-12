<?php

namespace DHT\DI;

class OtherClassInstance
{
    private ContainerCreate $_containerCreate;
    
    public function __construct(ContainerCreate $_containerCreate)
    {
        $this->_containerCreate = $_containerCreate;
    }
}