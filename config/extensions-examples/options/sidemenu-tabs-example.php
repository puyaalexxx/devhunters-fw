<?php

if ( !defined( 'PPHT_MAIN' ) ) die( 'Forbidden' );

$options = [
    'id' => PPHT_PREFIX . '-side-menu-settings',
    'type' => 'sidemenu',
    'subtype' => 'tabs', //make it tabs
    'attr' => array( 'class' => 'custom-class', 'data-foo' => 'bar' ),
    //pages are opened as tabs via their ids
    'pages' => [
        [
            'id' => 'general-settings',
            'title' => 'General Settings',
            'icon' => 'dashicons-before dashicons-admin-settings',
            'options' => []
        ],
        [
            'id' => 'modules',
            'title' => 'Modules',
            'icon' => 'dashicons-before dashicons-admin-page',
            'pages' => [
                [
                    'id' => 'text-module',
                    'title' => 'Text Module',
                    'options' => []
                ],
                [
                    'id' => 'contact-form-module',
                    'title' => 'Contact Form Module',
                    'options' => []
                ],
                [
                    'id' => 'blog-module',
                    'title' => 'Blog Module',
                    'options' => []
                ],
            ],
        ],
        [
            'id' => 'tools-settings',
            'title' => 'Tools',
            'icon' => 'http://testhunters.local/wp-content/plugins/devhunters-fw/assets/images/devhuntersmain-logo-dashmenu.png',
            'options' => []
        ],
    ]
];