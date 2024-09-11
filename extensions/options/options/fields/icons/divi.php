<?php

declare( strict_types = 1 );

if( !defined( 'DHT_MAIN' ) ) die( 'Forbidden' );

$divi_icons = [
    'arrow_up'                  => '\21',
    'arrow_down'                => '\22',
    'arrow_left'                => '\23',
    'arrow_right'               => '\24',
    'arrow_left-up'             => '\25',
    'arrow_right-up'            => '\26',
    'arrow_right-down'          => '\27',
    'arrow_left-down'           => '\28',
    'arrow-up-down'             => '\29',
    'arrow_up-down_alt'         => '\2a',
    'arrow_left-right_alt'      => '\2b',
    'arrow_left-right'          => '\2c',
    'arrow_expand_alt2'         => '\2d',
    'arrow_expand_alt'          => '\2e',
    'arrow_condense'            => '\2f',
    'arrow_expand'              => '\30',
    'arrow_move'                => '\31',
    'arrow_carrot-up'           => '\32',
    'arrow_carrot-down'         => '\33',
    'arrow_carrot-left'         => '\34',
    'arrow_carrot-right'        => '\35',
    'arrow_carrot-2up'          => '\36',
    'arrow_carrot-2down'        => '\37',
    'arrow_carrot-2left'        => '\38',
    'arrow_carrot-2right'       => '\39',
    'arrow_carrot-up_alt2'      => '\3a',
    'arrow_carrot-down_alt2'    => '\3b',
    'arrow_carrot-left_alt2'    => '\3c',
    'arrow_carrot-right_alt2'   => '\3d',
    'arrow_carrot-2up_alt2'     => '\3e',
    'arrow_carrot-2down_alt2'   => '\3f',
    'arrow_carrot-2left_alt2'   => '\40',
    'arrow_carrot-2right_alt2'  => '\41',
    'arrow_triangle-up'         => '\42',
    'arrow_triangle-down'       => '\43',
    'arrow_triangle-left'       => '\44',
    'arrow_triangle-right'      => '\45',
    'arrow_triangle-up_alt2'    => '\46',
    'arrow_triangle-down_alt2'  => '\47',
    'arrow_triangle-left_alt2'  => '\48',
    'arrow_triangle-right_alt2' => '\49',
    'arrow_back'                => '\4a',
    'icon_minus-06'             => '\4b',
    'icon_plus'                 => '\4c',
    'icon_close'                => '\4d',
    'icon_check'                => '\4e',
    'icon_minus_alt2'           => '\4f',
    'icon_plus_alt2'            => '\50',
    'icon_close_alt2'           => '\51',
    'icon_check_alt2'           => '\52',
    'icon_zoom-out_alt'         => '\53',
    'icon_zoom-in_alt'          => '\54',
    'icon_search'               => '\55',
    'icon_box-empty'            => '\56',
    'icon_box-selected'         => '\57',
    'icon_minus-box'            => '\58',
    'icon_plus-box'             => '\59',
    'icon_box-checked'          => '\5a',
    'icon_circle-empty'         => '\5b',
    'icon_circle-slelected'     => '\5c',
    'icon_stop_alt2'            => '\5d',
    'icon_stop'                 => '\5e',
    'icon_pause_alt2'           => '\5f',
    'icon_pause'                => '\60',
    'icon_menu'                 => '\61',
    'icon_menu-square_alt2'     => '\62',
    'icon_menu-circle_alt2'     => '\63',
    'icon_ul'                   => '\64',
    'icon_ol'                   => '\65',
    'icon_adjust-horiz'         => '\66',
    'icon_adjust-vert'          => '\67',
    'icon_document_alt'         => '\68',
    'icon_documents_alt'        => '\69',
    'icon_pencil'               => '\6a',
    'icon_pencil-edit_alt'      => '\6b',
    'icon_pencil-edit'          => '\6c',
    'icon_folder-alt'           => '\6d',
    'icon_folder-open_alt'      => '\6e',
    'icon_folder-add_alt'       => '\6f',
    'icon_info_alt'             => '\70',
    'icon_error-oct_alt'        => '\71',
    'icon_error-circle_alt'     => '\72',
    'icon_error-triangle_alt'   => '\73',
    'icon_question_alt2'        => '\74',
    'icon_question'             => '\75',
    'icon_comment_alt'          => '\76',
    'icon_chat_alt'             => '\77',
    'icon_vol-mute_alt'         => '\78',
    'icon_volume-low_alt'       => '\79',
    'icon_volume-high_alt'      => '\7a',
    'icon_quotations'           => '\7b',
    'icon_quotations_alt2'      => '\7c',
    'icon_clock_alt'            => '\7d',
    'icon_lock_alt'             => '\7e',
    'icon_lock-open_alt'        => '\e000',
    'icon_key_alt'              => '\e001',
    'icon_cloud_alt'            => '\e002',
    'icon_cloud-upload_alt'     => '\e003',
    'icon_cloud-download_alt'   => '\e004',
    'icon_image'                => '\e005',
    'icon_images'               => '\e006',
    'icon_lightbulb_alt'        => '\e007',
    'icon_gift_alt'             => '\e008',
    'icon_house_alt'            => '\e009',
    'icon_genius'               => '\e00a',
    'icon_mobile'               => '\e00b',
    'icon_tablet'               => '\e00c',
    'icon_laptop'               => '\e00d',
    'icon_desktop'              => '\e00e',
    'icon_camera_alt'           => '\e00f',
    'icon_mail_alt'             => '\e010',
    'icon_cone_alt'             => '\e011',
    'icon_ribbon_alt'           => '\e012',
    'icon_bag_alt'              => '\e013',
    'icon_creditcard'           => '\e014',
    'icon_cart_alt'             => '\e015',
    'icon_paperclip'            => '\e016',
    'icon_tag_alt'              => '\e017',
    'icon_tags_alt'             => '\e018',
    'icon_trash_alt'            => '\e019',
    'icon_cursor_alt'           => '\e01a',
    'icon_mic_alt'              => '\e01b',
    'icon_compass_alt'          => '\e01c',
    'icon_pin_alt'              => '\e01d',
    'icon_pushpin_alt'          => '\e01e',
    'icon_map_alt'              => '\e01f',
    'icon_drawer_alt'           => '\e020',
    'icon_toolbox_alt'          => '\e021',
    'icon_book_alt'             => '\e022',
    'icon_calendar'             => '\e023',
    'icon_film'                 => '\e024',
    'icon_table'                => '\e025',
    'icon_contacts_alt'         => '\e026',
    'icon_headphones'           => '\e027',
    'icon_lifesaver'            => '\e028',
    'icon_piechart'             => '\e029',
    'icon_refresh'              => '\e02a',
    'icon_link_alt'             => '\e02b',
    'icon_link'                 => '\e02c',
    'icon_loading'              => '\e02d',
    'icon_blocked'              => '\e02e',
    'icon_archive_alt'          => '\e02f',
    'icon_heart_alt'            => '\e030',
    'icon_star_alt'             => '\e031',
    'icon_star-half_alt'        => '\e032',
    'icon_star'                 => '\e033',
    'icon_star-half'            => '\e034',
    'icon_tools'                => '\e035',
    'icon_tool'                 => '\e036',
    'icon_cog'                  => '\e037',
    'icon_cogs'                 => '\e038',
    'arrow_up_alt'              => '\e039',
    'arrow_down_alt'            => '\e03a',
    'arrow_left_alt'            => '\e03b',
    'arrow_right_alt'           => '\e03c',
    'arrow_left-up_alt'         => '\e03d',
    'arrow_right-up_alt'        => '\e03e',
    'arrow_right-down_alt'      => '\e03f',
    'arrow_left-down_alt'       => '\e040',
    'arrow_condense_alt'        => '\e041',
    'arrow_expand_alt3'         => '\e042',
    'arrow_carrot_up_alt'       => '\e043',
    'arrow_carrot-down_alt'     => '\e044',
    'arrow_carrot-left_alt'     => '\e045',
    'arrow_carrot-right_alt'    => '\e046',
    'arrow_carrot-2up_alt'      => '\e047',
    'arrow_carrot-2dwnn_alt'    => '\e048',
    'arrow_carrot-2left_alt'    => '\e049',
    'arrow_carrot-2right_alt'   => '\e04a',
    'arrow_triangle-up_alt'     => '\e04b',
    'arrow_triangle-down_alt'   => '\e04c',
    'arrow_triangle-left_alt'   => '\e04d',
    'arrow_triangle-right_alt'  => '\e04e',
    'icon_minus_alt'            => '\e04f',
    'icon_plus_alt'             => '\e050',
    'icon_close_alt'            => '\e051',
    'icon_check_alt'            => '\e052',
    'icon_zoom-out'             => '\e053',
    'icon_zoom-in'              => '\e054',
    'icon_stop_alt'             => '\e055',
    'icon_menu-square_alt'      => '\e056',
    'icon_menu-circle_alt'      => '\e057',
    'icon_document'             => '\e058',
    'icon_documents'            => '\e059',
    'icon_pencil_alt'           => '\e05a',
    'icon_folder'               => '\e05b',
    'icon_folder-open'          => '\e05c',
    'icon_folder-add'           => '\e05d',
    'icon_folder_upload'        => '\e05e',
    'icon_folder_download'      => '\e05f',
    'icon_info'                 => '\e060',
    'icon_error-circle'         => '\e061',
    'icon_error-oct'            => '\e062',
    'icon_error-triangle'       => '\e063',
    'icon_question_alt'         => '\e064',
    'icon_comment'              => '\e065',
    'icon_chat'                 => '\e066',
    'icon_vol-mute'             => '\e067',
    'icon_volume-low'           => '\e068',
    'icon_volume-high'          => '\e069',
    'icon_quotations_alt'       => '\e06a',
    'icon_clock'                => '\e06b',
    'icon_lock'                 => '\e06c',
    'icon_lock-open'            => '\e06d',
    'icon_key'                  => '\e06e',
    'icon_cloud'                => '\e06f',
    'icon_cloud-upload'         => '\e070',
    'icon_cloud-download'       => '\e071',
    'icon_lightbulb'            => '\e072',
    'icon_gift'                 => '\e073',
    'icon_house'                => '\e074',
    'icon_camera'               => '\e075',
    'icon_mail'                 => '\e076',
    'icon_cone'                 => '\e077',
    'icon_ribbon'               => '\e078',
    'icon_bag'                  => '\e079',
    'icon_cart'                 => '\e07a',
    'icon_tag'                  => '\e07b',
    'icon_tags'                 => '\e07c',
    'icon_trash'                => '\e07d',
    'icon_cursor'               => '\e07e',
    'icon_mic'                  => '\e07f',
    'icon_compass'              => '\e080',
    'icon_pin'                  => '\e081',
    'icon_pushpin'              => '\e082',
    'icon_map'                  => '\e083',
    'icon_drawer'               => '\e084',
    'icon_toolbox'              => '\e085',
    'icon_book'                 => '\e086',
    'icon_contacts'             => '\e087',
    'icon_archive'              => '\e088',
    'icon_heart'                => '\e089',
    'icon_profile'              => '\e08a',
    'icon_group'                => '\e08b',
    'icon_grid-2x2'             => '\e08c',
    'icon_grid-3x3'             => '\e08d',
    'icon_music'                => '\e08e',
    'icon_pause_alt'            => '\e08f',
    'icon_phone'                => '\e090',
    'icon_upload'               => '\e091',
    'icon_download'             => '\e092',
    'social_facebook'           => '\e093',
    'social_twitter'            => '\e094',
    'social_pinterest'          => '\e095',
    'social_googleplus'         => '\e096',
    'social_tumblr'             => '\e097',
    'social_tumbleupon'         => '\e098',
    'social_wordpress'          => '\e099',
    'social_instagram'          => '\e09a',
    'social_dribbble'           => '\e09b',
    'social_vimeo'              => '\e09c',
    'social_linkedin'           => '\e09d',
    'social_rss'                => '\e09e',
    'social_deviantart'         => '\e09f',
    'social_share'              => '\e0a0',
    'social_myspace'            => '\e0a1',
    'social_skype'              => '\e0a2',
    'social_youtube'            => '\e0a3',
    'social_picassa'            => '\e0a4',
    'social_googledrive'        => '\e0a5',
    'social_flickr'             => '\e0a6',
    'social_blogger'            => '\e0a7',
    'social_spotify'            => '\e0a8',
    'social_delicious'          => '\e0a9',
    'social_facebook_circle'    => '\e0aa',
    'social_twitter_circle'     => '\e0ab',
    'social_pinterest_circle'   => '\e0ac',
    'social_googleplus_circle'  => '\e0ad',
    'social_tumblr_circle'      => '\e0ae',
    'social_stumbleupon_circle' => '\e0af',
    'social_wordpress_circle'   => '\e0b0',
    'social_instagram_circle'   => '\e0b1',
    'social_dribbble_circle'    => '\e0b2',
    'social_vimeo_circle'       => '\e0b3',
    'social_linkedin_circle'    => '\e0b4',
    'social_rss_circle'         => '\e0b5',
    'social_deviantart_circle'  => '\e0b6',
    'social_share_circle'       => '\e0b7',
    'social_myspace_circle'     => '\e0b8',
    'social_skype_circle'       => '\e0b9',
    'social_youtube_circle'     => '\e0ba',
    'social_picassa_circle'     => '\e0bb',
    'social_googledrive_alt2'   => '\e0bc',
    'social_flickr_circle'      => '\e0bd',
    'social_blogger_circle'     => '\e0be',
    'social_spotify_circle'     => '\e0bf',
    'social_delicious_circle'   => '\e0c0',
    'social_facebook_square'    => '\e0c1',
    'social_twitter_square'     => '\e0c2',
    'social_pinterest_square'   => '\e0c3',
    'social_googleplus_square'  => '\e0c4',
    'social_tumblr_square'      => '\e0c5',
    'social_stumbleupon_square' => '\e0c6',
    'social_wordpress_square'   => '\e0c7',
    'social_instagram_square'   => '\e0c8',
    'social_dribbble_square'    => '\e0c9',
    'social_vimeo_square'       => '\e0ca',
    'social_linkedin_square'    => '\e0cb',
    'social_rss_square'         => '\e0cc',
    'social_deviantart_square'  => '\e0cd',
    'social_share_square'       => '\e0ce',
    'social_myspace_square'     => '\e0cf',
    'social_skype_square'       => '\e0d0',
    'social_youtube_square'     => '\e0d1',
    'social_picassa_square'     => '\e0d2',
    'social_googledrive_square' => '\e0d3',
    'social_flickr_square'      => '\e0d4',
    'social_blogger_square'     => '\e0d5',
    'social_spotify_square'     => '\e0d6',
    'social_delicious_square'   => '\e0d7',
    'icon_printer'              => '\e103',
    'icon_calulator'            => '\e0ee',
    'icon_building'             => '\e0ef',
    'icon_floppy'               => '\e0e8',
    'icon_drive'                => '\e0ea',
    'icon_search-2'             => '\e101',
    'icon_id'                   => '\e107',
    'icon_id-2'                 => '\e108',
    'icon_puzzle'               => '\e102',
    'icon_like'                 => '\e106',
    'icon_dislike'              => '\e0eb',
    'icon_mug'                  => '\e105',
    'icon_currency'             => '\e0ed',
    'icon_wallet'               => '\e100',
    'icon_pens'                 => '\e104',
    'icon_easel'                => '\e0e9',
    'icon_flowchart'            => '\e109',
    'icon_datareport'           => '\e0ec',
    'icon_briefcase'            => '\e0fe',
    'icon_shield'               => '\e0f6',
    'icon_percent'              => '\e0fb',
    'icon_globe'                => '\e0e2',
    'icon_globe-2'              => '\e0e3',
    'icon_target'               => '\e0f5',
    'icon_hourglass'            => '\e0e1',
    'icon_balance'              => '\e0ff',
    'icon_rook'                 => '\e0f8',
    'icon_printer-alt'          => '\e0fa',
    'icon_calculator_alt'       => '\e0e7',
    'icon_building_alt'         => '\e0fd',
    'icon_floppy_alt'           => '\e0e4',
    'icon_drive_alt'            => '\e0e5',
    'icon_search_alt'           => '\e0f7',
    'icon_id_alt'               => '\e0e0',
    'icon_id-2_alt'             => '\e0fc',
    'icon_puzzle_alt'           => '\e0f9',
    'icon_like_alt'             => '\e0dd',
    'icon_dislike_alt'          => '\e0f1',
    'icon_mug_alt'              => '\e0dc',
    'icon_currency_alt'         => '\e0f3',
    'icon_wallet_alt'           => '\e0d8',
    'icon_pens_alt'             => '\e0db',
    'icon_easel_alt'            => '\e0f0',
    'icon_flowchart_alt'        => '\e0df',
    'icon_datareport_alt'       => '\e0f2',
    'icon_briefcase_alt'        => '\e0f4',
    'icon_shield_alt'           => '\e0d9',
    'icon_percent_alt'          => '\e0da',
    'icon_globe_alt'            => '\e0de',
    'icon_clipboard'            => '\e0e6'
];
