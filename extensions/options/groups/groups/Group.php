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
     * @since     1.0.0
     */
    public function __construct() {
        
        parent::__construct();
    }
    
    /**
     * Enqueue input scripts and styles
     *
     * @param array $option
     *
     * @return void
     * @since     1.0.0
     */
    public function enqueueOptionScripts( array $option ) : void {
        
        wp_register_style( DHT_PREFIX . '-group-group', DHT_ASSETS_URI . 'styles/css/extensions/options/groups/group-style.css', array(), fw()->manifest->get( 'version' ) );
        wp_enqueue_style( DHT_PREFIX . '-group-group' );
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
        foreach ( $group[ 'options' ] as $option ) {
            
            $saved_value = $group_value[ $option[ 'id' ] ] ?? [];
            
            $group_value[ $option[ 'id' ] ] = $option_classes[ $option[ 'type' ] ]->saveValue( $option, $saved_value );
        }
        
        return $group_value;
    }
    
}
