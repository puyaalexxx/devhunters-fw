<?php
declare(strict_types=1);

namespace DHT\Helpers;

use DI\Container;

/**
 *
 * check if array key exist and if it is empty
 *
 * @param array $array - array to be checked
 * @param string $array_key - array key
 * @return void
 */
function dht_array_key_exists(array $array, string $array_key) : bool{
    if(array_key_exists($array_key, $array) && !empty($array[$array_key]))
    {
        return false;
    }
    
    return true;
}

/**
 *
 * return an instance of the container if the validation passed , null otherwise
 *
 * @param object $container_instance - container instance
 * @param array $configurations - plugin configurations
 * @param string $config_name - name of the configuration that is checked
 * @return ?Container
 */
function dht_validate_container(object $container_instance, array $configurations, string $config_name) : ?object{
    
    if(!empty($configurations[$config_name])) {
        return $container_instance->getDashMenuPageInstance($configurations[$config_name]);
    }
    
    return null;
}

