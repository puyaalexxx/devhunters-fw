<?php

if ( !defined( 'PPHT_MAIN' ) ) die( 'Forbidden' );

[
    //typography field
    [
        'id' => 'typography id',
        'type' => 'typography',
        'title' => _x( 'Typography field', 'options', PPHT_PREFIX ),
        'value' => [], //['font-type' => 'divi', 'font-path' => 'font url', 'font' => 'dht-Danfo']
        'upload' => false,
        
        'attr' => array( 'class' => 'custom-class', 'data-foo' => 'bar' ),
        'description' => _x( 'Typography description', 'options', PPHT_PREFIX ),
        'tooltip' => _x( 'This field is used to add some text', 'options', PPHT_PREFIX ),
        'divider' => true
    ],
    
    //icon field
    [
        'id' => 'icon_field',
        'type' => 'icon',
        'title' => _x( 'Icon field', 'options', PPHT_PREFIX ),
        'value' => [
            'icon-type' => 'dashicons',
            'icon-class' => 'dashicons dashicons-universal-access-alt',
            'icon-code' => '\f507'
        ],
        
        'attr' => array( 'class' => 'custom-class', 'data-foo' => 'bar' ),
        'description' => _x( 'Icon description', 'options', PPHT_PREFIX ),
        'tooltip' => _x( 'This field is used to add some text', 'options', PPHT_PREFIX ),
        'divider' => true
    ],
    
    //upload gallery
    [
        'id' => 'upload_gallery_field',
        'type' => 'upload-gallery',
        'title' => _x( 'Upload Gallery field', 'options', PPHT_PREFIX ),
        'value' => [ 14, 12 ], //attachment ids
        
        'attr' => array( 'class' => 'custom-class', 'data-foo' => 'bar' ),
        'description' => _x( 'Upload Gallery description', 'options', PPHT_PREFIX ),
        'tooltip' => _x( 'This field is used to add some text', 'options', PPHT_PREFIX ),
        'divider' => true
    ],
    //upload
    [
        'id' => 'upload_field',
        'type' => 'upload',
        'title' => _x( 'Upload field', 'options', PPHT_PREFIX ),
        'value' => [
            'item' => 'http://testhunters.local/wp-content/uploads/2024/05/pdf-sample.pdf',
            'item_id' => 101
        ],
        //Image: 'image' - This type displays only image files.
        //Video: 'video' - This type displays only video files.
        //Audio: 'audio' - This type displays only audio files.
        //Document: 'document' - This type displays document files such as PDFs.
        //Application: 'application' - This type displays application files.
        //PDF: 'application/pdf' - This type displays pdf files.
        'file_type' => 'application/pdf',
        
        'attr' => array( 'class' => 'custom-class', 'data-foo' => 'bar' ),
        'description' => _x( 'Upload description', 'options', PPHT_PREFIX ),
        'tooltip' => _x( 'This field is used to add some text', 'options', PPHT_PREFIX ),
        'divider' => true
    ],
    //upload image
    [
        'id' => 'upload_image_field',
        'type' => 'upload-image',
        'title' => _x( 'Upload Image field', 'options', PPHT_PREFIX ),
        'value' => [
            'image' => 'http://testhunters.local/wp-content/uploads/2024/04/167113823-3f0757ff-c7c2-44d0-a1e9-0b006772b39a.jpeg',
            'image_id' => 12
        ],
        
        'attr' => array( 'class' => 'custom-class', 'data-foo' => 'bar' ),
        'description' => _x( 'Upload Image description', 'options', PPHT_PREFIX ),
        'tooltip' => _x( 'This field is used to add some text', 'options', PPHT_PREFIX ),
        'divider' => true
    ],
    
    //borders
    [
        'id' => 'borders_field',
        'type' => 'borders',
        'title' => _x( 'Borders field', 'options', PPHT_PREFIX ),
        'value' => [
            'top' => 20,
            'right' => 30,
            'bottom' => 10,
            'left' => 0,
            'style' => 'dotted',
            'color' => '#0ce9ed'
        ],
        'palettes' => [ '#b7g74e', '#0567ed', '#941567' ],
        
        'attr' => array( 'class' => 'custom-class', 'data-foo' => 'bar' ),
        'description' => _x( 'Borders description', 'options', PPHT_PREFIX ),
        'tooltip' => _x( 'This field is used to add some text', 'options', PPHT_PREFIX ),
        'divider' => true
    ],
    
    //multi options -> load all posts from the start without ajax
    [
        'id' => 'multioptions_group_no_ajax',
        'type' => 'multi-options',
        'title' => _x( 'Multi Options Get All Posts Without Ajax field', 'options', PPHT_PREFIX ),
        'value' => [],
        'ajax' => false,
        'ajax-action' => '',
        'minimumInputLength' => 3,
        'choices' => ppht_get_my_posts(),
        'attr' => array( 'class' => 'custom-class', 'data-foo' => 'bar' ),
        'description' => _x( 'Multi Options description', 'options', PPHT_PREFIX ),
        'tooltip' => _x( 'This field is used to add some text', 'options', PPHT_PREFIX ),
        'divider' => true
    ],
    //multi options
    [
        'id' => 'multioptions_group',
        'type' => 'multi-options',
        'title' => _x( 'Multi Options field', 'options', PPHT_PREFIX ),
        'value' => [ 'value2', 'value4' ],
        'ajax' => false,
        'ajax-action' => '',
        'minimumInputLength' => 0,
        'choices' => [
            'value1' => _x( 'Option 1', 'options', PPHT_PREFIX ),
            'value2' => _x( 'Option 2', 'options', PPHT_PREFIX ),
            'value3' => _x( 'Option 3', 'options', PPHT_PREFIX ),
            'value4' => _x( 'Option 4', 'options', PPHT_PREFIX ),
        ],
        'attr' => array( 'class' => 'custom-class', 'data-foo' => 'bar' ),
        'description' => _x( 'Multi Options description', 'options', PPHT_PREFIX ),
        'tooltip' => _x( 'This field is used to add some text', 'options', PPHT_PREFIX ),
        'divider' => true
    ],
    
    //radio image
    [
        'id' => 'radio_image_field',
        'type' => 'radio-image',
        'title' => _x( 'Radio Image field', 'options', PPHT_PREFIX ),
        'value' => 'value2', // radio field value to be checked
        'choices' => [
            'value1' => [
                'label' => _x( 'Radio Image 1', 'options', PPHT_PREFIX ),
                'image' => PPHT_ASSETS_URI . 'images/demo.png'
            ],
            'value2' => [
                'label' => _x( 'Radio Image 2', 'options', PPHT_PREFIX ),
                'image' => PPHT_ASSETS_URI . 'images/demo.png'
            ],
            'value3' => [
                'label' => _x( 'Radio Image 2', 'options', PPHT_PREFIX ),
                'image' => ''
            ],
        ],
        
        'attr' => array( 'class' => 'custom-class', 'data-foo' => 'bar' ),
        'description' => _x( 'Radio Image description', 'options', PPHT_PREFIX ),
        'tooltip' => _x( 'This field is used to add some text', 'options', PPHT_PREFIX ),
        'divider' => true
    ],
    
    //spacing
    [
        'id' => 'spacing_field',
        'type' => 'spacing',
        'title' => _x( 'Spacing field', 'options', PPHT_PREFIX ),
        'value' => [
            'top' => 20,
            'right' => 30,
            'bottom' => 10,
            'left' => 0,
            'size' => 'em'
        ], // sizing "px", "percentage", "em", "rem", "vw", "vh"
        
        'attr' => array( 'class' => 'custom-class', 'data-foo' => 'bar' ),
        'description' => _x( 'Spacing description', 'options', PPHT_PREFIX ),
        'tooltip' => _x( 'This field is used to add some text', 'options', PPHT_PREFIX ),
        'divider' => true
    ],
    //range slider field - subtype -> range
    [
        'id' => 'range2_field',
        'type' => 'range-slider',
        'title' => _x( 'Range Slider Range field', 'options', PPHT_PREFIX ),
        'range' => true, //default false
        'min' => 5,
        'max' => 50,
        'value' => [ 20, 30 ],
        
        'attr' => array( 'class' => 'custom-class', 'data-foo' => 'bar' ),
        'description' => _x( 'Range Slider Range description', 'options', PPHT_PREFIX ),
        'tooltip' => _x( 'This field is used to add some text', 'options', PPHT_PREFIX ),
        'divider' => true
    ],
    //range slider field
    [
        'id' => 'range_field',
        'type' => 'range-slider',
        'title' => _x( 'Range Slider field', 'options', PPHT_PREFIX ),
        'range' => false, //default false
        'min' => 5,
        'max' => 50,
        'value' => 20,
        
        'attr' => array( 'class' => 'custom-class', 'data-foo' => 'bar' ),
        'description' => _x( 'Range Slider description', 'options', PPHT_PREFIX ),
        'tooltip' => _x( 'This field is used to add some text', 'options', PPHT_PREFIX ),
        'divider' => true
    ],
    //datetimepicker field
    [
        'id' => 'datetimepicker_field',
        'type' => 'datetimepicker',
        'title' => _x( 'DateTimePicker field', 'options', PPHT_PREFIX ),
        'date-format' => 'yy-mm-dd',
        'time-format' => 'HH:mm:ss',
        'value' => '2024-05-14 08:11:00',
        
        'attr' => array( 'class' => 'custom-class', 'data-foo' => 'bar' ),
        'description' => _x( 'DateTimePicker description', 'options', PPHT_PREFIX ),
        'tooltip' => _x( 'This field is used to add some text', 'options', PPHT_PREFIX ),
        'divider' => true
    ],
    //timepicker field
    [
        'id' => 'timepicker_field',
        'type' => 'timepicker',
        'title' => _x( 'TimePicker field', 'options', PPHT_PREFIX ),
        'format' => 'HH:mm:ss',
        'value' => '02:31:47',
        
        'attr' => array( 'class' => 'custom-class', 'data-foo' => 'bar' ),
        'description' => _x( 'TimePicker description', 'options', PPHT_PREFIX ),
        'tooltip' => _x( 'This field is used to add some text', 'options', PPHT_PREFIX ),
        'divider' => true
    ],
    //datepicker field
    [
        'id' => 'datepicker_field',
        'type' => 'datepicker',
        'title' => _x( 'Datepicker field', 'options', PPHT_PREFIX ),
        'format' => 'yy-mm-dd',
        'value' => '2024-05-15',
        
        'attr' => array( 'class' => 'custom-class', 'data-foo' => 'bar' ),
        'description' => _x( 'Datepicker description', 'options', PPHT_PREFIX ),
        'tooltip' => _x( 'This field is used to add some text', 'options', PPHT_PREFIX ),
        'divider' => true
    ],
    //colorpicker
    //default
    [
        'id' => 'colorpicker_field',
        'type' => 'colorpicker',
        'title' => _x( 'Colorpicker', 'options', PPHT_PREFIX ),
        'subtype' => 'default', //or default
        'palettes' => [ '#ba4e4e', '#0ce9ed', '#941940' ],
        'value' => '#0ce9ed',
        
        'attr' => array( 'class' => 'custom-class', 'data-foo' => 'bar' ),
        'description' => _x( 'Colorpicker description', 'options', PPHT_PREFIX ),
        'tooltip' => _x( 'This field is used to add some text', 'options', PPHT_PREFIX ),
        'divider' => true
    ],
    //rgba
    [
        'id' => 'colorpicker_field_rgba',
        'type' => 'colorpicker',
        'title' => _x( 'Colorpicker RGBA', 'options', PPHT_PREFIX ),
        'subtype' => 'rgba', //or default
        'palettes' => [
            'rgba(0, 0, 0, 0.65)',
            'rgba(255, 255, 255, 0.8)',
            'rgba(255, 0, 0, 1)',
            'rgba(0, 255, 0, 0.5)',
            'rgba(0, 0, 255, 0.75)'
        ],
        'value' => 'rgba(255, 255, 255, 0.8)',
        
        'attr' => array( 'class' => 'custom-class', 'data-foo' => 'bar' ),
        'description' => _x( 'Colorpicker description', 'options', PPHT_PREFIX ),
        'tooltip' => _x( 'This field is used to add some text', 'options', PPHT_PREFIX ),
        'divider' => true
    ],
    
    //ace editor field
    //css
    [
        'id' => 'ace_editor2',
        'type' => 'ace-editor',
        'title' => _x( 'Ace Editor CSS', 'options', PPHT_PREFIX ),
        'value' => '.css{ display:block; }',
        'mode' => 'css', //or javascript
        'height' => 300,
        
        'attr' => array( 'class' => 'custom-class', 'data-foo' => 'bar' ),
        'description' => _x( 'Ace Editor CSS description', 'options', PPHT_PREFIX ),
        'tooltip' => _x( 'This field is used to add some text', 'options', PPHT_PREFIX ),
        'divider' => true
    ],
    //javascript
    [
        'id' => 'ace_editor',
        'type' => 'ace-editor',
        'title' => _x( 'Ace Editor Javascript', 'options', PPHT_PREFIX ),
        'value' => 'console.log("hello")',
        'mode' => 'javascript', //or css
        'height' => 300,
        
        'attr' => array( 'class' => 'custom-class', 'data-foo' => 'bar' ),
        'description' => _x( 'Ace Editor Javascript description', 'options', PPHT_PREFIX ),
        'tooltip' => _x( 'This field is used to add some text', 'options', PPHT_PREFIX ),
        'divider' => true
    ],
    
    //multiinput
    [
        'id' => 'multiinput_field2',
        'type' => 'multi-input',
        'title' => _x( 'Multi Input field', 'options', PPHT_PREFIX ),
        'value' => [ 'default value' ],
        'limit' => 5,
        
        'attr' => array( 'class' => 'custom-class', 'data-foo' => 'bar' ),
        'description' => _x( 'Multi Input description', 'options', PPHT_PREFIX ),
        'tooltip' => _x( 'This field is used to add some text', 'options', PPHT_PREFIX ),
        'divider' => true
    ],
    //dropdown-multiple groups
    [
        'id' => 'dropdown_field_multiple_group',
        'type' => 'dropdown-multiple',
        'title' => _x( 'Dropdown Multiple field', 'options', PPHT_PREFIX ),
        'value' => [ 'value5', 'value7' ],
        'size' => 6,
        'choices' => [
            array( // optgroup
                [
                    'label' => _x( 'Group 1', 'options', PPHT_PREFIX ),
                    'choices' => array(
                        'value5' => _x( 'Option 5', 'options', PPHT_PREFIX ),
                        'value6' => _x( 'Option 6', 'options', PPHT_PREFIX )
                    )
                ],
                [
                    'label' => _x( 'Group 2', 'options', PPHT_PREFIX ),
                    'choices' => array(
                        'value7' => _x( 'Option 7', 'options', PPHT_PREFIX ),
                        'value8' => _x( 'Option 8', 'options', PPHT_PREFIX )
                    )
                ]
            )
        ],
        'attr' => array( 'class' => 'custom-class', 'data-foo' => 'bar' ),
        'description' => _x( 'Dropdown Multiple description', 'options', PPHT_PREFIX ),
        'tooltip' => _x( 'This field is used to add some text', 'options', PPHT_PREFIX ),
        'divider' => true
    ],
    
    //dropdown-multiple
    [
        'id' => 'dropdown_field_multiple',
        'type' => 'dropdown-multiple',
        'title' => _x( 'Dropdown Multiple field', 'options', PPHT_PREFIX ),
        'value' => [ 'value2', 'value4' ],
        'size' => 6,
        'choices' => [
            'value1' => _x( 'Option 1', 'options', PPHT_PREFIX ),
            'value2' => _x( 'Option 2', 'options', PPHT_PREFIX ),
            'value3' => _x( 'Option 3', 'options', PPHT_PREFIX ),
            'value4' => _x( 'Option 4', 'options', PPHT_PREFIX )
        ],
        'attr' => array( 'class' => 'custom-class', 'data-foo' => 'bar' ),
        'description' => _x( 'Dropdown Multiple description', 'options', PPHT_PREFIX ),
        'tooltip' => _x( 'This field is used to add some text', 'options', PPHT_PREFIX ),
        'divider' => true
    ],
    
    //dropdown -> group only
    [
        'id' => 'dropdown_field_group',
        'type' => 'dropdown',
        'title' => _x( 'Dropdown Group field', 'options', PPHT_PREFIX ),
        'value' => 'value7',
        'choices' => [
            array( // optgroup
                [
                    'label' => _x( 'Group 1', 'options', PPHT_PREFIX ),
                    'choices' => array(
                        'value5' => _x( 'Option 5', 'options', PPHT_PREFIX ),
                        'value6' => _x( 'Option 6', 'options', PPHT_PREFIX ),
                    )
                ],
                [
                    'label' => _x( 'Group 2', 'options', PPHT_PREFIX ),
                    'choices' => array(
                        'value7' => _x( 'Option 7', 'options', PPHT_PREFIX ),
                        'value8' => _x( 'Option 8', 'options', PPHT_PREFIX ),
                    )
                ]
            )
        ],
        'attr' => array( 'class' => 'custom-class', 'data-foo' => 'bar' ),
        'description' => _x( 'Dropdown description', 'options', PPHT_PREFIX ),
        'tooltip' => _x( 'This field is used to add some text', 'options', PPHT_PREFIX ),
        'divider' => true
    ],
    
    //dropdown
    [
        'id' => 'dropdown_field',
        'type' => 'dropdown',
        'title' => _x( 'Dropdown field', 'options', PPHT_PREFIX ),
        'value' => 'value2',
        'choices' => [
            'value1' => _x( 'Option 1', 'options', PPHT_PREFIX ),
            'value2' => _x( 'Option 2', 'options', PPHT_PREFIX ),
            'value3' => _x( 'Option 3', 'options', PPHT_PREFIX ),
            'value4' => _x( 'Option 4', 'options', PPHT_PREFIX ),
            array( // optgroup
                [
                    'label' => _x( 'Group 1', 'options', PPHT_PREFIX ),
                    'choices' => array(
                        'value5' => _x( 'Option 5', 'options', PPHT_PREFIX ),
                        'value6' => _x( 'Option 6', 'options', PPHT_PREFIX ),
                    )
                ],
                [
                    'label' => _x( 'Group 2', 'options', PPHT_PREFIX ),
                    'choices' => array(
                        'value7' => _x( 'Option 7', 'options', PPHT_PREFIX ),
                        'value8' => _x( 'Option 8', 'options', PPHT_PREFIX ),
                    )
                ]
            )
        ],
        'attr' => array( 'class' => 'custom-class', 'data-foo' => 'bar' ),
        'description' => _x( 'Dropdown description', 'options', PPHT_PREFIX ),
        'tooltip' => _x( 'This field is used to add some text', 'options', PPHT_PREFIX ),
        'divider' => true
    ],
    
    //switch field
    [
        'id' => 'switch_field2',
        'type' => 'switch',
        'title' => _x( 'Switch field', 'options', PPHT_PREFIX ),
        'value' => 'off',
        'left-choice' => array(
            'value' => 'on',
            'label' => _x( 'Enable', 'options', PPHT_PREFIX ),
        ),
        'right-choice' => array(
            'value' => 'off',
            'label' => _x( 'Disable', 'options', PPHT_PREFIX ),
        ),
        
        'attr' => array( 'class' => 'custom-class', 'data-foo' => 'bar' ),
        'description' => _x( 'Input description', 'options', PPHT_PREFIX ),
        'tooltip' => _x( 'This field is used to add some text', 'options', PPHT_PREFIX ),
        'divider' => true
    ],
    
    //wp editor
    [
        'id' => 'editor_field',
        'type' => 'wpeditor',
        'title' => _x( 'WP Editor field', 'options', PPHT_PREFIX ),
        'value' => 'Text editor',
        'rows' => 6,
        'media_button' => true,
        'default' => 'WP Editor placeholder',
        
        'attr' => array( 'class' => 'custom-class', 'data-foo' => 'bar' ),
        'description' => _x( 'WP Editor description', 'options', PPHT_PREFIX ),
        'tooltip' => _x( 'This field is used to add some text', 'options', PPHT_PREFIX ),
        'divider' => true
    ],
    
    //text field
    [
        'id' => 'text_field',
        'type' => 'text',
        'title' => _x( 'Text field', 'options', PPHT_PREFIX ),
        'value' => 'This field is to display some simple text',
        
        'attr' => array( 'class' => 'custom-class', 'data-foo' => 'bar' ),
        'tooltip' => _x( 'This field is used to add some text', 'options', PPHT_PREFIX ),
        'divider' => true
    ],
    
    //radio
    [
        'id' => 'radio_field',
        'type' => 'radio',
        'title' => _x( 'Radio field', 'options', PPHT_PREFIX ),
        'value' => 'value2', // radio field value to be checked
        'choices' => [
            'value1' => _x( 'Radio 1', 'options', PPHT_PREFIX ),
            'value2' => _x( 'Radio 2', 'options', PPHT_PREFIX ),
        ],
        
        'attr' => array( 'class' => 'custom-class', 'data-foo' => 'bar' ),
        'description' => _x( 'Radio description', 'options', PPHT_PREFIX ),
        'tooltip' => _x( 'This field is used to add some text', 'options', PPHT_PREFIX ),
        'divider' => true
    ],
    
    //checkbox
    [
        'id' => 'checkbox_field3',
        'type' => 'checkbox',
        'title' => _x( 'Checkbox field', 'options', PPHT_PREFIX ),
        'value' => [], //['checkbox_field1', 'checkbox_field2'] - not done yet
        'choices' => [
            [
                'id' => 'checkbox_field1',
                'label' => _x( 'Checkbox 1', 'options', PPHT_PREFIX ),
                'value' => 'value1',
            ],
            [
                'id' => 'checkbox_field2',
                'label' => _x( 'Checkbox 2', 'options', PPHT_PREFIX ),
                'value' => 'value2',
            ]
        ],
        
        'attr' => array( 'class' => 'custom-class', 'data-foo' => 'bar' ),
        'description' => _x( 'Checkbox description', 'options', PPHT_PREFIX ),
        'tooltip' => _x( 'This field is used to add some text', 'options', PPHT_PREFIX ),
        'divider' => true
    ],
    
    //textarea
    [
        'id' => 'textarea_field',
        'type' => 'textarea',
        'title' => _x( 'Textarea field', 'options', PPHT_PREFIX ),
        'value' => '',
        'rows' => 6,
        'default' => 'Textarea placeholder',
        
        'attr' => array( 'class' => 'custom-class', 'data-foo' => 'bar' ),
        'description' => _x( 'Textarea description', 'options', PPHT_PREFIX ),
        'tooltip' => _x( 'This field is used to add some text', 'options', PPHT_PREFIX ),
        'divider' => true
    ],
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
];