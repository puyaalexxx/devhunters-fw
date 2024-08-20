<?php
declare( strict_types = 1 );

namespace DHT\Extensions\Options\groups;

use function DHT\Helpers\dht_load_view;

if ( !defined( 'DHT_MAIN' ) ) die( 'Forbidden' );

abstract class BaseGroup {
    
    //options templates directory
    protected string $template_dir = DHT_TEMPLATES_DIR . 'extensions/options/groups/';
    
    //field type
    protected string $_group = 'unknown';
    
    /**
     * @since     1.0.0
     */
    public function __construct() {}
    
    /**
     *
     * return group type
     *
     * @return string
     * @since     1.0.0
     */
    public function getGroup() : string {
        
        return $this->_group;
    }
    
    /**
     * Method used to pass the $group array option to enqueue method (enqueueOptionScripts)
     * This is done to have access to the $group option inside the enqueue method
     *
     * @param array $group
     *
     * @return void
     * @since     1.0.0
     */
    public function enqueueOptionScriptsHook( array $group ) : void {
        
        add_action( 'admin_enqueue_scripts', function () use ( $group ) {
            
            $this->enqueueOptionScripts( $group );
            
        } );
    }
    
    /**
     * Enqueue the group scripts and css files
     *
     * @param array $group
     *
     * @return void
     * @since     1.0.0
     */
    protected abstract function enqueueOptionScripts( array $group ) : void;
    
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
            'additional_args' => $additional_args
        ] );
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
     * merge the group value with the saved value if exists
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
     *  In this method you receive $group_value (from form submit or whatever)
     *  and must return correct and safe value that will be stored in database.
     *
     *  $group_value can be null.
     *  In this case you should return default value from $group['value']
     *
     * @param array $group             - group field
     * @param mixed $group_post_values - $_POST values passed on save
     * @param array $option_classes
     *
     * @return mixed - changed group value
     * @since     1.0.0
     */
    public function saveValue( array $group, mixed $group_post_values, array $option_classes ) : mixed {
        
        if ( empty( $group_post_values ) ) {
            return $group[ 'value' ];
        }
        
        //sanitize option values
        foreach ( $group[ 'options' ] as $subgroup ) {
            
            foreach ( $subgroup[ 'options' ] as $option ) {
                
                $option_post_value = $group_post_values[ $option[ 'id' ] ] ?? [];
                
                $group_post_values[ $option[ 'id' ] ] = $option_classes[ $option[ 'type' ] ]->saveValue( $option, $option_post_value );
            }
        }
        
        return $group_post_values;
    }
    
}