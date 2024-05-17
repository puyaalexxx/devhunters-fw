<?php
declare( strict_types = 1 );

// Enqueue scripts and styles for the media uploader
use function DHT\fw;
use function DHT\Helpers\dht_get_variables_from_file;

//icons
function icons() {
    
    // Enqueue Thickbox script
    wp_enqueue_script( 'thickbox' );
    
    // Enqueue Thickbox stylesheet
    wp_enqueue_style( 'thickbox' );
    
    wp_register_style( 'dht-font-awesome-css', DHT_ASSETS_URI . 'styles/libraries/fontawesome-icons.min.css', array(), fw()->manifest->get( 'version' ) );
    wp_enqueue_style( 'dht-font-awesome-css' );
    
    wp_register_style( 'dht-divi-icons-css', DHT_ASSETS_URI . 'styles/libraries/divi-icons.min.css', array(), fw()->manifest->get( 'version' ) );
    wp_enqueue_style( 'dht-divi-icons-css' );
    
    wp_register_style( 'dht-elusive-icons-css', DHT_ASSETS_URI . 'styles/libraries/elusive-icons.min.css', array(), fw()->manifest->get( 'version' ) );
    wp_enqueue_style( 'dht-elusive-icons-css' );
    
    wp_register_style( 'dht-line-icons-css', DHT_ASSETS_URI . 'styles/libraries/line-icons.min.css', array(), fw()->manifest->get( 'version' ) );
    wp_enqueue_style( 'dht-line-icons-css' );
    
    wp_register_style( 'dht-devicon-icons-css', DHT_ASSETS_URI . 'styles/libraries/devicon-icons.min.css', array(), fw()->manifest->get( 'version' ) );
    wp_enqueue_style( 'dht-devicon-icons-css' );
    
    wp_register_style( 'dht-bootstrap-icons-css', DHT_ASSETS_URI . 'styles/libraries/bootstrap-icons.min.css', array(), fw()->manifest->get( 'version' ) );
    wp_enqueue_style( 'dht-bootstrap-icons-css' );
    
}

add_action( 'admin_enqueue_scripts', 'icons' );

function getIcons() : void {
    
    if ( isset( $_POST[ 'data' ] ) && isset( $_POST[ 'data' ][ 'icon_type' ] ) ) {
        //retrieve icon type
        $icon_type = $_POST[ 'data' ][ 'icon_type' ];
        
        $icons = [];
        $icon_templates = '';
        
        if ( $icon_type == 'dashicons' ) {
            $icons = dht_get_variables_from_file( DHT_OPTIONS_DIR . 'options/icons/dashicons.php', 'dashicons' );
        }
        
        if ( $icon_type == 'fontawesome' ) {
            $icons = dht_get_variables_from_file( DHT_OPTIONS_DIR . 'options/icons/font-awesome.php', 'font_awesome_icons' );
        }
        
        if ( $icon_type == 'divi' ) {
            $icons = dht_get_variables_from_file( DHT_OPTIONS_DIR . 'options/icons/divi.php', 'divi_icons' );
        }
        
        if ( $icon_type == 'elusive' ) {
            $icons = dht_get_variables_from_file( DHT_OPTIONS_DIR . 'options/icons/elusive.php', 'elusive_icons' );
        }
        
        if ( $icon_type == 'line' ) {
            $icons = dht_get_variables_from_file( DHT_OPTIONS_DIR . 'options/icons/line.php', 'line_icons' );
        }
        
        if ( $icon_type == 'dev' ) {
            $icons = dht_get_variables_from_file( DHT_OPTIONS_DIR . 'options/icons/devicon.php', 'devicon_icons' );
        }
        
        if ( $icon_type == 'bootstrap' ) {
            $icons = dht_get_variables_from_file( DHT_OPTIONS_DIR . 'options/icons/bootstrap.php', 'bootstrap_icons' );
        }
        
        if ( !empty( $icons ) ) {
            ob_start();
            
            foreach ( $icons as $icon_class => $icon_code ) {
                echo '<i class="' . $icon_class . '" data-code="' . $icon_code . '"></i>';
            }
            
            $icon_templates = ob_get_clean();
        } else {
            $icon_templates = 'No icons provided';
        }
        
        wp_send_json_success( $icon_templates );
        
        die();
    }
}

add_action( 'wp_ajax_getIcons', 'getIcons' );
add_action( 'wp_ajax_nopriv_getIcons', 'getIcons' ); // For non-logged in users