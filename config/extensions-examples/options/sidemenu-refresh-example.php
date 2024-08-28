<?php

if ( !defined( 'PPHT_MAIN' ) ) die( 'Forbidden' );

$options = [
    'id' => PPHT_PREFIX . '-general-side-menu-settings',
    'type' => 'sidemenu',
    'attr' => array( 'class' => 'custom-class', 'data-foo' => 'bar' ),
    //pages match the registered dashboard menu items or any otherlinks
    'pages' => [
        [
            'id' => 'general-settings',
            'title' => 'General Settings',
            'icon' => 'dashicons-before dashicons-admin-settings',
            'page_link' => admin_url( 'admin.php?page=ppht-main-settings' ),
            'options' => [
                ////options here
                //input field
                [
                    'id' => 'input_field22',
                    'type' => 'input',
                    'title' => _x( 'Input field', 'options', PPHT_PREFIX ),
                    'value' => 'default value sss',
                    'subtype' => '', //(can be email, password...)
                    
                    'attr' => array( 'class' => 'custom-class', 'data-foo' => 'bar' ),
                    'description' => _x( 'Input description', 'options', PPHT_PREFIX ),
                    'tooltip' => _x( 'This field is used to add some text', 'options', PPHT_PREFIX ),
                    'divider' => true
                ]
            ]
        ],
        [
            'id' => 'modules',
            'title' => 'Modules',
            'icon' => 'dashicons-before dashicons-admin-page',
            'page_link' => admin_url( 'admin.php?page=ppht-text-module-settings' ),
            'pages' => [
                [
                    'id' => 'text-module',
                    'title' => 'Text Module',
                    'page_link' => admin_url( 'admin.php?page=ppht-text-module-settings' ),
                ],
                [
                    'id' => 'contact-form-module',
                    'title' => 'Contact Form Module',
                    'page_link' => admin_url( 'admin.php?page=ppht-contact-module-settings' ),
                ],
                [
                    'id' => 'blog-module',
                    'title' => 'Blog Module',
                    'page_link' => admin_url( 'admin.php?page=ppht-blog-module-settings' ),
                ],
            ],
        ],
        [
            'id' => 'tools-settings',
            'title' => 'Groups',
            'icon' => 'http://testhunters.local/wp-content/plugins/devhunters-fw/assets/images/devhuntersmain-logo-dashmenu.png',
            'page_link' => admin_url( 'admin.php?page=ppht-tools-settings' ),
        ],
    ]
];