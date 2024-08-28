<?php

if ( !defined( 'PPHT_MAIN' ) ) die( 'Forbidden' );

[
    //toggle - show - hide options
    [
        'id' => 'toggle_field',
        'type' => 'toggle',
        'title' => _x( 'Toogle', 'options', PPHT_PREFIX ),
        'value' => 'off',
        'left-choice' => array(
            'value' => 'on',
            'label' => _x( 'Enable', 'options', PPHT_PREFIX ),
            'options' => [
                [
                    'id' => 'input_field',
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
            ]
        ),
        'right-choice' => array(
            'value' => 'off',
            'label' => _x( 'Disable', 'options', PPHT_PREFIX ),
            'options' => [
                [
                    'id' => 'textarea_field',
                    'type' => 'textarea',
                    'title' => _x( 'Textarea field', 'options', PPHT_PREFIX ),
                    'label' => _x( 'textarea label', 'options', PPHT_PREFIX ),
                    'value' => '',
                    'rows' => 6,
                    'default' => 'Textarea placeholder',
                    
                    'attr' => array( 'class' => 'custom-class', 'data-foo' => 'bar' ),
                    'description' => _x( 'Textarea description', 'options', PPHT_PREFIX ),
                    'tooltip' => _x( 'This field is used to add some text', 'options', PPHT_PREFIX ),
                    'divider' => true
                ]
            ]
        ),
        
        'attr' => array( 'class' => 'custom-class', 'data-foo' => 'bar' ),
        'description' => _x( 'Input description', 'options', PPHT_PREFIX ),
        'tooltip' => _x( 'This field is used to add some text', 'options', PPHT_PREFIX ),
        'divider' => true
    ]
];