<?php

if ( !defined( 'PPHT_MAIN' ) ) die( 'Forbidden' );

[
    //addable box group
    [
        'id' => 'settings-addable',
        'type' => 'addable-box',
        'title' => _x( 'Addable Box Group', 'options', PPHT_PREFIX ),
        'sortable' => true,
        'limit' => -1, // -1 for unlimitted items
        'value' => [],
        'options' => [
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
                'divider' => false
            ]
        ],
        'attr' => array( 'class' => 'custom-class', 'data-foo' => 'bar' ),
        'description' => _x( 'Addable box description', 'options', PPHT_PREFIX ),
        'tooltip' => _x( 'This field is used to add some text', 'options', PPHT_PREFIX ),
        'divider' => true
    ],
    
    //tabs group
    [
        'id' => 'settings-tabs-fullwidth',
        'type' => 'tabs',
        'title' => _x( 'Tabs group fullsize', 'options', PPHT_PREFIX ),
        'value' => [],
        'fullwidth' => true,
        'options' => [
            //group 1
            [
                'title' => _x( 'Group 1', 'options', PPHT_PREFIX ),
                'options' => [
                    [
                        'id' => 'input_field_url',
                        'type' => 'input',
                        'title' => _x( 'URL field', 'options', PPHT_PREFIX ),
                        'label' => _x( 'URL label', 'options', PPHT_PREFIX ),
                        'value' => '',
                        
                        'attr' => array( 'class' => 'custom-class', 'data-foo' => 'bar' ),
                        'description' => _x( 'Input description', 'options', PPHT_PREFIX ),
                        'tooltip' => _x( 'This field is used to add some text', 'options', PPHT_PREFIX ),
                        'divider' => true
                    ],
                    [
                        'id' => 'input_field_sss',
                        'type' => 'input',
                        'title' => _x( 'test field', 'options', PPHT_PREFIX ),
                        'label' => _x( 'test label', 'options', PPHT_PREFIX ),
                        'value' => '',
                        
                        'attr' => array( 'class' => 'custom-class', 'data-foo' => 'bar' ),
                        'tooltip' => _x( 'This field is used to add some text', 'options', PPHT_PREFIX ),
                        'description' => _x( 'test description', 'options', PPHT_PREFIX ),
                    ]
                ]
            ],
            //group 2
            [
                'title' => _x( 'Group 2', 'options', PPHT_PREFIX ),
                'options' => [
                    [
                        'id' => 'input_field_bbb',
                        'type' => 'input',
                        'title' => _x( 'URL field', 'options', PPHT_PREFIX ),
                        'label' => _x( 'URL label', 'options', PPHT_PREFIX ),
                        'value' => '',
                        
                        'attr' => array( 'class' => 'custom-class', 'data-foo' => 'bar' ),
                        'description' => _x( 'Input description', 'options', PPHT_PREFIX ),
                    ]
                ]
            ]
        ],
        'attr' => array( 'class' => 'custom-class', 'data-foo' => 'bar' ),
        'description' => _x( 'Tabs description', 'options', PPHT_PREFIX ),
        'tooltip' => _x( 'This field is used to add some text', 'options', PPHT_PREFIX ),
        'divider' => true
    ],
    
    //accordion group
    [
        'id' => 'settings-accordion',
        'type' => 'accordion',
        'title' => _x( 'Accordion Groups', 'options', PPHT_PREFIX ),
        'value' => [],
        'options' => [
            //group 1
            [
                'title' => _x( 'Group 1', 'options', PPHT_PREFIX ),
                'options' => [
                    [
                        'id' => 'input_field_url',
                        'type' => 'input',
                        'title' => _x( 'URL field', 'options', PPHT_PREFIX ),
                        'label' => _x( 'URL label', 'options', PPHT_PREFIX ),
                        'value' => '',
                        
                        'attr' => array( 'class' => 'custom-class', 'data-foo' => 'bar' ),
                        'description' => _x( 'Input description', 'options', PPHT_PREFIX ),
                        'divider' => true
                    ],
                    [
                        'id' => 'input_field_sss',
                        'type' => 'input',
                        'title' => _x( 'test field', 'options', PPHT_PREFIX ),
                        'label' => _x( 'test label', 'options', PPHT_PREFIX ),
                        'value' => '',
                        
                        'attr' => array( 'class' => 'custom-class', 'data-foo' => 'bar' ),
                        'description' => _x( 'test description', 'options', PPHT_PREFIX ),
                    ]
                ]
            ],
            //group 2
            [
                'title' => _x( 'Group 2', 'options', PPHT_PREFIX ),
                'options' => [
                    [
                        'id' => 'input_field_bbb',
                        'type' => 'input',
                        'title' => _x( 'URL field', 'options', PPHT_PREFIX ),
                        'label' => _x( 'URL label', 'options', PPHT_PREFIX ),
                        'value' => '',
                        
                        'attr' => array( 'class' => 'custom-class', 'data-foo' => 'bar' ),
                        'description' => _x( 'Input description', 'options', PPHT_PREFIX ),
                        'divider' => true
                    ],
                    
                    //icon field
                    [
                        'id' => 'icon_field',
                        'type' => 'icon',
                        'title' => _x( 'Icon field', 'options', PPHT_PREFIX ),
                        'label' => _x( 'Icon label', 'options', PPHT_PREFIX ),
                        'value' => [
                            'icon-type' => 'dashicons',
                            'icon-class' => 'dashicons dashicons-universal-access-alt',
                            'icon-code' => '\f507'
                        ],
                        
                        'attr' => array( 'class' => 'custom-class', 'data-foo' => 'bar' ),
                        'description' => _x( 'Icon description', 'options', PPHT_PREFIX ),
                        'tooltip' => _x( 'This field is used to add some text', 'options', PPHT_PREFIX ),
                    ],
                ]
            ]
        ],
        'attr' => array( 'class' => 'custom-class', 'data-foo' => 'bar' ),
        'description' => _x( 'Accordion description', 'options', PPHT_PREFIX ),
        'tooltip' => _x( 'This field is used to add some text', 'options', PPHT_PREFIX ),
        'divider' => true
    ],
    
    
    //tabs group
    [
        'id' => 'settings-tabs',
        'type' => 'tabs',
        'title' => _x( 'Tabs Groups', 'options', PPHT_PREFIX ),
        'value' => [],
        'fullwidth' => false,
        'options' => [
            //group 1
            [
                'title' => _x( 'Group 1', 'options', PPHT_PREFIX ),
                'options' => [
                    [
                        'id' => 'input_field_url',
                        'type' => 'input',
                        'title' => _x( 'URL field', 'options', PPHT_PREFIX ),
                        'label' => _x( 'URL label', 'options', PPHT_PREFIX ),
                        'value' => '',
                        
                        'attr' => array( 'class' => 'custom-class', 'data-foo' => 'bar' ),
                        'description' => _x( 'Input description', 'options', PPHT_PREFIX ),
                        'divider' => true
                    ],
                    [
                        'id' => 'input_field_sss',
                        'type' => 'input',
                        'title' => _x( 'test field', 'options', PPHT_PREFIX ),
                        'label' => _x( 'test label', 'options', PPHT_PREFIX ),
                        'value' => '',
                        
                        'attr' => array( 'class' => 'custom-class', 'data-foo' => 'bar' ),
                        'description' => _x( 'test description', 'options', PPHT_PREFIX ),
                    ]
                ]
            ],
            //group 2
            [
                'title' => _x( 'Group 2', 'options', PPHT_PREFIX ),
                'options' => [
                    [
                        'id' => 'input_field_bbb',
                        'type' => 'input',
                        'title' => _x( 'URL field', 'options', PPHT_PREFIX ),
                        'label' => _x( 'URL label', 'options', PPHT_PREFIX ),
                        'value' => '',
                        
                        'attr' => array( 'class' => 'custom-class', 'data-foo' => 'bar' ),
                        'description' => _x( 'Input description', 'options', PPHT_PREFIX ),
                    ]
                ]
            ]
        ],
        'attr' => array( 'class' => 'custom-class', 'data-foo' => 'bar' ),
        'description' => _x( 'Tabs description', 'options', PPHT_PREFIX ),
        'tooltip' => _x( 'This field is used to add some text', 'options', PPHT_PREFIX ),
        'divider' => true
    ],
    
    
    //group
    [
        'id' => 'settings-group',
        'type' => 'group',
        'title' => _x( 'Group Fields', 'options', PPHT_PREFIX ),
        'value' => [],
        'options' => [
            //input field - subtype url
            [
                'id' => 'input_field_url',
                'type' => 'input',
                'title' => _x( 'URL field', 'options', PPHT_PREFIX ),
                'label' => _x( 'URL label', 'options', PPHT_PREFIX ),
                'value' => '',
                'subtype' => 'url',
                
                'attr' => array( 'class' => 'custom-class', 'data-foo' => 'bar' ),
                'description' => _x( 'Input description', 'options', PPHT_PREFIX ),
                'tooltip' => _x( 'This field is used to add some text', 'options', PPHT_PREFIX ),
                'divider' => true
            ],
            //input field
            [
                'id' => 'input_field22',
                'type' => 'input',
                'title' => _x( 'Input field', 'options', PPHT_PREFIX ),
                'label' => _x( 'Input label', 'options', PPHT_PREFIX ),
                'value' => 'default value sss',
                'subtype' => '', //(can be email, password...)
                
                'attr' => array( 'class' => 'custom-class', 'data-foo' => 'bar' ),
                'description' => _x( 'Input description', 'options', PPHT_PREFIX ),
                'tooltip' => _x( 'This field is used to add some text', 'options', PPHT_PREFIX ),
                'divider' => true
            ]
        ],
        'attr' => array( 'class' => 'custom-class', 'data-foo' => 'bar' ),
        'description' => _x( 'Group description', 'options', PPHT_PREFIX ),
        'tooltip' => _x( 'This field is used to add some text', 'options', PPHT_PREFIX ),
        'divider' => true
    ]
];