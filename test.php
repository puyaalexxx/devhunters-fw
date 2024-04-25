<?php
declare( strict_types = 1 );

// Enqueue scripts and styles for the media uploader
function enqueue_media_uploader() {
    // Enqueue the media uploader script
    wp_enqueue_media();
}
add_action('admin_enqueue_scripts', 'enqueue_media_uploader');


// field - colorpicker - opacity
add_action( 'admin_enqueue_scripts', 'alpha_picker' );
function alpha_picker() {
    wp_enqueue_style( 'wp-color-picker' );
    wp_enqueue_script( 'wp-color-picker' );
    
    wp_enqueue_script( 'wp-color-picker-alpha', DHT_ASSETS_URI . 'scripts/libraries/wp-color-picker-alpha.min.js', array( 'wp-color-picker' ) );
    /*wp_add_inline_script(
        'wp-color-picker-alpha',
        'jQuery( function() { jQuery( ".dht-alphacolorpicker" ).wpColorPicker(); } );'
    );*/
    
}


// field - datepicker_sortable
add_action( 'admin_enqueue_scripts', 'datepicker_sortable' );
function datepicker_sortable() {
    
    wp_register_style( 'dht-jquery-ui-css', DHT_ASSETS_URI . 'styles/libraries/jquery-ui.min.css', array(), '1.0' );
    wp_enqueue_style( 'dht-jquery-ui-css' );
    
    wp_enqueue_script( 'dht-jquery-ui', DHT_ASSETS_URI . 'scripts/libraries/jquery-ui.min.js', array(), '1.0', true );
}

// field - timepicker_sortable
add_action( 'admin_enqueue_scripts', 'timepicker' );
function timepicker() {
    
    wp_register_style( 'dht-jquery-ui-timepicker-css', DHT_ASSETS_URI . 'styles/libraries/jquery-ui-timepicker-addon.min.css', array(), '1.0' );
    wp_enqueue_style( 'dht-jquery-ui-timepicker-css' );
    
    wp_enqueue_script( 'dht-jquery-ui-timepicker', DHT_ASSETS_URI . 'scripts/libraries/jquery-ui-timepicker-addon.min.js', array( 'dht-jquery-ui' ), '1.0', true );
}

// field - multioptions
add_action( 'admin_enqueue_scripts', 'multioptions' );
function multioptions() {
    
    wp_register_style( 'dht-select2-css', DHT_ASSETS_URI . 'styles/libraries/select2.min.css', array(), '1.0' );
    wp_enqueue_style( 'dht-select2-css' );
    
    wp_enqueue_script( 'dht-select2-script', DHT_ASSETS_URI . 'scripts/libraries/select2.min.js', array(), '1.0', true );
    
    //wp_localize_script( 'dht-select2-ajax', 'dht_select2_ajax', array( 'ajax_url' => admin_url( 'admin-ajax.php' ) ) );
    
}

function multioptions_ajax_values(){
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
//ajax actions to remove sidebars
add_action( 'wp_ajax_multioptions_ajax_values', 'multioptions_ajax_values' );
add_action( 'wp_ajax_nopriv_multioptions_ajax_values', 'multioptions_ajax_values' ); // For non-logged in users