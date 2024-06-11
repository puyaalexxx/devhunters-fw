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
        
        //merge default values with saved ones to display the saved ones
        $group = $this->mergeValues( $group, $saved_value );
        
        //add option prefix id
        $group = $this->addIDPrefix( $group, $prefix_id );
        
        return dht_load_view( $this->template_dir, $this->getGroup() . '.php', [
            'group' => $group,
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
    
    /**
     * merge the field value with the saved value if exists
     *
     * @param array $group       - group field
     * @param mixed $saved_value - saved values
     *
     * @return mixed
     * @since     1.0.0
     */
    public function mergeValues( array $group, mixed $saved_value ) : array {
        
        $group[ 'value' ] = empty( $saved_value ) ? $group[ 'value' ] : $saved_value;
        
        return $group;
    }
    
    /**
     *  In this method you receive $option_value (from form submit or whatever)
     *  and must return correct and safe value that will be stored in database.
     *
     *  $group_value can be null.
     *  In this case you should return default value from $group['value']
     *
     * @param array $group - group field
     * @param mixed $group_value
     * @param array $option_classes
     *
     * @return mixed - changed option value
     * @since     1.0.0
     */
    public function saveValue( array $group, mixed $group_value, array $option_classes ) : mixed {
        
        if ( empty( $group_value ) ) {
            return $group[ 'value' ];
        }
        
        //sanitize option values
        foreach ( $group[ 'options' ] as $subgroup ) {
            
            foreach ( $subgroup[ 'options' ] as $option ) {
                
                $saved_value = $group_value[ $option[ 'id' ] ] ?? [];
                
                $group_value[ $option[ 'id' ] ] = $option_classes[ $option[ 'type' ] ]->saveValue( $option, $saved_value );
            }
        }
        
        return $group_value;
    }
    
}