<?php
declare( strict_types = 1 );

// Enqueue scripts and styles for the media uploader
use function DHT\fw;
use function DHT\Helpers\dht_get_variables_from_file;

//remove sortable from the jquery ui as it comes from wordpress already

// field - datepicker_sortable

/*add_action( 'admin_enqueue_scripts', 'datepicker_sortable' );
function datepicker_sortable() {
    
    wp_register_style( 'dht-jquery-ui-css', DHT_ASSETS_URI . 'styles/libraries/jquery-ui.min.css', array(), fw()->manifest->get('version') );
    wp_enqueue_style( 'dht-jquery-ui-css' );
    
    wp_enqueue_script( 'dht-jquery-ui', DHT_ASSETS_URI . 'scripts/libraries/jquery-ui.min.js', array(), fw()->manifest->get('version'), true );
}*/

// field - timepicker_sortable

/*add_action( 'admin_enqueue_scripts', 'timepicker' );
function timepicker() {
    
    wp_register_style( 'dht-jquery-ui-timepicker-css', DHT_ASSETS_URI . 'styles/libraries/jquery-ui-timepicker-addon.min.css', array(), fw()->manifest->get('version') );
    wp_enqueue_style( 'dht-jquery-ui-timepicker-css' );
    
    wp_enqueue_script( 'dht-jquery-ui-timepicker', DHT_ASSETS_URI . 'scripts/libraries/jquery-ui-timepicker-addon.min.js', array( 'dht-jquery-ui' ), fw()->manifest->get('version'), true );
}*/

// field - multioptions
/*
add_action( 'admin_enqueue_scripts', 'multioptions' );
function multioptions() {
    
    wp_register_style( 'dht-select2-css', DHT_ASSETS_URI . 'styles/libraries/select2.min.css', array(), fw()->manifest->get('version') );
    wp_enqueue_style( 'dht-select2-css' );
    
    wp_enqueue_script( 'dht-select2-script', DHT_ASSETS_URI . 'scripts/libraries/select2.min.js', array(), fw()->manifest->get('version'), true );
    
    //wp_localize_script( 'dht-select2-ajax', 'dht_select2_ajax', array( 'ajax_url' => admin_url( 'admin-ajax.php' ) ) );
    
}*/

function multioptions_ajax_values(){
    
    if(isset($_POST['term'])){
        $term = $_POST['term']; // Get the search term from AJAX request
        
        // Query data based on the search term
        // Example: Query posts with titles containing the search term
        $args = array(
            'post_type' => 'post',
            's' => $term
        );
        $query = new WP_Query($args);
        
        $results = array();
        
        // Loop through query results and add to $results array
        if ($query->have_posts()) {
            while ($query->have_posts()) {
                $query->the_post();
                $results[] = array(
                    'id' => get_the_ID(),
                    'text' => get_the_title()
                );
            }
            wp_reset_postdata();
        }
        
        wp_send_json($results); // Send JSON response
    }
    
    die();
}
//ajax actions to remove sidebars
add_action( 'wp_ajax_multioptions_ajax_values', 'multioptions_ajax_values' );
add_action( 'wp_ajax_nopriv_multioptions_ajax_values', 'multioptions_ajax_values' ); // For non-logged in users

//icons
function icons() {
    // Enqueue Thickbox script
    wp_enqueue_script('thickbox');
    
    // Enqueue Thickbox stylesheet
    wp_enqueue_style('thickbox');
    
    wp_register_style( 'dht-font-awesome-css', DHT_ASSETS_URI . 'styles/libraries/fontawesome-icons.min.css', array(), fw()->manifest->get('version') );
    wp_enqueue_style( 'dht-font-awesome-css' );
    
    wp_register_style( 'dht-divi-icons-css', DHT_ASSETS_URI . 'styles/libraries/divi-icons.min.css', array(), fw()->manifest->get('version') );
    wp_enqueue_style( 'dht-divi-icons-css' );
    
    wp_register_style( 'dht-elusive-icons-css', DHT_ASSETS_URI . 'styles/libraries/elusive-icons.min.css', array(), fw()->manifest->get('version') );
    wp_enqueue_style( 'dht-elusive-icons-css' );
    
    wp_register_style( 'dht-line-icons-css', DHT_ASSETS_URI . 'styles/libraries/line-icons.min.css', array(), fw()->manifest->get('version') );
    wp_enqueue_style( 'dht-line-icons-css' );
    
    wp_register_style( 'dht-devicon-icons-css', DHT_ASSETS_URI . 'styles/libraries/devicon-icons.min.css', array(), fw()->manifest->get('version') );
    wp_enqueue_style( 'dht-devicon-icons-css' );
    
    wp_register_style( 'dht-bootstrap-icons-css', DHT_ASSETS_URI . 'styles/libraries/bootstrap-icons.min.css', array(), fw()->manifest->get('version') );
    wp_enqueue_style( 'dht-bootstrap-icons-css' );

}
add_action('admin_enqueue_scripts', 'icons');

function getIcons() : void {
    
    if ( isset( $_POST[ 'data' ] ) && isset($_POST['data']['icon_type'])) {
        //retrieve icon type
        $icon_type = $_POST['data']['icon_type'];
        
        $icons = [];
        $icon_templates = '';
        
        if ($icon_type == 'dashicons'){
            $icons = dht_get_variables_from_file(DHT_OPTIONS_DIR . 'options/icons/dashicons.php', 'dashicons');
        }
        
        if ($icon_type == 'fontawesome'){
            $icons = dht_get_variables_from_file(DHT_OPTIONS_DIR . 'options/icons/font-awesome.php', 'font_awesome_icons');
        }
        
        if ($icon_type == 'divi'){
            $icons = dht_get_variables_from_file(DHT_OPTIONS_DIR . 'options/icons/divi.php', 'divi_icons');
        }
        
        if ($icon_type == 'elusive'){
            $icons = dht_get_variables_from_file(DHT_OPTIONS_DIR . 'options/icons/elusive.php', 'elusive_icons');
        }
        
        if ($icon_type == 'line'){
            $icons = dht_get_variables_from_file(DHT_OPTIONS_DIR . 'options/icons/line.php', 'line_icons');
        }
        
        if ($icon_type == 'dev'){
            $icons = dht_get_variables_from_file(DHT_OPTIONS_DIR . 'options/icons/devicon.php', 'devicon_icons');
        }
        
        if ($icon_type == 'bootstrap'){
            $icons = dht_get_variables_from_file(DHT_OPTIONS_DIR . 'options/icons/bootstrap.php', 'bootstrap_icons');
        }
        
        if(!empty($icons)){
            ob_start();
            
                foreach($icons as $icon_class => $icon_code){
                    echo '<i class="'.$icon_class.'" data-code="'.$icon_code.'"></i>';
                }
            
            $icon_templates = ob_get_clean();
        }
        else{
            $icon_templates = 'No icons provided';
        }
        
        wp_send_json_success($icon_templates);
        
        die();
    }
}
add_action( 'wp_ajax_getIcons', 'getIcons' );
add_action( 'wp_ajax_nopriv_getIcons', 'getIcons' ); // For non-logged in users