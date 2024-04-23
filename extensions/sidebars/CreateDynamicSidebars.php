<?php
declare( strict_types = 1 );

namespace DHT\Extensions\Sidebars;

if ( !defined( 'DHT_MAIN' ) ) die( 'Forbidden' );

/**
 *
 * Class that is used to create sidebars dynamically in widgets.php area
 */
class CreateDynamicSidebars implements ICreateDynamicSidebars {

    private array $_widget_areas = array();

    /**
     * @since     1.0.0
     */
    public function __construct() {

        global $pagenow;

        // Check if we are on the Widgets page
        if ( 'widgets.php' === $pagenow ) {
            add_action( 'widgets_init', [ $this, 'registerCustomWidgetAreas' ], 1000 );
            add_action( 'admin_print_scripts', [ $this, 'widgetAreaFormTemplate' ] );
            add_action( 'load-widgets.php', [ $this, 'addWidgetArea' ], 100 );
            add_action( 'admin_enqueue_scripts', [ $this, 'enqueueSidebarScripts' ] );
        }

        //ajac actions to remove sidebars
        add_action( 'wp_ajax_deleteWidgetArea', [ $this, 'deleteWidgetArea' ] );
        add_action( 'wp_ajax_nopriv_deleteWidgetArea', [ $this, 'deleteWidgetArea' ] ); // For non-logged in users
    }

    /**
     * add the widgets area HTML form below the list of existing sidebars
     *
     * @return  void
     * @since     1.0.0
     */
    public function widgetAreaFormTemplate() : void {

        ?>
        <div id="dht-wrap" class="dht-wrap" style="display:none;">
            <form method="post" action="<?php echo esc_url( admin_url( 'widgets.php' ) ); ?>">
                <?php wp_nonce_field( 'dht_create_sidebar_action', 'dht_create_sidebar_action' ); ?>

                <h3><?php _ex( 'Create Widget Area', 'widgets', 'dht' ); ?></h3>
                <input type="text" id="dht_sidebar_name" name="dht_sidebar_name" required
                       placeholder="<?php echo esc_attr_x( 'Sidebar Name', 'widgets', 'dht' ); ?>">
                <button type="submit" name="create_sidebar"
                        class="button-primary"><?php _ex( 'Create', 'widgets', 'dht' ); ?></button>
            </form>
        </div>

        <div class="dht-wrap-delete" style="display:none;">
            <a href="#" style="display:none;"
               class="dht-widget-area-delete-confirm button-primary"><?php _ex( 'Confirm', 'widgets', 'dht' ); ?></a>
            <a href="#" style="display:none;"
               class="dht-widget-area-delete-cancel button-secondary"><?php _ex( 'Cancel', 'widgets', 'dht' ); ?></a>
            <a href="#" style=""
               class="dht-widget-area-delete button-primary"><?php _ex( 'Delete', 'widgets', 'dht' ); ?></a>
        </div>
        <?php
    }

    /**
     * Enqueue the sidebars js file
     *
     * @param string $hook
     *
     * @return void
     * @since     1.0.0
     */
    public function enqueueSidebarScripts( string $hook ) : void {

        wp_enqueue_script( 'create-sidebars', DHT_ASSETS_URI . 'scripts/js/create-sidebars.js', array( 'jquery' ), '1.0', true );
        wp_localize_script( 'create-sidebars', 'dht_remove_sidebar_object', array( 'ajax_url' => admin_url( 'admin-ajax.php' ) ) );

        // Register the style
        wp_register_style( 'create-sidebars', DHT_ASSETS_URI . 'styles/css/create-sidebars.css', array(), '1.0' );
        // Enqueue the style
        wp_enqueue_style( 'create-sidebars' );
    }

    /**
     * Create the widgets area from the widgets area form
     *
     * @return  array - sidebar name and id to register
     * @since     1.0.0
     */
    public function addWidgetArea() : array {

        if ( isset( $_POST ) && isset( $_POST[ 'dht_sidebar_name' ] ) && wp_verify_nonce( sanitize_key( wp_unslash( $_POST[ 'dht_create_sidebar_action' ] ) ), 'dht_create_sidebar_action' ) ) {
            if ( !empty( $_POST[ 'dht_sidebar_name' ] ) ) {
                $this->_widget_areas = $this->_getWidgetAreas();

                $this->_widget_areas[] = $this->_checkWidgetAreaName( sanitize_text_field( wp_unslash( $_POST[ 'dht_sidebar_name' ] ) ) );

                $this->_saveWidgetAreaNames();

                wp_safe_redirect( admin_url( 'widgets.php' ) );

                die();
            }
        }

        return [];
    }

    /**
     * Register the custom widget area we have set.
     *
     * @return void
     * @since     1.0.0
     */
    public function registerCustomWidgetAreas() : void {

        // If the single instance hasn't been set, set it now.
        if ( empty( $this->widget_areas ) ) {
            $this->widget_areas = $this->_getWidgetAreas();
        }

        $options = array(
            'before_title' => '<h3 class="widgettitle">',
            'after_title' => '</h3>',
            'before_widget' => '<div id="%1$s" class="widget clearfix %2$s">',
            'after_widget' => '</div>',
        );

        $options = apply_filters( 'dht_custom_widget_args', $options );

        if ( is_array( $this->widget_areas ) ) {
            foreach ( array_unique( $this->widget_areas ) as $widget_area ) {
                $options[ 'class' ] = 'dht-custom';
                $options[ 'name' ] = $widget_area;
                $options[ 'id' ] = sanitize_key( $widget_area );

                register_sidebar( $options );
            }
        }
    }

    /**
     * Delete Widget areas handler for ajax
     *
     * @return void
     * @since     1.0.0
     */
    public function deleteWidgetArea() : void {

        if ( isset( $_POST[ 'action' ] ) && $_POST[ 'action' ] == 'deleteWidgetArea' ) {
            if ( isset( $_POST[ 'data' ] ) && isset( $_POST[ 'data' ][ 'sidebar_id' ] ) ) {

                //get sidebar name
                $sidebar_id = sanitize_text_field( wp_unslash( $_POST[ 'data' ][ 'sidebar_id' ] ) );

                if ( empty( $sidebar_id ) ) {

                    wp_send_json_error( _x( 'No sidebar name provided', 'widgets', 'dht' ) );

                    die();
                }

                $this->_widget_areas = $this->_getWidgetAreas();

                $key = array_search( $sidebar_id, $this->_widget_areas, true );

                if ( $key >= 0 ) {
                    unset( $this->_widget_areas[ $key ] );
                    $this->_saveWidgetAreaNames();

                    wp_send_json_success();
                }

                die();
            }
        }
    }

    /**
     * Return the widget areas array.
     *
     * @return    array    If not empty, active plugin widget areas are returned.
     * @since     1.0.0
     */
    private function _getWidgetAreas() : array {

        // If the single instance hasn't been set, set it now.
        if ( !empty( $this->_widget_areas ) ) {
            return $this->_widget_areas;
        }

        $sidebars = get_theme_mod( 'dht-widget-areas' );

        if ( !empty( $sidebars ) ) {
            $this->_widget_areas = array_unique( array_merge( $this->_widget_areas, $sidebars ) );
        }

        return $this->_widget_areas;
    }

    /**
     * Save current theme widget areas to register them
     *
     * @return  void
     * @since     1.0.0
     */
    private function _saveWidgetAreaNames() : void {

        set_theme_mod( 'dht-widget-areas', array_unique( $this->_widget_areas ) );
    }

    /**
     * Before we create a new widget_area, verify it doesn't already exist. If it does, append a number to the name.
     *
     * @param string $name - Name of the widget_area to be created.
     *
     * @return  string - sidebar name
     * @since     1.0.0
     */
    private function _checkWidgetAreaName( string $name ) : string {

        $sidebars = wp_get_sidebars_widgets();

        if ( empty( $sidebars ) ) {
            return $name;
        }

        $taken = array();

        //grab all sidebar ids
        foreach ( $sidebars as $sidebar_id => $widget_area ) {

            if ( $sidebar_id != 'wp_inactive_widgets' ) {

                $taken[] = $sidebar_id;
            }
        }

        $taken = array_merge( $taken, $this->_widget_areas );

        $sidebar_id = $name;
        if ( in_array( $name, $taken, true ) ) {
            $counter = substr( $name, -1 );

            if ( !is_numeric( $counter ) ) {
                $new_name = $name . ' 1';
            } else {
                $new_name = substr( $name, 0, -1 ) . ( (int)$counter + 1 );
            }

            $name = $this->_checkWidgetAreaName( $new_name );
        }

        return $name;
    }

}