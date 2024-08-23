<?php
declare( strict_types = 1 );

namespace DHT\Extensions\Options\Groups\Groups;

use DHT\Extensions\Options\Groups\BaseGroup;
use function DHT\fw;

if ( !defined( 'DHT_MAIN' ) ) die( 'Forbidden' );

final class Group extends BaseGroup {
    
    //group type
    protected string $_group = 'group';
    
    /**
     * @param array $registered_options
     *
     * @since     1.0.0
     */
    public function __construct( array $registered_options ) {
        
        parent::__construct( $registered_options );
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
        
        wp_register_style( DHT_PREFIX . '-group-group', DHT_ASSETS_URI . 'styles/css/extensions/options/groups/group-style.css', array(), fw()->manifest->get( 'version' ) );
        wp_enqueue_style( DHT_PREFIX . '-group-group' );
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
     *
     * @return mixed - changed group value
     * @since     1.0.0
     */
    public function saveValue( array $group, mixed $group_post_values ) : mixed {
        
        if ( empty( $group_post_values ) ) {
            return $group[ 'value' ];
        }
        
        //sanitize option values
        foreach ( $group[ 'options' ] as $option ) {
            
            $option_post_value = $group_post_values[ $option[ 'id' ] ] ?? [];
            
            $group_post_values[ $option[ 'id' ] ] = $this->_registeredOptions[ $option[ 'type' ] ]->saveValue( $option, $option_post_value );
        }
        
        return $group_post_values;
    }
    
}
