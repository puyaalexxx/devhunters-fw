<?php
declare( strict_types = 1 );

if ( !defined( 'PPHT_MAIN' ) ) die( 'Forbidden' );

$post_type_name = 'popupht';
$taxonomy_name = 'popup_group_tax';

$post_types = [
    $post_type_name => [
        'args' => [
            'public' => false,
            'show_ui' => true,
            'publicly_queryable' => false,
            'exclude_from_search' => true,
            'show_in_nav_menus' => false,
            'labels' => [
                'name' => _x( 'Popups', 'cpt', PPHT_PREFIX ),
                'singular_name' => _x( 'Popup', 'cpt', PPHT_PREFIX ),
                'add_new' => _x( 'Add New Popup', 'cpt', PPHT_PREFIX ),
                'add_new_item' => _x( 'Add New Popup', 'cpt', PPHT_PREFIX ),
                'edit_item' => _x( 'Edit Popup', 'cpt', PPHT_PREFIX ),
                'new_item' => _x( 'New Popup', 'cpt', PPHT_PREFIX ),
                'all_items' => _x( 'All Popups', 'cpt', PPHT_PREFIX ),
                'view_item' => _x( 'View Popup', 'cpt', PPHT_PREFIX ),
                'view_items' => _x( 'View Popups', 'cpt', PPHT_PREFIX ),
                'archives' => _x( 'Popup Archives', 'cpt', PPHT_PREFIX ),
                'attributes' => _x( 'Popup Attributes', 'cpt', PPHT_PREFIX ),
                'insert_into_item' => _x( 'Add into popup', 'cpt', PPHT_PREFIX ),
                'uploaded_to_this_item' => _x( 'Uploaded to this popup', 'cpt', PPHT_PREFIX ),
                'featured_image' => _x( 'Popup Image', 'cpt', PPHT_PREFIX ),
                'set_featured_image' => _x( 'Set popup image', 'cpt', PPHT_PREFIX ),
                'remove_featured_image' => _x( 'Remove popup image', 'cpt', PPHT_PREFIX ),
                'use_featured_image' => _x( 'Use as popup image', 'cpt', PPHT_PREFIX ),
                'filter_items_list' => _x( 'Filter popups list', 'cpt', PPHT_PREFIX ),
                'filter_by_date' => _x( 'Filter by date', 'cpt', PPHT_PREFIX ),
                'items_list_navigation' => _x( 'Popups list navigation', 'cpt', PPHT_PREFIX ),
                'items_list' => _x( 'Popup list', 'cpt', PPHT_PREFIX ),
                'item_published' => _x( 'Popup published.', 'cpt', PPHT_PREFIX ),
                'item_published_privately' => _x( 'Popup published privately.', 'cpt', PPHT_PREFIX ),
                'item_reverted_to_draft' => _x( 'Popup reverted to draft.', 'cpt', PPHT_PREFIX ),
                'item_scheduled' => _x( 'Popup scheduled.', 'cpt', PPHT_PREFIX ),
                'item_updated' => _x( 'Popup updated.', 'cpt', PPHT_PREFIX ),
                'item_link' => _x( 'Popup Link', 'cpt', PPHT_PREFIX ),
                'item_link_description' => _x( 'A link to the popup', 'cpt', PPHT_PREFIX ),
                'search_items' => _x( 'Search Popups', 'cpt', PPHT_PREFIX ),
                'not_found' => _x( 'No popups found', 'cpt', PPHT_PREFIX ),
                'not_found_in_trash' => _x( 'No popups found in Trash', 'cpt', PPHT_PREFIX ),
                'menu_name' => _x( 'Popups', 'cpt', PPHT_PREFIX ),
                'name_admin_bar' => _x( 'Popup', 'cpt', PPHT_PREFIX ),
                'parent_item_colon' => _x( 'Parent Popup', 'cpt', PPHT_PREFIX )
            ],
            'description' => _x( 'A popup post type', 'cpt', PPHT_PREFIX ),
            'hierarchical' => false,
            'has_archive' => false,
            'can_export' => true,
            'taxonomies' => array( $taxonomy_name ),
            'menu_position' => 80,
            'show_in_menu' => false,
            'show_in_admin_bar' => true,
            'query_var' => false,
            'show_in_rest' => false,
            'template' => true,
            'template_lock' => false,
            'map_meta_cap' => true,
            'rewrite' => array(
                'slug' => apply_filters( 'popupsht_slug', $post_type_name ),
                'with_front' => false,
                'pages' => true,
                'feeds' => true,
                'ep_mask' => EP_PERMALINK,
            ),
            'supports' => array( 'title', 'editor' )
        ],
    ]
];

$taxonomies = [
    $post_type_name => [
        $taxonomy_name => [
            'public' => false,
            'publicly_queryable' => false,
            'hierarchical' => true,
            'labels' => [
                'name' => _x( 'Groups', 'cpt', PPHT_PREFIX ),
                'singular_name' => _x( 'Group', 'cpt', PPHT_PREFIX ),
                'menu_name' => _x( 'Groups', 'cpt', PPHT_PREFIX ),
                'name_admin_bar' => _x( 'Group', 'cpt', PPHT_PREFIX ),
                'search_items' => _x( 'Search Groups', 'cpt', PPHT_PREFIX ),
                'popular_items' => _x( 'Popular Groups', 'cpt', PPHT_PREFIX ),
                'all_items' => _x( 'All Groups', 'cpt', PPHT_PREFIX ),
                'edit_item' => _x( 'Edit Group', 'cpt', PPHT_PREFIX ),
                'view_item' => _x( 'View Group', 'cpt', PPHT_PREFIX ),
                'update_item' => _x( 'Update Group', 'cpt', PPHT_PREFIX ),
                'add_new_item' => _x( 'Add New Group', 'cpt', PPHT_PREFIX ),
                'new_item_name' => _x( 'New Group Name', 'cpt', PPHT_PREFIX ),
                'not_found' => _x( 'No groups found.', 'cpt', PPHT_PREFIX ),
                'no_terms' => _x( 'No groups', 'cpt', PPHT_PREFIX ),
                'items_list_navigation' => _x( 'Groups list navigation', 'cpt', PPHT_PREFIX ),
                'items_list' => _x( 'Groups list', 'cpt', PPHT_PREFIX ),
                'select_name' => _x( 'Select Group', 'cpt', PPHT_PREFIX ),
                'parent_item' => _x( 'Parent Group', 'cpt', PPHT_PREFIX ),
                'parent_item_colon' => _x( 'Parent Group:', 'cpt', PPHT_PREFIX )
            ],
            'query_var' => false,
            'show_in_rest' => false,
            'show_ui' => true,
            'show_in_menu' => false,
            'show_in_nav_menus' => false,
            'show_tagcloud' => false,
            'show_admin_column' => true,
            'rewrite' => [
                'slug' => apply_filters( 'popup_group_tax_slug', $taxonomy_name ),
                'with_front' => false,
                'hierarchical' => false,
                'ep_mask' => EP_NONE
            ]
        ]
    ]
];

$cpt_config = [
    'post_types' => $post_types,
    'taxonomies' => $taxonomies
];