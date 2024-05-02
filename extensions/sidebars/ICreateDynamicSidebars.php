<?php

namespace DHT\Extensions\Sidebars;

/**
 *
 * Interface  that is used for the CreateSidebar class.
 */
interface ICreateDynamicSidebars {
    
    /**
     * enable dynamic sidebars feature
     *
     * @param bool $createDynamicSidebars
     *
     * @return void
     * @since     1.0.0
     */
    public function enableDynamicSidebars( bool $createDynamicSidebars ) : void;
    
}