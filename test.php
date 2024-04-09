<?php
declare(strict_types=1);

use function DHT\Helpers\dht_print_r;

//dht_print_r('sssss');

add_action( 'init', 'dht_register_my_post_types', 99 );
function dht_register_my_post_types() {
    $labels = array(
        'name' => 'Blogs', // General name for the post type, which is usually plural. Used in the WordPress admin  and by other plugins and themes.
        'singular_name' => 'Blog', // The singular version of the name for the post type. It is also used in the WordPress admin and by other plugins and themes
        'add_new' => 'Add New Blog', // The label for the Add New submenu item. The text defaults to “Add New.”
        'add_new_item' => 'Add New Blog', // Used as the header text on the main post listing page to add a new post. By default, the text is “Add New Post/Page.”
        'edit_item' => 'Edit Blog', // Used as the text for editing an individual post. Defaults to “Edit Post/Page.”
        'new_item' => 'New Blog', // Text for creating a new post. By default, it is set to “New Post/Page.”
        'all_items' => 'All Blogs', //Text used for the all items text in the menu. This is the text displayed directly below the top‐level menu name. Defaults to the value of name.
        'view_item' => 'View Blog', // Text for viewing a single post entry. Defaults to “View Post/Page.”
        'search_items' => 'Search Blogs', // Text displayed for searching the posts of this type. It defaults to “Search Posts/Pages.
        'not_found' => 'No blogs found', // The text shown when no posts were found in a search. By default, it displays “No posts/pages found.”
        'not_found_in_trash' => 'No blogs found in Trash', // The text shown when no posts are in the trash. Defaults to “No posts/pages found in Trash.”
        'menu_name' => 'Blogs', // Text used in the admin menu. Defaults to the value of name.
        'name_admin_bar' => 'Blog', // Text used in the admin bar. Defaults to singular_name if it exists, otherwise the name value.
        'parent_item_colon' => 'Parent Blog' // Text shown when displaying a post’s parent. This text is only used hierarchical post types and displays “Parent Page:” by default.
    );
    
    $args = array(
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
        'labels' => $labels,
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
        //--------'menu_icon' => 'dashicons‐carrot',
        
        //The show_in_menu argument determines whether or not to display the admin menu for your
        //post type. This argument accepts three values: true, false, or a string. The string can be either a
        //top‐level page, such as tools.php or edit.php?post_type=page. You can also set the string to the
        //menu_slug parameter to add the custom post type as a submenu item to an existing custom menu.
        //It defaults to the value defined by the show_ui argument.
        'show_in_menu' => true,
        //The show_in_admin_bar argument sets whether or not to show your custom post type in the
        //WordPress admin bar. It defaults to the value defined by the show_in_menu argument.
        'show_in_admin_bar' => true,
        //The capability_type argument names a string or an array of the capabilities for this post type.
        //By default, the value is set to post.
        //-------'capability_type' => 'post',
        
        //The capabilities argument is an array of custom capabilities required for editing, deleting,
        //viewing, and publishing posts of this post type.
        //--------'capabilities' => array(),
        
        //The query_var argument sets the query variable for posts of this post type. The default value is
        //true and is set to the $post_type value.
        'query_var' => true,
        // Whether to include the post type in the REST API. Set this to true for the post type to be available in the block editor.
        'show_in_rest' => false,
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
        
        'rewrite' => array( 'slug' => 'bloghunter' ),
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
    );
    register_post_type( 'bloghunter', $args );
}

add_action( 'init', 'prowp_define_product_type_taxonomy' );
function prowp_define_product_type_taxonomy() {
    register_taxonomy(
        'bloghunter_taxonomy',
        'bloghunter',
        array(
            //can contain subcategories
            'hierarchical' => true,
            'label' => 'Blog Categories',
            // If the query_var argument is set to
            //false, then no queries can be made against the taxonomy; if true, then the taxonomy name (with
            //dashes replacing spaces) is used as a query variable in URL strings. Specifying a string value for the
            //query _ var overrides the default. For example, query_var => 'strength' would permit URL
            //strings of the form example.com/?strength=weapons to be used to select content from the custom
            //taxonomy.
            'query_var' => true,
            //This tells WordPress whether or not
            //you want a pretty permalink when viewing your custom taxonomy. By setting this to true, you
            //can access your custom taxonomy posts such as example.com/type/weapons rather than the ugly
            //method of example.com/?type=weapons.
            'rewrite' => true
        )
    );
}