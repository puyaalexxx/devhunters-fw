<?php

if ( !defined( 'PPHT_MAIN' ) ) die( 'Forbidden' );

$options = [
    'id' => PPHT_PREFIX . '-tools-settings',
    'attr' => array( 'class' => 'custom-class', 'data-foo' => 'bar' ),
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
            'divider' => true
        ]
    ]
];