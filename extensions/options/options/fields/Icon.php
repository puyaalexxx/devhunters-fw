<?php
declare( strict_types = 1 );

namespace DHT\Extensions\Options\Options\fields;

use DHT\Extensions\Options\Options\BaseOption;
use function DHT\fw;
use function DHT\Helpers\dht_get_variables_from_file;

if ( !defined( 'DHT_MAIN' ) ) die( 'Forbidden' );

final class Icon extends BaseOption {
    
    //field type
    protected string $_field = 'icon';
    
    /**
     * @since     1.0.0
     */
    public function __construct() {
        
        parent::__construct();
        
        add_action( 'wp_ajax_get_option_icons', [ $this, 'get_option_icons' ] );
        add_action( 'wp_ajax_nopriv_get_option_icons', [ $this, 'get_option_icons' ] ); // For non-logged in users
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
        
        // Enqueue Thickbox script
        wp_enqueue_script( 'thickbox' );
        // Enqueue Thickbox stylesheet
        wp_enqueue_style( 'thickbox' );
        
        wp_register_style( DHT_PREFIX . '-font-awesome-css', DHT_ASSETS_URI . 'styles/libraries/fontawesome-icons.min.css', array(), fw()->manifest->get( 'version' ) );
        wp_enqueue_style( 'dht-font-awesome-css' );
        
        wp_register_style( DHT_PREFIX . '-divi-icons-css', DHT_ASSETS_URI . 'styles/libraries/divi-icons.min.css', array(), fw()->manifest->get( 'version' ) );
        wp_enqueue_style( DHT_PREFIX . '-divi-icons-css' );
        
        wp_register_style( DHT_PREFIX . '-elusive-icons-css', DHT_ASSETS_URI . 'styles/libraries/elusive-icons.min.css', array(), fw()->manifest->get( 'version' ) );
        wp_enqueue_style( DHT_PREFIX . '-elusive-icons-css' );
        
        wp_register_style( DHT_PREFIX . '-line-icons-css', DHT_ASSETS_URI . 'styles/libraries/line-icons.min.css', array(), fw()->manifest->get( 'version' ) );
        wp_enqueue_style( DHT_PREFIX . '-line-icons-css' );
        
        wp_register_style( DHT_PREFIX . '-devicon-icons-css', DHT_ASSETS_URI . 'styles/libraries/devicon-icons.min.css', array(), fw()->manifest->get( 'version' ) );
        wp_enqueue_style( DHT_PREFIX . '-devicon-icons-css' );
        
        wp_register_style( DHT_PREFIX . '-bootstrap-icons-css', DHT_ASSETS_URI . 'styles/libraries/bootstrap-icons.min.css', array(), fw()->manifest->get( 'version' ) );
        wp_enqueue_style( DHT_PREFIX . '-bootstrap-icons-css' );
        
        // Register custom style
        wp_register_style( DHT_PREFIX . '-icon-option', DHT_ASSETS_URI . 'styles/css/extensions/options/options/icon-style.css', array(), fw()->manifest->get( 'version' ) );
        wp_enqueue_style( DHT_PREFIX . '-icon-option' );
        
        //custom option script
        wp_enqueue_script( DHT_PREFIX . '-icon-option', DHT_ASSETS_URI . 'scripts/js/extensions/options/options/icon-script.js', array( 'jquery' ), fw()->manifest->get( 'version' ), true );
        wp_localize_script( DHT_PREFIX . '-icon-option', 'dht_icon_option_ajax', array( 'ajax_url' => admin_url( 'admin-ajax.php' ) ) );
    }
    
    public function get_option_icons() : void {
        
        if ( isset( $_POST[ 'data' ][ 'icon_type' ] ) ) {
            
            //retrieve icon type
            $icon_type = $_POST[ 'data' ][ 'icon_type' ];
            $icon = !empty( $_POST[ 'data' ][ 'icon' ] ) ? $_POST[ 'data' ][ 'icon' ] : '';
            
            $icons = [];
            
            if ( $icon_type == 'dashicons' ) {
                $icons = dht_get_variables_from_file( DHT_OPTIONS_DIR . 'options/fields/icons/dashicons.php', 'dashicons' );
            }
            
            if ( $icon_type == 'fontawesome' ) {
                $icons = dht_get_variables_from_file( DHT_OPTIONS_DIR . 'options/fields/icons/font-awesome.php', 'font_awesome_icons' );
            }
            
            if ( $icon_type == 'divi' ) {
                $icons = dht_get_variables_from_file( DHT_OPTIONS_DIR . 'options/fields/icons/divi.php', 'divi_icons' );
            }
            
            if ( $icon_type == 'elusive' ) {
                $icons = dht_get_variables_from_file( DHT_OPTIONS_DIR . 'options/fields/icons/elusive.php', 'elusive_icons' );
            }
            
            if ( $icon_type == 'line' ) {
                $icons = dht_get_variables_from_file( DHT_OPTIONS_DIR . 'options/fields/icons/line.php', 'line_icons' );
            }
            
            if ( $icon_type == 'dev' ) {
                $icons = dht_get_variables_from_file( DHT_OPTIONS_DIR . 'options/fields/icons/devicon.php', 'devicon_icons' );
            }
            
            if ( $icon_type == 'bootstrap' ) {
                $icons = dht_get_variables_from_file( DHT_OPTIONS_DIR . 'options/fields/icons/bootstrap.php', 'bootstrap_icons' );
            }
            
            if ( !empty( $icons ) ) {
                
                ob_start();
                
                foreach ( $icons as $icon_class => $icon_code ) {
                    
                    //set active icon
                    $active_icon = $icon == $icon_class ? 'dht-active-icon="true"' : '';
                    
                    echo '<i class="' . $icon_class . '" data-code="' . $icon_code . '" ' . $active_icon . ' ></i>';
                }
                
                $icon_templates = ob_get_clean();
                
            } else {
                
                $icon_templates = _x( 'No icons provided for this icon type', 'options', DHT_PREFIX );
            }
            
            wp_send_json_success( $icon_templates );
            
            die();
        }
    }
    
    /**
     * add prefix id for option id to display it in the form as array values
     * (used to retrieve the $_POST['prefix_id'] values)
     *
     * @param array  $option
     * @param string $prefix_id
     *
     * @return array
     * @since     1.0.0
     */
    public function addIDPrefix( array $option, string $prefix_id ) : array {
        
        if ( empty( $prefix_id ) ) return $option;
        
        $option[ 'name' ] = $prefix_id . '[' . $option[ 'id' ] . ']';
        $option[ 'id' ] = str_replace( [ '[', ']' ], '-', $prefix_id . '-' . $option[ 'id' ] );
        
        return $option;
    }
    
    /**
     *  In this method you receive $option_post_value (from form submit or whatever)
     *  and must return correct and safe value that will be stored in database.
     *
     *  $option_post_value can be null.
     *  In this case you should return default value from $option['value']
     *
     * @param array $option            - option field
     * @param mixed $option_post_value - option $_POST value passed on save
     *
     * @return mixed - changed option value
     * @since     1.0.0
     */
    public function saveValue( array $option, mixed $option_post_value ) : mixed {
        
        if ( empty( $option_post_value ) ) {
            return $option[ 'value' ];
        }
        
        return (array)json_decode( stripslashes( $option_post_value ) );
    }
    
}
