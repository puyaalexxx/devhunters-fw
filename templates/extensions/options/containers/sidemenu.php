<?php

use function DHT\Helpers\dht_if_parent_menu_is_active;
use function DHT\Helpers\dht_render_link_area;
use function DHT\Helpers\dht_render_sidebar_content;
use function DHT\Helpers\dht_render_subpage_li_area;

if( !defined( 'DHT_MAIN' ) ) die( 'Forbidden' );

$container = $args[ 'container' ] ?? [];
//get sidemenu saved values
$saved_values = $args[ 'saved_values' ] ?? [];
//used to call the render method on
$registered_options_classes = $args[ 'registered_options_classes' ] ?? [];
//each current menu item / tab options
$options = [];
?>
<!-- container - sidemenu -->

<?php do_action( 'dht_template_container_sidemenu_before_area' ); ?>

<?php if( isset( $container[ 'subtype' ] ) && $container[ 'subtype' ] == 'tabs' ): ?>

    <div id="dht-cosidebar"
         class="dht-cosidebar-tabs <?php echo isset( $container[ 'attr' ][ 'class' ] ) ? esc_attr( $container[ 'attr' ][ 'class' ] ) : ''; ?>">

        <div class="dht-cosidebar-header">
            <ul>
                <?php $count = 0; ?>
                <?php foreach( $container[ 'options' ] as $page ): $count++; ?>
                    
                    <?php
                    $page_link = $page[ 'page_link' ] ?? '';
                    //set active class
                    $active_class = $count == 1 ? 'dht-cosidebar-active' : '';
                    //get page options if no page_link available
                    $options[ $page[ 'id' ] ][ 'options' ] = $page[ 'options' ] ?? [];
                    ?>

                    <li class="<?php echo esc_attr( $active_class ); ?>">
                        
                        <?php dht_render_link_area( $page_link, $page ); ?>
                        
                        <?php if( isset( $page[ 'pages' ] ) ): ?>

                            <ul class="dht-cosidebar-sub-menu">
                                
                                <?php foreach( $page[ 'pages' ] as $subpage ): ?>
                                    
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
        <?php if( !empty( $options ) ): ?>

            <div class="dht-cosidebar-body">
                
                <?php $count = 0; ?>
                <?php foreach( $options as $page_id => $page ): $count++; ?>
                    
                    <?php
                    // Render submenu items
                    if( isset( $page[ 'pages' ] ) ) {
                        foreach( $page[ 'pages' ] as $subpage_id => $options ) {
                            echo dht_render_sidebar_content( [
                                'menu_id'    => $container[ 'id' ],
                                'page_id'    => $page_id,
                                'subpage_id' => $subpage_id
                            ], $options, $saved_values, $registered_options_classes, $count );
                        }
                    }
                    else {
                        // Render parent menu item options
                        echo dht_render_sidebar_content( [
                            'menu_id' => $container[ 'id' ],
                            'page_id' => $page_id
                        ], $page[ 'options' ], $saved_values, $registered_options_classes, $count );
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
                <?php foreach( $container[ 'options' ] as $page ): $count++; ?>
                    
                    <?php
                    $active_parent_class = dht_if_parent_menu_is_active( $page, $current_page );
                    
                    $page_link = $page[ 'page_link' ] ?? '';
                    //set active class
                    $active_class = ( !empty( $page_link ) && $current_page == $page_link ) || ( empty( $page_link ) && $count == 1 ) || $active_parent_class ? 'dht-cosidebar-active' : '';
                    //get current page options
                    if( !empty( $page[ 'options' ] ) ) $options = $page[ 'options' ];
                    ?>

                    <li class="<?php echo esc_attr( $active_class ); ?>">
                        
                        <?php dht_render_link_area( $page_link, $page ); ?>
                        
                        <?php if( isset( $page[ 'pages' ] ) ): ?>

                            <ul class="dht-cosidebar-sub-menu">
                                
                                <?php foreach( $page[ 'pages' ] as $subpage ): ?>
                                    
                                    <?php
                                    $page_link = $subpage[ 'page_link' ] ?? '';
                                    //set active class
                                    $active_class = ( !empty( $page_link ) && $current_page == $page_link ) || ( empty( $page_link ) && $count == 1 ) ? 'dht-cosidebar-active' : '';
                                    //get subpage options if no page_link available
                                    if( !empty( $subpage[ 'options' ] ) ) $options = $subpage[ 'options' ];
                                    
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
        <?php if( !empty( $options ) ): ?>

            <div class="dht-cosidebar-body">
                
                <?php
                echo dht_render_sidebar_content( [ 'menu_id' => $container[ 'id' ] ], $options, $saved_values, $registered_options_classes, 1 );
                ?>

            </div>
        
        <?php endif; ?>

    </div>
<?php endif; ?>

<?php do_action( 'dht_template_container_sidemenu_after_area' ); ?>
