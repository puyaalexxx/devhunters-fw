<?php
declare( strict_types = 1 );

if ( !defined( 'PPHT_MAIN' ) ) die( 'Forbidden' );

$sidebars = [
    [
        'name' => _x( 'First Sidebar', 'sidebar settings', PPHT_PREFIX ),
        'id' => 'first-sidebar',
        'description' => _x( 'Add widgets here to appear in your First sidebar.', 'sidebar settings', PPHT_PREFIX ),
        'class' => '',
        'before_widget' => '<section id="%1$s" class="widget %2$s">',
        'after_widget' => '</section>',
        'before_title' => '<h2 class="widget-title">',
        'after_title' => '</h2>',
        'before_sidebar' => '',
        'after_sidebar' => '',
        'show_in_rest' => false
    ],
    [
        'name' => _x( 'Second Sidebar', 'sidebar settings', PPHT_PREFIX ),
        'id' => 'second-sidebar',
        'description' => _x( 'Add widgets here to appear in your First sidebar.', 'sidebar settings', PPHT_PREFIX ),
        'class' => '',
        'before_widget' => '<section id="%1$s" class="widget %2$s">',
        'after_widget' => '</section>',
        'before_title' => '<h2 class="widget-title">',
        'after_title' => '</h2>',
        'before_sidebar' => '',
        'after_sidebar' => '',
        'show_in_rest' => false
    ]
];