<?php

namespace DHT\DI;

if (!defined('DHT_MAIN')) die('Forbidden');

/**
 * Class to initialise all the Classes that requires dependecy injections
 */
final class DIInit
{
    private ContainerCreate $_containerCreate;
    public ExtensionClassInstance $extensionClassInstance;
    public OtherClassInstance $otherClassInstance;
    
    public function __construct()
    {
        $this->_containerCreate = new ContainerCreate();
        
        //get all Extension classes instances
        $this->extensionClassInstance = new ExtensionClassInstance($this->_containerCreate);
        
        //a test class
        // $this->otherClassInstance = new OtherClassInstance($this->_containerCreate);
    }
}