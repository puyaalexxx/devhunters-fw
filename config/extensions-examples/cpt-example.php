<?php
if ( !defined( 'PPHT_MAIN' ) ) die( 'Forbidden' );

//array example to register
$post_types = [
    'post_type_name 1' => [
        //args
    ],
    'post_type_name 2' => [
        //args
    ]
];
//only the first post type has taxonomies
$taxonomies = [
    'post_type_name 1' => [
        'taxonomy_name 1' => [
            //args
        ],
        'taxonomy_name 2' => [
            //args
        ],
    ]
];

$post_type_labels = [
    'name' => _x( 'Blogs', 'cpt', PPHT_PREFIX ), // General name for the post type, which is usually plural. Used in the WordPress admin  and by other plugins and themes.
    'singular_name' => _x( 'Blog', 'cpt', PPHT_PREFIX ), // The singular version of the name for the post type. It is also used in the WordPress admin and by other plugins and themes
    'add_new' => _x( 'Add New Blog', 'cpt', PPHT_PREFIX ), // The label for the Add New submenu item. The text defaults to “Add New.”
    'add_new_item' => _x( 'Add New Blog', 'cpt', PPHT_PREFIX ), // Used as the header text on the main post listing page to add a new post. By default, the text is “Add New Post/Page.”
    'edit_item' => _x( 'Edit Blog', 'cpt', PPHT_PREFIX ), // Used as the text for editing an individual post. Defaults to “Edit Post/Page.”
    'new_item' => _x( 'New Blog', 'cpt', PPHT_PREFIX ), // Text for creating a new post. By default, it is set to “New Post/Page.”
    'all_items' => _x( 'All Blogs', 'cpt', PPHT_PREFIX ), //Text used for the all items text in the menu. This is the text displayed directly below the top‐level menu name. Defaults to the value of name.
    'view_item' => _x( 'View Blog', 'cpt', PPHT_PREFIX ), // Text for viewing a single post entry. Defaults to “View Post/Page.”
    'view_items' => _x( 'View Blogs', 'cpt', PPHT_PREFIX ), //Label for viewing post type archives. Default is ‘View Posts’ / ‘View Pages’.
    'archives' => _x( 'Blog Archives', 'cpt', PPHT_PREFIX ), //Label for archives in nav menus. Default is ‘Post Archives’ / ‘Page Archives’.
    'attributes' => _x( 'Book Attributes', 'cpt', PPHT_PREFIX ), //Label for the attributes meta box. Default is ‘Post Attributes’ / ‘Page Attributes’.
    'insert_into_item' => _x( 'Add into blog', 'cpt', PPHT_PREFIX ), //Label for the media frame button. Default is ‘Insert into post’ / ‘Insert into page’.
    'uploaded_to_this_item' => _x( 'Uploaded to this book', 'cpt', PPHT_PREFIX ), //Label for the media frame filter. Default is ‘Uploaded to this post’ / ‘Uploaded to this page’.
    'featured_image' => _x( 'Book Image', 'cpt', PPHT_PREFIX ), //Label for the featured image meta box title. Default is ‘Featured image’.
    'set_featured_image' => _x( 'Set book image', 'cpt', PPHT_PREFIX ), //Label for setting the featured image. Default is ‘Set featured image’.
    'remove_featured_image' => _x( 'Remove book image', 'cpt', PPHT_PREFIX ), //Label for removing the featured image. Default is ‘Remove featured image’.
    'use_featured_image' => _x( 'Use as book image', 'cpt', PPHT_PREFIX ), // Label in the media frame for using a featured image. Default is ‘Use as featured image’.
    'filter_items_list' => _x( 'Filter books list', 'cpt', PPHT_PREFIX ),//Label for the table views hidden heading. Default is ‘Filter posts list’ / ‘Filter pages list’.
    'filter_by_date' => _x( 'Filter by date', 'cpt', PPHT_PREFIX ), // Label for the date filter in list tables. Default is ‘Filter by date’.
    'items_list_navigation' => _x( 'Books list navigation', 'cpt', PPHT_PREFIX ), // Label for the table pagination hidden heading. Default is ‘Posts list navigation’ / ‘Pages list navigation’.
    'items_list' => _x( 'Books list', 'cpt', PPHT_PREFIX ), //Label for the table hidden heading. Default is ‘Posts list’ / ‘Pages list’.
    'item_published' => _x( 'Book published.', 'cpt', PPHT_PREFIX ), //Label used when an item is published. Default is ‘Post published.’ / ‘Page published.’
    'item_published_privately' => _x( 'Book published privately.', 'cpt', PPHT_PREFIX ), //Label used when an item is published with private visibility. Default is ‘Post published privately.’ / ‘Page published privately.’
    'item_reverted_to_draft' => _x( 'Book reverted to draft.', 'cpt', PPHT_PREFIX ), // Label used when an item is switched to a draft. Default is ‘Post reverted to draft.’ / ‘Page reverted to draft.’
    'item_scheduled' => _x( 'Book scheduled.', 'cpt', PPHT_PREFIX ), //Label used when an item is scheduled for publishing. Default is ‘Post scheduled.’ / ‘Page scheduled.’
    'item_updated' => _x( 'Book updated.', 'cpt', PPHT_PREFIX ), //Label used when an item is updated. Default is ‘Post updated.’ / ‘Page updated.’
    'item_link' => _x( 'Blog Link', 'cpt', PPHT_PREFIX ), //Title for a navigation link block variation. Default is ‘Post Link’ / ‘Page Link’.
    'item_link_description' => _x( 'A link to the blog', 'cpt', PPHT_PREFIX ), //Description for a navigation link block variation. Default is ‘A link to a post.’ / ‘A link to a page.’
    'search_items' => _x( 'Search Blogs', 'cpt', PPHT_PREFIX ), // Text displayed for searching the posts of this type. It defaults to “Search Posts/Pages.
    'not_found' => _x( 'No blogs found', 'cpt', PPHT_PREFIX ), // The text shown when no posts were found in a search. By default, it displays “No posts/pages found.”
    'not_found_in_trash' => _x( 'No blogs found in Trash', 'cpt', PPHT_PREFIX ), // The text shown when no posts are in the trash. Defaults to “No posts/pages found in Trash.”
    'menu_name' => _x( 'Blogs', 'cpt', PPHT_PREFIX ), // Text used in the admin menu. Defaults to the value of name.
    'name_admin_bar' => _x( 'Blog', 'cpt', PPHT_PREFIX ), // Text used in the admin bar. Defaults to singular_name if it exists, otherwise the name value.
    'parent_item_colon' => _x( 'Parent Blog', 'cpt', PPHT_PREFIX ) // Text shown when displaying a post’s parent. This text is only used hierarchical post types and displays “Parent Page:” by default.
];

$post_type_args = [
    //The public argument sets whether a post type is publicly available on the admin dashboard or
    //front‐end of your website. By default, this is set to false, which will hide the post type from view.
    //The default settings for show_ui, exclude_from_search, publicl_queryable, and show_in_nav_menus
    // are inherited from this setting.
    'public' => true,
    //The show_ui argument determines whether or not to create a default UI in the WordPress admin
    //dashboard for managing this post type. It defaults to the value defined by the public argument.
    'show_ui' => true,
    //The publicly_queryable argument determines if the post type content can be publicly queried on
    //the front end of your website. If it is set to false, all front end queries for entries under the custom
    //post type will return a 404, since it is not allowed to be queried. It defaults to the value defined by
    //the public argument
    'publicly_queryable' => true,
    //The exclude_from_search argument allows you to exclude custom post type entries from the
    //WordPress search results. It defaults to the value defined by the public argument.
    'exclude_from_search' => false,
    //The show_in_nav_menus argument determines if the post type is available for selection in the
    //menu management feature of WordPress. It defaults to the value defined by the public argument.
    'show_in_nav_menus' => true,
    //The labels argument sets an array of labels that represents your post type in the admin dashboard.
    'labels' => $post_type_labels,
    //A short descriptive summary of what the post type is.
    'description' => _x( 'A blog post type', 'cpt', PPHT_PREFIX ),
    //The hierarchical argument allows you to define if the post type is hierarchical, like pages in
    //WordPress. A hierarchical post type allows you to have a tree‐like structure for your post‐type
    //content. By default, this argument is set to false.
    'hierarchical' => true,
    //The has_archive argument enables your post type to have an archive page. A post type archive
    //page is like the WordPress posts page, which displays the site’s latest blog entries. This allows you to
    //display a list of your post type entries, with the order being defined in your theme’s template file.
    'has_archive' => true,
    //The can_export argument determines if the post type content is available for export using the
    //built‐in WordPress export feature under Tools ➢ Export. This argument is set to true by default.
    'can_export' => true,
    //The taxonomies argument names an array of registered taxonomies to attach to the custom post type.
    //For example, you can pass in category and post_tag to attach the default Categories and Tags
    //taxonomies to your post type. By default, there are no taxonomies attached to a custom post type
    'taxonomies' => array( 'bloghunter_taxonomy' ),
    //The menu_position argument enables you to set the position in which the custom post type menu
    //shows in the admin menu. By default, new post types are displayed after the Comments menu.
    //To work, $show_in_menu must be true. Default null (at the bottom).
    /*
     *  5 – below Posts
        10 – below Media
        15 – below Links
        20 – below Pages
        25 – below comments
        60 – below first separator
        65 – below Plugins
        70 – below Users
        75 – below Tools
        80 – below Settings
        100 – below second separator
     * */
    'menu_position' => 80,
    //The menu_icon argument sets a custom menu icon for your post type. By default, the posts icon is used.
    //WordPress 3.8 introduced Dashicon support. To view a full list of the Dashicons available in
    //WordPress visit http://melchoyce.github.io/dashicons/. To set a specific Dashicon, simply
    //click the icon and copy the icon name to the menu _ icon value. For example, to use the Carrot
    //icon, set menu _ icon => 'dashicons‐carrot'.
    'menu_icon' => 'dashicons-chart-pie',
    
    //The show_in_menu argument determines whether or not to display the admin menu for your
    //post type. This argument accepts three values: true, false, or a string. The string can be either a
    //top‐level page, such as tools.php or edit.php?post_type=page. You can also set the string to the
    //menu_slug parameter to add the custom post type as a submenu item to an existing custom menu.
    //It defaults to the value defined by the show_ui argument.
    'show_in_menu' => true,
    //The show_in_admin_bar argument sets whether or not to show your custom post type in the
    //WordPress admin bar. It defaults to the value defined by the show_in_menu argument.
    'show_in_admin_bar' => true,
    // The string to use to build the read, edit, and delete capabilities.
    // May be passed as an array to allow for alternative plurals when using this argument as a base to construct the capabilities, e.g.
    // array('story', 'stories'). Default 'post'
    //---------'capability_type' => 'bloghunter',
    
    //The capabilities argument is an array of custom capabilities required for editing, deleting,
    //viewing, and publishing posts of this post type.
    /*---------'capabilities' => array(
        'edit_post' => 'edit_bloghunter',
        'read_post' => 'read_bloghunter',
        'delete_post' => 'delete_bloghunter',
        'create_posts' => 'create_bloghunter',
        'edit_posts' => 'edit_bloghunter',
        'edit_others_posts' => 'edit_others_bloghunter',
        'edit_private_posts' => 'edit_private_bloghunter',
        'edit_published_posts' => 'edit_published_bloghunter',
        'publish_posts' => 'publish_bloghunter',
        'read_private_posts' => 'read_private_bloghunter',
        'read' => 'read',
        'delete_posts' => 'delete_bloghunter',
        'delete_private_posts' => 'delete_private_bloghunter',
        'delete_published_posts' => 'delete_published_bloghunter',
        'delete_others_posts' => 'delete_others_bloghunter'
    ),*/
    
    //The query_var argument sets the query variable for posts of this post type. The default value is
    //true and is set to the $post_type value.
    'query_var' => true,
    
    // Whether to include the post type in the REST API. Set this to true for the post type to be available in the block editor.
    'show_in_rest' => false,
    //To change the base URL of REST API route. Default is $post_type.
    'rest_base' => '',
    //To change the namespace URL of REST API route. Default is wp/v2.
    'rest_namespace' => 'wp/v2',
    //REST API controller class name. Default is ‘WP_REST_Posts_Controller‘.
    'rest_controller_class' => '',
    //REST API controller class name. Default is ‘WP_REST_Autosaves_Controller‘.
    'autosave_rest_controller_class' => '',
    //REST API controller class name. Default is ‘WP_REST_Revisions_Controller‘.
    'revisions_rest_controller_class' => false,
    //A flag to direct the REST API controllers for autosave / revisions should be registered before/after the post type controller.
    'late_route_registration' => false,
    
    //Provide a callback function that sets up the meta boxes for the edit form. Do remove_meta_box() and add_meta_box() calls in the callback. Default null.
    'register_meta_box_cb' => null,
    //Whether to delete posts of this type when deleting a user.
    //If true, posts of this type belonging to the user will be moved to Trash when the user is deleted.
    //If false, posts of this type belonging to the user will *not* be trashed or deleted.
    //If not set (the default), posts are trashed if post type supports the 'author' feature. Otherwise posts are not trashed or deleted.
    //Default null.
    'delete_with_user' => null,
    //Array of blocks to use as the default initial state for an editor session. Each item should be an array containing block name and optional attributes.
    'template' => true,
    //Whether the block template should be locked if $template is set.
    //If set to 'all', the user is unable to insert new blocks, move existing blocks and delete blocks.
    //If set to 'insert', the user is able to move existing blocks but is unable to insert new blocks and delete blocks.
    //Default false.
    'template_lock' => false,
    //Whether to use the internal default meta capability handling.
    'map_meta_cap' => true,
    /*
     *  The rewrite argument creates the unique permalinks for this post type. This allows you to
        customize the post type slug in your URL. This argument can be set to true, false, or an array of
        values. If passing an array, it accepts the following values:
        ➤ slug —> Sets a custom permalink slug. Defaults to the $post_type value.
        ➤ with_front —> Sets whether your post type should use the front base from your permalink
        settings. For example, if you prefixed your permalinks with /blog, and with_front is set to
        true, your post type permalinks would include /blog at the beginning.
        ➤ pages —> Sets whether the permalink provides for pagination. Defaults to true.
        ➤ feeds —> Sets whether a feed permalink will be built for this post type. Defaults to
        has_archive value.
        By default, the rewrite argument is set to true and the $post_type is used as the slug.
     * */
    
    'rewrite' => array(
        //Customize the permastruct slug. Defaults to $post_type key.
        'slug' => 'bloghunter',
        //Whether the permastruct should be prepended with WP_Rewrite::$front.
        //Default true.
        'with_front' => false,
        //Whether the permastruct should provide for pagination. Default true.
        'pages' => true,
        //Whether the feed permastruct should be built for this post type.
        //Default is value of $has_archive.
        'feeds' => true,
        //Endpoint mask to assign. If not specified and permalink_epmask is set, inherits from $permalink_epmask. If not specified and permalink_epmask is not set, defaults to EP_PERMALINK.
        'ep_mask' => EP_PERMALINK,
    ),
    //The supports argument allows you to define what meta boxes appear on the screen when creating or
    //editing a new post type entry. This defaults to the title and editor. Several options are available
    /*
     * ➤ title —> Sets the post title.
       ➤ editor —> Displays the content editor on the post editing screen with a media uploader.
        ➤ author —> Selects box to choose the author of the post.
        ➤ thumbnail —> Featured image meta box for the post.
        ➤ excerpt —> Displays an excerpt editor on the post type editing screen.
        ➤ comments —> Sets whether comments will be enabled for posts of this type.
        ➤ trackbacks —> Sets whether trackbacks and pingbacks will be enabled for posts of this type.
        ➤ custom‐fields —> Displays the custom field editing area meta box.
        ➤ page‐attributes —> Displays the attributes box for choosing the post order. The
            hierarchical argument must be set to true for this to work.
        ➤ revisions —> Displays the post revisions meta box.
        ➤ post‐formats —> Displays the post formats meta box with registered post formats.
    
        To disable the title and editor defaults, set the supports argument to false.
     * */
    'supports' => array( 'title', 'editor', 'author', 'thumbnail', 'comments' )
];

$taxonomy_labels = [
    'name' => _x( 'Genres', 'cpt', PPHT_PREFIX ),
    'singular_name' => _x( 'Genre', 'cpt', PPHT_PREFIX ),
    'menu_name' => _x( 'Genres', 'cpt', PPHT_PREFIX ),
    'name_admin_bar' => _x( 'Genre', 'cpt', PPHT_PREFIX ),
    'search_items' => _x( 'Search Genres', 'cpt', PPHT_PREFIX ),
    'popular_items' => _x( 'Popular Genres', 'cpt', PPHT_PREFIX ),
    'all_items' => _x( 'All Genres', 'cpt', PPHT_PREFIX ),
    'edit_item' => _x( 'Edit Genre', 'cpt', PPHT_PREFIX ),
    'view_item' => _x( 'View Genre', 'cpt', PPHT_PREFIX ),
    'update_item' => _x( 'Update Genre', 'cpt', PPHT_PREFIX ),
    'add_new_item' => _x( 'Add New Genre', 'cpt', PPHT_PREFIX ),
    'new_item_name' => _x( 'New Genre Name', 'cpt', PPHT_PREFIX ),
    'not_found' => _x( 'No genres found.', 'cpt', PPHT_PREFIX ),
    'no_terms' => _x( 'No genres', 'cpt', PPHT_PREFIX ),
    'items_list_navigation' => _x( 'Genres list navigation', 'cpt', PPHT_PREFIX ),
    'items_list' => _x( 'Genres list', 'cpt', PPHT_PREFIX ),
    // Hierarchical only.
    'select_name' => _x( 'Select Genre', 'cpt', PPHT_PREFIX ),
    'parent_item' => _x( 'Parent Genre', 'cpt', PPHT_PREFIX ),
    'parent_item_colon' => _x( 'Parent Genre:', 'cpt', PPHT_PREFIX )
];

$taxanomy_args = [
    //can contain subcategories
    'hierarchical' => true,
    // Text labels.
    'labels' => $taxonomy_labels,
    // If the query_var argument is set to
    //false, then no queries can be made against the taxonomy; if true, then the taxonomy name (with
    //dashes replacing spaces) is used as a query variable in URL strings. Specifying a string value for the
    //query_var overrides the default. For example, query_var => 'strength' would permit URL
    //strings of the form example.com/?strength=weapons to be used to select content from the custom
    //taxonomy.
    'query_var' => true,
    'show_in_rest' => true,
    'show_ui' => true,
    'show_in_nav_menus' => true,
    'show_tagcloud' => true,
    'show_admin_column' => true,
    //This tells WordPress whether or not
    //you want a pretty permalink when viewing your custom taxonomy. By setting this to true, you
    //can access your custom taxonomy posts such as example.com/type/weapons rather than the ugly
    //method of example.com/?type=weapons.
    'rewrite' => [
        'slug' => 'genre',
        'with_front' => false,
        'hierarchical' => false,
        'ep_mask' => EP_NONE
    ],

];

