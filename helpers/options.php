<?php
declare( strict_types = 1 );

namespace DHT\Helpers;

if ( !defined( 'DHT_MAIN' ) ) die( 'Forbidden' );

////////////////////////////////////// this area is about saving retrieving option db values

/**
 * get option or options fields from db
 *
 * @param string $option_id
 * @param array  $default_value
 *
 * @return mixed
 * @since     1.0.0
 */
if ( !function_exists( 'dht_get_db_settings_option' ) ) {
    function dht_get_db_settings_option( string $option_id, mixed $default_value = [] ) : mixed {

        if ( empty( $option_id ) ) return [];

        return get_option( $option_id, $default_value );
    }
}

/**
 * save option field or fields in database
 *
 * @param string $option_id
 * @param mixed  $value     - value to be saved
 * @param string $array_key - save all options under this array key
 *
 * @return bool
 * @since     1.0.0
 */
if ( !function_exists( 'dht_set_db_settings_option' ) ) {
    function dht_set_db_settings_option( string $option_id, mixed $value, string $array_key = '' ) : bool {

        if ( empty( $option_id ) || empty( $value ) ) return false;

        //this is useful for array of arrays of options
        if ( !empty( $array_key ) ) {

            //get saved value first to not override all the settings
            $saved_values = dht_get_db_settings_option( $option_id );

            $saved_values[ $array_key ] = $value;

            return update_option( $option_id, $saved_values );
        }

        return update_option( $option_id, $value );
    }
}

////////////////////////////////////// other option help functions

/**
 * parse option attributes to add them to the HTML field
 *
 * @param array $attr
 *
 * @return string
 * @since     1.0.0
 */
if ( !function_exists( 'dht_parse_option_attributes' ) ) {
    function dht_parse_option_attributes( array $attr ) : string {

        if ( isset( $attr[ 'class' ] ) ) unset( $attr[ 'class' ] );

        $attributes = '';
        foreach ( $attr as $key => $value ) {

            // Sanitize the key and value
            $key = htmlspecialchars( $key );

            $value = htmlspecialchars( $value );

            // Concatenate the key-value pairs to form the attribute string
            $attributes .= " $key=\"$value\"";
        }

        return $attributes;
    }
}

/**
 * add allowed HTML tags to the wp editor value
 *
 * @param string $value
 *
 * @return string
 * @since     1.0.0
 */
if ( !function_exists( 'dht_sanitize_wpeditor_value' ) ) {
    function dht_sanitize_wpeditor_value( string $value ) : string {

        // Get the list of allowed HTML tags and attributes
        $allowed_html = wp_kses_allowed_html( 'post' );

        // Remove the <script> tag from the list of allowed tags
        unset( $allowed_html[ 'script' ] );

        // Sanitize content with allowed HTML tags and excluding <script> tag
        return wp_kses( $value, $allowed_html );
    }
}

/**
 * remove dht prefix from the font name added because it conflicts with
 * Google font names
 *
 * @param string $font_name
 *
 * @return string
 * @since     1.0.0
 */
if ( !function_exists( 'dht_remove_font_name_prefix' ) ) {
    function dht_remove_font_name_prefix( string $font_name ) : string {

        return preg_replace( '/^' . DHT_PREFIX . '-/', '', $font_name );
    }
}

/**
 * gent font weight label from its value (ex: 400, 500)
 *
 * @param int $font_weight
 *
 * @return string
 * @since     1.0.0
 */
if ( !function_exists( 'dht_get_font_weight_Label' ) ) {
    function dht_get_font_weight_Label( int $font_weight ) : string {

        return match ( $font_weight ) {
            100 => 'Thin',
            200 => 'Extra Light',
            300 => 'Light',
            400 => 'Regular',
            500 => 'Medium',
            600 => 'Semi Bold',
            700 => 'Bold',
            800 => 'Extra Bold',
            900 => 'Black'
        };
    }
}

/**
 * render all group, toggle and field option types
 *
 * @param array  $options                 - options array
 * @param string $options_id              - options prefix id
 * @param array  $saved_values            - all options saved values
 * @param array  $optionRegisteredClasses - registered framework groups, toggles, and field classes
 *
 * @return string
 * @since     1.0.0
 */
if ( !function_exists( 'dht_render_options' ) ) {
    function dht_render_options( array $options, string $options_id, array $saved_values, array $registered_options_classes ) : string {

        ob_start();

        foreach ( $options as $option ) {

            //get option saved value by its id
            $saved_value = $saved_values[ $option[ 'id' ] ] ?? [];

            //if it is a group type
            if ( array_key_exists( $option[ 'type' ], $registered_options_classes[ 'groupsClasses' ] ) ) {
                //render the respective option group class
                echo $registered_options_classes[ 'groupsClasses' ][ $option[ 'type' ] ]->render( $option, $saved_value, $options_id );
            } //if it is a toggle type
            elseif ( array_key_exists( $option[ 'type' ], $registered_options_classes[ 'togglesClasses' ] ) ) {
                //render the respective option toggle class
                echo $registered_options_classes[ 'togglesClasses' ][ $option[ 'type' ] ]->render( $option, $saved_value, $options_id );
            } else {
                //render the respective option type class
                echo dht_render_field_if_exists( $option, $saved_value, $options_id, $registered_options_classes[ 'fieldsClasses' ] );
            }
        }

        return ob_get_clean();
    }
}

/**
 * render group options (toggles and field options)
 *
 * @param string $group_id                 the group option id
 * @param array  $group_option             group option settings
 * @param mixed  $saved_value              Saved values
 * @param array  $registered_field_classes - registered framework field classes
 *
 * @return string
 * @since     1.0.0
 */
if ( !function_exists( 'dht_render_group' ) ) {
    function dht_render_group( string $group_id, array $group_option, mixed $saved_value, array $registered_options_classes ) : string {

        //render the respective option toggle class
        if ( array_key_exists( $group_option[ 'type' ], $registered_options_classes[ 'togglesClasses' ] ) ) {
            return $registered_options_classes[ 'togglesClasses' ][ $group_option[ 'type' ] ]->render( $group_option, $saved_value, $group_id );
        } //render the specific field type
        else {
            return dht_render_field_if_exists( $group_option, $saved_value, $group_id, $registered_options_classes[ 'fieldsClasses' ] );
        }
    }
}

/**
 * render field option if it is registered (exists)
 *
 * @param array  $option                   option array
 * @param mixed  $saved_value              saved values
 * @param string $options_id               - options prefix id
 * @param array  $registered_field_classes - registered framework field classes
 *
 * @return string
 * @since     1.0.0
 */
if ( !function_exists( 'dht_render_field_if_exists' ) ) {
    function dht_render_field_if_exists( array $option, mixed $saved_value, string $options_id, array $registered_field_classes ) : string {

        if ( array_key_exists( $option[ 'type' ], $registered_field_classes ) ) {

            //render the respective option type class
            return $registered_field_classes[ $option[ 'type' ] ]->render( $option, $saved_value, $options_id );

        } else {
            //display no option template if no match
            return dht_load_view( DHT_TEMPLATES_DIR . 'extensions/options/fields/', 'no-option.php' );
        }
    }
}

/**
 * render box item (addable group option)
 *
 * @param array $group                      group options to be rendered
 * @param mixed $saved_values               Saved values
 * @param array $registered_options_classes registered option type classes
 * @param int   $cnt                        The box item number
 *
 * @return string
 * @since     1.0.0
 */
if ( !function_exists( 'dht_display_box_item' ) ) {
    function dht_display_box_item( array $group, mixed $saved_values, array $registered_options_classes, int $cnt ) : string {

        $default_box_title = _x( 'Box Title', 'options', DHT_PREFIX );

        ob_start();
        ?>
        <div class="dht-addable-box-item" data-box-item-number="<?php echo esc_attr( $cnt ); ?>">

            <div class="dht-addable-box-title">

                <div class="dht-addable-box-arrow">
                    <span class="dht-addable-box-arrow-item dashicons dashicons-plus-alt"></span>
                    <span class="dht-addable-box-arrow-item-close dashicons dashicons-dismiss"></span>
                </div>

                <span
                    class="dht-addable-box-title-text"
                    data-default-title="<?php echo esc_attr( $default_box_title ); ?>">
                    <?php echo !empty( $saved_values[ 'box-title' ] ) ? esc_html( $saved_values[ 'box-title' ] ) : $default_box_title; ?>
                </span>

            </div>

            <div class="dht-addable-box-content">

                <?php echo dht_render_box_item_content( $group, $saved_values, $registered_options_classes, $default_box_title, $cnt ); ?>

            </div>

        </div>
        <?php
        return ob_get_clean();
    }
}

/**
 * render box item content (addable group option)
 *
 * @param array  $group                      group options to be rendered
 * @param mixed  $saved_values               Saved values
 * @param array  $registered_options_classes registered option type classes
 * @param string $default_box_title          The default bot item title
 * @param int    $cnt                        The box item number
 *
 * @return mixed
 * @since     1.0.0
 */
if ( !function_exists( 'dht_render_box_item_content' ) ) {
    function dht_render_box_item_content( array $group, mixed $saved_values, array $registered_options_classes, string $default_box_title, int $cnt ) : string {

        ob_start(); ?>
        <div class="dht-field-wrapper">
            <div class="dht-field-box-wrapper dht-field-child-input">
                <label
                    for="<?php echo esc_attr( $group[ 'id' ] ); ?>[<?php echo esc_attr( $cnt ); ?>][box-title]">
                    <?php echo !empty( $saved_values[ 'box-title' ] ) ? esc_html( $saved_values[ 'box-title' ] ) : _x( 'Box Title', 'options', DHT_PREFIX ); ?>
                </label>
                <input
                    class="dht-input dht-field dht-box-title"
                    id="<?php echo esc_attr( $group[ 'id' ] ); ?>[<?php echo esc_attr( $cnt ); ?>][box-title]"
                    type="text"
                    name="<?php echo esc_attr( $group[ 'id' ] ); ?>[<?php echo esc_attr( $cnt ); ?>][box-title]"
                    value="<?php echo !empty( $saved_values[ 'box-title' ] ) ? esc_html( $saved_values[ 'box-title' ] ) : ''; ?>"
                    placeholder="<?php echo esc_attr( $default_box_title ); ?>" />
            </div>
        </div>

        <div class="dht-divider"></div>

        <!--box fields-->
        <?php foreach ( $group[ 'options' ] as $option ) : ?>

            <?php
            $group_id = $group[ 'id' ] . '[' . esc_attr( $cnt ) . ']';
            //get option saved value if exists
            $saved_value = array_key_exists( $option[ 'id' ], $saved_values ) ? $saved_values[ $option[ 'id' ] ] : [];

            echo dht_render_group( $group_id, $option, $saved_value, $registered_options_classes );
            ?>

        <?php endforeach; ?>

        <!--remove box area-->
        <div class="dht-remove-box-item">
            <div class="dht-divider"></div>

            <a href=""
               class="button button-primary dht-btn-remove-box-item"><?php _ex( 'Remove Box', 'options', DHT_PREFIX ); ?></a>
        </div>

        <?php
        return ob_get_clean();
    }
}

/**
 * check if the options must be saved separately and not grouped under an id
 *
 * @param array $options
 *
 * @return bool
 * @since     1.0.0
 */
if ( !function_exists( 'isSaveOptionsSeparately' ) ) {
    function is_save_options_separately( array $options ) : bool {

        return isset( $options[ 'save' ] ) && $options[ 'save' ] == "separately";
    }
}

/**
 * Function to render the content of the header link area
 *
 * @param string $page_link Page link where to redirect or anchor id
 * @param array  $page      Page options
 *
 * @return mixed The processed value to be saved.
 * @since     1.0.0
 */
if ( !function_exists( 'dht_render_link_area' ) ) {
    function dht_render_link_area( string $page_link, array $page ) : void { ?>

        <a href="<?php echo !empty( $page_link ) ? esc_url( $page_link ) : '#' . $page[ 'id' ]; ?>">
        <span class="dht-cosidebar-icon">
            
            <?php if ( filter_var( $page[ 'icon' ], FILTER_VALIDATE_URL ) ): ?>

                <img src="<?php echo esc_url( $page[ 'icon' ] ); ?>" alt="<?php echo esc_attr( $page[ 'title' ] ); ?>">

            <?php else: ?>

                <span class="<?php echo esc_attr( $page[ 'icon' ] ); ?>"></span>

            <?php endif; ?>
            
        </span>
            <span class="title"><?php echo esc_html( $page[ 'title' ] ); ?></span>
        </a>
        <?php
    }
}

/**
 * Function to render the content of the header supbpage li tag
 *
 * @param string $active_class Active class
 * @param string $page_link    Page link where to redirect or anchor id
 * @param array  $page         Page options
 *
 * @return mixed The processed value to be saved.
 * @since     1.0.0
 */
if ( !function_exists( 'dht_render_subpage_li_area' ) ) {
    function dht_render_subpage_li_area( string $active_class, string $page_link, array $page ) : void { ?>

        <li class="<?php echo esc_attr( $active_class ); ?>">
            <a href="<?php echo !empty( $page_link ) ? esc_url( $page_link ) : '#' . $page[ 'id' ]; ?>">

                <?php echo esc_html( $page[ 'title' ] ); ?>

            </a>
        </li>
        <?php
    }
}

/**
 * Function to render the content of the sidebar
 *
 * @param array $ids                        pages ids
 * @param array $options                    page options
 * @param mixed $saved_values               Saved values
 * @param array $registered_options_classes registered option type classes
 * @param int   $count                      The box item number
 *
 * @return mixed The processed value to be saved.
 * @since     1.0.0
 */
if ( !function_exists( 'dht_render_sidebar_content' ) ) {
    function dht_render_sidebar_content( array $ids, array $options, mixed $saved_values, array $registered_options_classes, int $count ) : string {

        $is_active_class = ( $count == 1 ) ? 'dht-cosidebar-active' : '';

        //get specific page group/option saved value
        $saved_value = $saved_values[ $ids[ 'menu_id' ] ] ?? [];

        //id used for tabs options
        $content_id = !empty( $ids[ 'subpage_id' ] ) ? $ids[ 'subpage_id' ] : ( !empty( $ids[ 'page_id' ] ) ? $ids[ 'page_id' ] : '' );

        ob_start(); ?>

        <div id="<?php echo esc_attr( $content_id ); ?>"
             class="dht-cosidebar-content <?php echo esc_attr( $is_active_class ); ?> ">

            <?php echo dht_render_options( $options, $ids[ 'menu_id' ], $saved_value, $registered_options_classes ) ?>

        </div>

        <?php
        return ob_get_clean();
    }
}

/**
 * see if the parent menu is also active if the sub menu is active
 * Function to render the content of the sidebar
 *
 * @param array  $page         Subpages settings
 * @param string $current_page current clicked page (menu item)
 *
 * @return mixed The processed value to be saved.
 * @since     1.0.0
 */
if ( !function_exists( 'dht_if_parent_menu_is_active' ) ) {
    function dht_if_parent_menu_is_active( array $page, string $current_page ) : bool {

        $active_parent_class = false;
        if ( isset( $page[ 'pages' ] ) ) {
            // Iterate through the array to check if the link exists
            foreach ( $page[ 'pages' ] as $item ) {
                if ( isset( $item[ 'page_link' ] ) && $item[ 'page_link' ] == $current_page ) {
                    $active_parent_class = true;
                    break;
                }
            }
        }

        return $active_parent_class;
    }
}