<?php

if ( !defined( 'DHT_MAIN' ) ) die( 'Forbidden' );

use function DHT\Helpers\dht_render_options;

$container = $args[ 'container' ] ?? [];
//get sidemenu saved values
$saved_values = $args[ 'saved_values' ] ?? [];
//used to call the render method on
$registered_options_classes = $args[ 'registered_options_classes' ] ?? [];
//each current menu item / tab options
$options = [];
?>
    <!-- container - sidemenu -->
<?php if ( isset( $container[ 'subtype' ] ) && $container[ 'subtype' ] == 'tabs' ): ?>

    <div id="dht-cosidebar"
         class="dht-cosidebar-tabs <?php echo isset( $container[ 'attr' ][ 'class' ] ) ? esc_attr( $container[ 'attr' ][ 'class' ] ) : ''; ?>">

        <div class="dht-cosidebar-header">
            <ul>
                <?php $count = 0; ?>
                <?php foreach ( $container[ 'pages' ] as $page ): $count++; ?>

                    <?php
                    $page_link = $page[ 'page_link' ] ?? '';
                    //set active class
                    $active_class = $count == 1 ? 'dht-cosidebar-active' : '';
                    //get page options if no page_link available
                    $options[ $page[ 'id' ] ][ 'options' ] = $page[ 'options' ] ?? [];
                    ?>

                    <li class="<?php echo esc_attr( $active_class ); ?>">

                        <?php dht_render_link_area( $page_link, $page ); ?>

                        <?php if ( isset( $page[ 'pages' ] ) ): ?>

                            <ul class="dht-cosidebar-sub-menu">

                                <?php foreach ( $page[ 'pages' ] as $subpage ): ?>

                                    <?php
                                    $page_link = $subpage[ 'page_link' ] ?? '';
                                    //set active class
                                    $active_class = $count == 1 ? 'dht-cosidebar-active' : '';
                                    //get subpage options if no page_link available
                                    $options[ $page[ 'id' ] ][ 'pages' ][ $subpage[ 'id' ] ] = $subpage[ 'options' ] ?? [];

                                    //render subpage header li tag
                                    dht_render_subpage_li_area( $active_class, $page_link, $subpage )
                                    ?>

                                <?php endforeach; ?>

                            </ul>

                        <?php endif; ?>
                    </li>

                <?php endforeach; ?>
            </ul>
        </div>

        <!--render the received option from the menu pages-->
        <?php if ( !empty( $options ) ): ?>

            <div class="dht-cosidebar-body">

                <?php $count = 0; ?>
                <?php foreach ( $options as $page_id => $page ): $count++; ?>

                    <?php
                    // Render submenu items
                    if ( isset( $page[ 'pages' ] ) ) {
                        foreach ( $page[ 'pages' ] as $subpage_id => $options ) {
                            echo dht_render_sidebar_content( [ 'menu_id' => $container[ 'id' ], 'page_id' => $page_id, 'subpage_id' => $subpage_id ], $options, $saved_values, $registered_options_classes, $count );
                        }
                    } else {
                        // Render parent menu item options
                        echo dht_render_sidebar_content( [ 'menu_id' => $container[ 'id' ], 'page_id' => $page_id ], $page[ 'options' ], $saved_values, $registered_options_classes, $count );
                    }
                    ?>

                <?php endforeach; ?>

            </div>

        <?php endif; ?>

    </div>

<?php else: ?>

    <?php
    $count = 0;
    //each current page that is accessed
    $current_page = !empty( $_GET[ 'page' ] ) ? admin_url( 'admin.php?page=' . $_GET[ 'page' ] ) : '';
    ?>

    <div
        id="dht-cosidebar"
        class="<?php echo isset( $container[ 'attr' ][ 'class' ] ) ? esc_attr( $container[ 'attr' ][ 'class' ] ) : ''; ?>">

        <div class="dht-cosidebar-header">
            <ul>
                <?php foreach ( $container[ 'pages' ] as $page ): $count++; ?>

                    <?php
                    $active_parent_class = dht_if_parent_menu_is_active( $page, $current_page );

                    $page_link = $page[ 'page_link' ] ?? '';
                    //set active class
                    $active_class = ( !empty( $page_link ) && $current_page == $page_link ) || ( empty( $page_link ) && $count == 1 ) || $active_parent_class ? 'dht-cosidebar-active' : '';
                    //get current page options
                    if ( !empty( $page[ 'options' ] ) ) $options = $page[ 'options' ];
                    ?>

                    <li class="<?php echo esc_attr( $active_class ); ?>">

                        <?php dht_render_link_area( $page_link, $page ); ?>

                        <?php if ( isset( $page[ 'pages' ] ) ): ?>

                            <ul class="dht-cosidebar-sub-menu">

                                <?php foreach ( $page[ 'pages' ] as $subpage ): ?>

                                    <?php
                                    $page_link = $subpage[ 'page_link' ] ?? '';
                                    //set active class
                                    $active_class = ( !empty( $page_link ) && $current_page == $page_link ) || ( empty( $page_link ) && $count == 1 ) ? 'dht-cosidebar-active' : '';
                                    //get subpage options if no page_link available
                                    if ( !empty( $subpage[ 'options' ] ) ) $options = $subpage[ 'options' ];

                                    //render subpage header li tag
                                    dht_render_subpage_li_area( $active_class, $page_link, $subpage );
                                    ?>

                                <?php endforeach; ?>

                            </ul>

                        <?php endif; ?>
                    </li>

                <?php endforeach; ?>
            </ul>
        </div>

        <!--render the received option from the menu pages-->
        <?php if ( !empty( $options ) ): ?>

            <div class="dht-cosidebar-body">

                <?php
                echo dht_render_sidebar_content( [ 'menu_id' => $container[ 'id' ] ], $options, $saved_values, $registered_options_classes, 1 );
                ?>

            </div>

        <?php endif; ?>

    </div>
<?php endif; ?>

<?php

// Function to render the content of the header link area
function dht_render_link_area( string $page_link, array $page ) : void { ?>

    <a href="<?php echo !empty( $page_link ) ? esc_url( $page_link ) : '#' . $page[ 'id' ]; ?>">
        <span class="dht-cosidebar-icon">
            <?php if ( filter_var( $page[ 'icon' ], FILTER_VALIDATE_URL ) ): ?>
                <img src="<?php echo esc_url( $page[ 'icon' ] ); ?>"
                     alt="<?php echo esc_attr( $page[ 'title' ] ); ?>">
            <?php else: ?>
                <span class="<?php echo esc_attr( $page[ 'icon' ] ); ?>"></span>
            <?php endif; ?>
        </span>
        <span class="title"><?php echo esc_html( $page[ 'title' ] ); ?></span>
    </a>
    <?php
}

// Function to render the content of the header supbpage li tag
function dht_render_subpage_li_area( string $active_class, string $page_link, array $page ) : void { ?>

    <li class="<?php echo esc_attr( $active_class ); ?>">
        <a href="<?php echo !empty( $page_link ) ? esc_url( $page_link ) : '#' . $page[ 'id' ]; ?>">
            <?php echo esc_html( $page[ 'title' ] ); ?>
        </a>
    </li>
    <?php
}

// Function to render the content of the sidebar
function dht_render_sidebar_content( $ids, $options, $saved_values, $registered_options_classes, $count ) : string {

    $is_active_class = ( $count == 1 ) ? 'dht-cosidebar-active' : '';

    //prefix id used int he options name attribute for saving
    $options_id = !empty( $ids[ 'subpage_id' ] ) && !empty( $ids[ 'page_id' ] ) ?
        ( $ids[ 'menu_id' ] . '[' . $ids[ 'page_id' ] . '][' . $ids[ 'subpage_id' ] . ']' ) :
        ( !empty( $ids[ 'page_id' ] ) ?
            ( $ids[ 'menu_id' ] . '[' . $ids[ 'page_id' ] . ']' ) :
            $ids[ 'menu_id' ]
        );

    //get specific page group/option saved value
    $saved_value = !empty( $ids[ 'subpage_id' ] ) && !empty( $ids[ 'page_id' ] ) ?
        ( $saved_values[ $ids[ 'menu_id' ] ][ $ids[ 'page_id' ] ][ $ids[ 'subpage_id' ] ] ?? [] ) :
        ( !empty( $ids[ 'page_id' ] ) ?
            ( $saved_values[ $ids[ 'menu_id' ] ][ $ids[ 'page_id' ] ] ?? [] ) :
            ( $saved_values[ $ids[ 'menu_id' ] ] ?? [] )
        );

    //id used for tabs options
    $content_id = !empty( $ids[ 'subpage_id' ] ) ? $ids[ 'subpage_id' ] : ( !empty( $ids[ 'page_id' ] ) ? $ids[ 'page_id' ] : '' );

    ob_start(); ?>

    <div id="<?php echo esc_attr( $content_id ); ?>"
         class="dht-cosidebar-content <?php echo esc_attr( $is_active_class ); ?> ">
        <?php echo dht_render_options( $options, $options_id, $saved_value, $registered_options_classes ) ?>
    </div>

    <?php
    return ob_get_clean();
}

// see if the parent menu is also active if the sub menu is active
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
