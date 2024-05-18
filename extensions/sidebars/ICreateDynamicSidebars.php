<?php

namespace DHT\Extensions\Sidebars;

/**
 * Interface  that is used for the CreateSidebar class.
 */
interface ICreateDynamicSidebars {
    
    /**
     * enable dynamic sidebars feature
     *
     * @return void
     * @since     1.0.0
     */
    public function enable() : void;
    
}