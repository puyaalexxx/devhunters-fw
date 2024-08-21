<?php
declare( strict_types = 1 );

namespace DHT\Extensions\Options\Groups\Groups;

use DHT\Extensions\Options\groups\BaseGroup;
use function DHT\fw;
use function DHT\Helpers\dht_load_view;

if ( !defined( 'DHT_MAIN' ) ) die( 'Forbidden' );

final class Toggle extends BaseGroup {
    
    //group type
    protected string $_group = 'toggle';
    
    /**
     * @since     1.0.0
     */
    public function __construct() {
        
        parent::__construct();
    }
    
    /**
     * Enqueue input scripts and styles
     *
     * @param array $group
     *
     * @return void
     * @since     1.0.0
     */
    public function enqueueOptionScripts( array $group ) : void {
        
        wp_register_style( DHT_PREFIX . '-toggle-group', DHT_ASSETS_URI . 'styles/css/extensions/options/groups/toggle-style.css', array(), fw()->manifest->get( 'version' ) );
        wp_enqueue_style( DHT_PREFIX . '-toggle-group' );
        
        wp_enqueue_script( DHT_PREFIX . '-toggle-group', DHT_ASSETS_URI . 'scripts/js/extensions/options/groups/toggle-script.js', array( 'jquery' ), fw()->manifest->get( 'version' ), true );
    }
    
    /**
     * return group template
     *
     * @param array  $group
     * @param mixed  $saved_values
     * @param string $prefix_id
     * @param array  $registered_options
     * @param array  $additional_args
     *
     * @return string
     * @since     1.0.0
     */
    public function render( array $group, mixed $saved_values, string $prefix_id, array $registered_options, array $additional_args = [] ) : string {
        
        //merge default values with saved ones to display the saved ones
        $group = $this->mergeValues( $group, $saved_values );
        
        //add option prefix id
        $group = parent::addIDPrefix( $group, $prefix_id );
        
        
        return dht_load_view( $this->template_dir, $this->getGroup() . '.php', [
            'group' => $group,
            'saved_values' => $saved_values,
            'registered_options' => $registered_options,
            'additional_args' => $additional_args
        ] );
    }
    
    /**
     * merge the group value with the saved values if exists
     *
     * @param array $group        - group field
     * @param mixed $saved_values - saved values
     *
     * @return mixed
     * @since     1.0.0
     */
    public function mergeValues( array $group, mixed $saved_values ) : array {
        
        $group[ 'value' ] = empty( $saved_values[ 'value' ] ) ? $group[ 'value' ] : $saved_values[ 'value' ];
        
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
        
        //local function to avoid repetition
        function sanitize_values( array $group, string $choice, array $group_post_values, array $option_classes ) : array {
            
            foreach ( $group[ $choice ][ 'options' ] as $option ) {
                
                $option_post_value = $group_post_values[ $choice ][ $option[ 'id' ] ] ?? [];
                
                $group_post_values[ $choice ][ $option[ 'id' ] ] = $option_classes[ $option[ 'type' ] ]->saveValue( $option, $option_post_value );
            }
            
            return $group_post_values;
        }
        
        //sanitize option values
        if ( !empty( $group[ 'left-choice' ][ 'options' ] ) ) {
            
            $group_post_values = sanitize_values( $group, 'left-choice', $group_post_values, $option_classes );
        }
        
        if ( !empty( $group[ 'right-choice' ][ 'options' ] ) ) {
            
            $group_post_values = sanitize_values( $group, 'right-choice', $group_post_values, $option_classes );
        }
        
        return $group_post_values;
    }
    
}
