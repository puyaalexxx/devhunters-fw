<?php
declare( strict_types = 1 );

namespace DHT\Extensions\Options\Groups;

use function DHT\Helpers\dht_load_view;

if ( !defined( 'DHT_MAIN' ) ) die( 'Forbidden' );

abstract class BaseGroup {
    
    //options templates directory
    protected string $template_dir = DHT_TEMPLATES_DIR . 'extensions/groups/';
    
    //field type
    protected string $_group = 'unknown';
    
    /**
     * @since     1.0.0
     */
    public function __construct() {}
    
    /**
     * Enqueue the option scripts and css files hook
     *
     * @param array $option
     *
     * @return void
     * @since     1.0.0
     */
    public function enqueueOptionScriptsHook( array $option ) : void {
        
        add_action( 'admin_enqueue_scripts', function () use ( $option ) {
            
            $this->enqueueOptionScripts( $option );
            
        } );
    }
    
    /**
     * Enqueue the option scripts and css files
     *
     * @param array $option
     *
     * @return void
     * @since     1.0.0
     */
    protected abstract function enqueueOptionScripts( array $option ) : void;
    
    /**
     * return group template
     *
     * @param array  $group
     * @param mixed  $saved_value
     * @param string $prefix_id
     * @param array  $registered_options
     * @param array  $additional_args
     *
     * @return string
     * @since     1.0.0
     */
    public function render( array $group, mixed $saved_value, string $prefix_id, array $registered_options, array $additional_args = [] ) : string {
        
        //add option prefix id
        $group = $this->addIDPrefix( $group, $prefix_id );
        
        return dht_load_view( $this->template_dir, $this->getGroup() . '.php', [
            'group' => $group,
            'saved_value' => $saved_value,
            'registered_options' => $registered_options,
            'additional_args' => []
        ] );
    }
    
    /**
     *
     * return field type
     *
     * @return string
     * @since     1.0.0
     */
    public function getGroup() : string {
        
        return $this->_group;
    }
    
    /**
     * add prefix id for the group id to display it in the form as array values
     * (used to retrieve the $_POST['prefix_id'] values)
     *
     * @param array  $group
     * @param string $prefix_id
     *
     * @return array
     * @since     1.0.0
     */
    public function addIDPrefix( array $group, string $prefix_id ) : array {
        
        if ( empty( $prefix_id ) ) return $group;
        
        $group[ 'id' ] = $prefix_id . '[' . $group[ 'id' ] . ']';
        
        return $group;
    }
    
}