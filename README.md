# DevHunters framework : A framework to easier create WordPress plugins

**Version 1.0.0**

<h2 id="introduction">Introduction</h2>

This is a framework that makes it easier to create WordPress plugins. It offers many features, such as:

1. custom fields
2. simple visual builder with modals
3. creating dashboard menus via settings
4. creating custom post types via settings
5. dynamic sidebars feature
6. registering custom sidebars via settings

<h2 id="requirements">Requirements</h2>

1. PHP 8 and above
2. WordPress 6.7 and above

<h2 id="table-of-contents">Table of Contents</h2>

1. [Installation](#installation)
2. [How To Use In a Plugin](#how-to-use-in-a-plugin)
3. [Features](#features)
    - [Custom Fields](#custom-fields)
        - [Containers](#containers)
            - [Simple](#simple)
            - [SideMenu](#sidemenu)
            - [TabsMenu](#tabsmenu)
        - [Groups](#groups)
            - [Group](#group)
            - [Tabs](#tabs)
            - [Panel](#panel)
            - [Accordion](#accordion)
            - [Addable Box](#addable-box)
        - [Toggles](#toggles)
            - [Toggle](#toggle)
        - [Fields](#fields)
            - [Input](#input)
            - [Textarea](#textarea)
            - [Checkbox](#checkbox)
            - [Radio](#radio)
            - [WPEditor](#wpeditor)
            - [Switch](#switch)
            - [Dropdown](#dropdown)
            - [Dropdown Multiple](#dropdown-multiple)
            - [MultiInput](#multiinput)
            - [AceEditor](#aceeditor)
            - [ColorPicker](#colorpicker)
            - [DatePicker](#datepicker)
            - [TimePicker](#timepicker)
            - [DateTimePicker](#datetimepicker)
            - [Range Slider](#range-slider)
            - [Radio Image](#radio-image)
            - [Multi Options](#multi-options)
            - [Dimensions](#dimensions)
            - [Upload](#upload)
            - [Upload Image](#upload-image)
            - [Upload Gallery](#upload-gallery)
            - [Icon](#icon)
            - [Typography](#typography)
        - [Fields Settings Elaboration](#fields-settings-eleborations)
        - [Live Fields Editing](#live-fields)
        - [How To Use](#how-to-use-dashboard-menus)
    - [Dashboard Menus](#dashboard-menus)
        - [How To Use](#how-to-use-fields)
    - [Custom Posts](#custom-posts)
        - [How To Use](#how-to-use-custom-posts)
    - [Custom Sidebars](#custom-sidebars)
        - [How To Use](#how-to-use-custom-sidebars)
    - [Dynamic Sidebars](#dynamic-sidebars)
        - [How To Use](#how-to-use-dynamic-sidebars)
    - [Visual Builder](#visual-builder)
4. [Framework Utilities](#framework-utilities)
    - [Manifest](#manifest)
    - [MakeFile](#makefile)
    - [Functions](#functions)
    - [Custom Hooks](#custom-hooks)
    - [Custom Filters](#custom-filters)
5. [Licence](#license)
6. [Authors](#authors)

<h2 id="installation">Installation</h2>

You can install the framework in two ways:

1. As a plugin
    - Clone the repository: **`git clone https://github.com/puyaalexxx/devhunters-fw.git`**
    - Install it as
      a [WordPress Plugin](https://www.wpbeginner.com/beginners-guide/step-by-step-guide-to-install-a-wordpress-plugin-for-beginners/)
2. As a composer package
    - Add it as a dependency to your plugin in **`package.json`**
    - Start the project: **`npm start`**
    - Add this line in `composer.json` under the `psr-4` object from the plugin folder:
      ```json
      "DHT\\" : "devhunters-fw/"
      ```
    - Run `composer update` in the framework folder to include the vendor folder
    - Add this line in the **_plugin folder > plugin.php_** file, somewhere at the top:
      ```php
      require_once(plugin_dir_path(__FILE__) . "devhunters-fw/vendor/autoload.php");
      ```
    - Use this code to add the package from Git inside the `composer.json` file:
      ```json
      {
        "repositories": [
          {
            "type": "vcs",
            "url": "https://github.com/puyaalexxx/devhunters-fw"
          }
        ],
        "require": {
          "devhunters/devhunters-fw": "dev-main"
        },
        "autoload": {
          "files": [
            "src/constants.php",
            "src/helpers/general.php"
          ],
          "psr-4": {
            "DHT\\": "vendor/devhunters/devhunters-fw/",
            "RHT\\Src\\": "src/"
          }
        }
      }
      ```
    - Run `composer update` to load the package
    - Comment this line from the **_plugin.php_** file if it exists:
      ```php
      require_once(plugin_dir_path(__FILE__) . "devhunters-fw/vendor/autoload.php");
      ```
    - To complete this after finishing the plugin...

devhunter-utils package

- npm run build
- push to github in the devhunters plugin
- npm update devhunters-utils

<h2 id="how-to-use-in-a-plugin">How To Use In a Plugin</h2>

To use the framework functionality in your plugin and make it available, you need to activate your plugin code on the
`after_setup_theme` hook.

All the plugin settings that you want to pass are used by convention. You can remove some of them and leave the
defaults, that are these:

```php
[
    "paths"    => [
        "plugin-settings-folder" => "", // folder where are all the settings located - default empty and without it, nothing will be enabled
        "options"                => [
            "dashboard-pages-options-folder" => "options/dashboard-pages/", // the folder where the dashboard menu options are located
            "post-types-options-folder"      => "options/posts/",  // the folder where the posts and custom posts options are located
            "terms-options-folder"           => "options/terms/",  // the folder where the terms and categories options are located
            "vb-modal-options-folder"        => "options/vb/",  // the folder where the visual builder modals options are located
        ],
        "features"               => [
            "dash-menus-settings-file" => "dashboard-pages.php", // the file where the dashboard menus settings are located
            "cpts-settings-file"       => "cpts.php", // the file where custom posts creation settings are located
            "sidebars-settings-file"   => "sidebars.php", // the file where custom sidebars creation settings are located
        ],
    ],
    "features" => [
        "vb-register-on-post-types" => [], // on what post types to enable the visual builder, default none
        "enable-dynamic-sidebars"   => false, // enable the dynamic sidebars form creation, default no
    ]
]
```

**NOTE!!!**`plugin-settings-folder` - this path will be concatenated behind to all the options and features folders and
files, so if
`terms-options-folder` will be `options/terms/`, the end result will be `plugin-settings-folder` + `options/terms/`

```php
//initialize plugin functionality
add_action( 'after_setup_theme', 'initPlugin', 99 );
function initPlugin() : void {
    //see if the framework is not active already
    if( !defined( 'DHT_DIR' ) ) {
        return;
    }
    
    // Load the framework functionality
    {
        //include the framework file
        require_once DHT_DIR . 'DHT.php';
        
        //init framework with the plugin settings
        DHT::init( [
            "paths"    => [
                "plugin-settings-folder" => CONFIG_DIR_CONST . 'settings/' // folder where are all the settings located
            ],
            "features" => [
                "vb-register-on-post-types" => [ 'cpt1', 'cpt2' ] // on what post types to enable the visual builder
                //"enable-dynamic-sidebars"   => true - you can disable or remove some of the settings to take the defaults
            ]
        ] );
    }
}
```

**NOTE!!!** All these settings can be overridden via filters. See <a href="#custom-filters">Filters</a>.

<h2 id="features">Features</h2>

All the framework features that you can use.

<h3 id="custom-fields">Custom Fields</h3>

===================================

You have 4 types of custom fields:

- **Containers**
- **Groups**
- **Toggles**
- **Fields**

You can use them from top to bottom. You can add fields inside toggles, toggles inside groups and groups
inside containers, however you can't use them otherwise. You can't add containers inside fields, groups
inside fields or containers inside toggles.

So it should be like this - **Containers > Groups > Toggles > Fields**

<h3 id="containers">Containers</h3>

===================================

Containers are the top level custom fields that you can add to place other fields inside.
There are 3 container types at the moment:

- <span id="simple">**Simple**</span>

Simple container is just a convenience to group the options

```php
[
   'id'      => 'general-side-menu-settings', // container id
   'type'    => 'simple', // container type
   'save'    => 'separately', //or group (group is default) - save options under one id (container id) or individually
   'attr'    => array( 'class' => 'custom-class', 'data-foo' => 'bar' ), // custom attributes added to the container
   'options' => [
    // add here other option fields
   ]
]
  ```

![Simple Container Preview](https://res.cloudinary.com/dzuieskuw/image/upload/v1735481017/simple-container_sl6dly.png)

- <span id="sidemenu">**SideMenu**</span>

SideMenu via refresh links - each menu link will open the provided **page_link** via refresh.

```php
[
   'id' => 'side-menu-settings', // container id
   'type' => 'sidemenu', // container type
   'save'    => 'separately', //or group (group is default) - save options under one id (container id) or individually
   'attr' => array( 'class' => 'custom-class', 'data-foo' => 'bar' ), // custom attributes added to the container
   //pages match the registered dashboard menu items or any other links
   'options' => [
     [
         'id' => 'general-settings',
         'title' => 'General Settings',
         'icon' => 'dashicons-before dashicons-admin-settings', // add a menu icon or image link
         'page_link' => admin_url( 'admin.php?page=ppht-main-settings' ), //page link where it should go
         'options' => [
             // add here other option fields
         ]
     ],
     [
         'id' => 'modules',
         'title' => 'Modules',
         'icon' => 'dashicons-before dashicons-admin-page', // add a menu icon or image link
         'page_link' => admin_url( 'admin.php?page=text-settings' ), // match the first page link from below pages
         'pages' => [
             [
                 'id' => 'text-settings',
                 'title' => 'Text Page',
                 'page_link' => admin_url( 'admin.php?page=text-settings' ), //page link where it should go
             ],
             [
                 'id' => 'contact-form-page',
                 'title' => 'Contact Form Page',
                 'page_link' => admin_url( 'admin.php?page=contact-settings' ), //page link where it should go
             ],
         ],
     ],
     [
         'id' => 'tools-settings',
         'title' => 'Tools Page',
         'icon' => 'http://my-site.com/images/devhuntersmain-logo-dashmenu.png', // add a menu icon or image link
         'page_link' => admin_url( 'admin.php?page=ppht-tools-settings' ), //page link where it should go
     ],
   ]
]
  ```

SideMenu as tabs - `'subtype' => 'tabs'` - each menu item will be opened as a tab on the same page.

```php
[
   'id' => 'side-menu-settings', // container id
   'type' => 'sidemenu', // container type
   'subtype' => 'tabs', //make it tabs
   'save'    => 'separately', //or group (group is default) - save options under one id (container id) or individually
   'attr' => array( 'class' => 'custom-class', 'data-foo' => 'bar' ), // custom attributes added to the container
   //pages match the registered dashboard menu items or any other links
   'options' => [
     [
         'id' => 'general-settings',
         'title' => 'General Settings',
         'icon' => 'dashicons-before dashicons-admin-settings', // add a menu icon or image link
         'options' => [
             // add here other option fields
         ]
     ],
     [
         'id' => 'modules',
         'title' => 'Modules',
         'icon' => 'dashicons-before dashicons-admin-page', // add a menu icon or image link
         'pages' => [
             [
                 'id' => 'text-settings',
                 'title' => 'Text Page',
                 'options' => [
                      // add here other option fields
                  ]
             ],
             [
                 'id' => 'contact-form-page',
                 'title' => 'Contact Form Page',
                 'options' => [
                      // add here other option fields
                  ]
             ],
         ],
     ],
     [
         'id' => 'tools-settings',
         'title' => 'Tools Page',
         'icon' => 'http://my-site.com/images/devhuntersmain-logo-dashmenu.png', // add a menu icon or image link
         'options' => [
             // add here other option fields
         ]
     ],
   ]
]
  ```

![SideMenu Preview](https://res.cloudinary.com/dzuieskuw/image/upload/v1735478510/sidemenu-refresh_t7yyp6.png)

- <span id="tabsmenu">**TabsMenu**</span>

```php
[
   'id' => 'tabs-container-settings', // container id
   'type' => 'tabsmenu', // container type
   'save' => 'separately', //or group (group is default) - save options under one id or individually
   'options' => [
     [
         'id' => 'general-settings',
         'title' => 'General Settings',
         'options' => [
             // add here other option fields
          ]
     ],
     [
         'id' => 'modules-settings',
         'title' => 'Modules',
         'options' => [
             // add here other option fields
          ]
     ],
     [
         'id' => 'tools-settings',
         'title' => 'Tools',
         'options' => [    
             // add here other option fields
          ]
     ],
   ]
]
  ```

![TabsMenu Preview](https://res.cloudinary.com/dzuieskuw/image/upload/v1735481674/tabsmenu_f6bq9a.png)

<h3 id="groups">Groups</h3>

===================================

- <span id="group">**Group**</span>

A simple group field to group other fields.

```php
[
   'id' => 'group', // group id
   'type' => 'group', // group type
   'title' => _x( 'Group Title', 'options', PREFIX ), // group title
   'options' => [
      // add here other option fields
   ],
   'attr' => array( 'class' => 'custom-class', 'data-foo' => 'bar' ), // custom attributes added to the group
   'description' => _x( 'Group description', 'options', PREFIX ), // group description
   'tooltip' => _x( 'More description in tooltip', 'options', PREFIX ), // // group tooltip
   'divider' => true // add a border at the bottom
]
  ```

![Group Preview](https://res.cloudinary.com/dzuieskuw/image/upload/v1735494175/group-type_nswdhn.png)

- <span id="tabs">**Tabs**</span>

```php
[
   'id' => 'tabs', // group id
   'type' => 'tabs', // group type
   'title' => _x( 'Tabs Title', 'options', PREFIX ), // group title
   'fullwidth' => false, // if tabs should be fullwidth
   'options' => [
      //tab 1
      [
          'title' => _x( 'Tab 1', 'options', PREFIX ),
          'options' => [
              // add here other option fields
          ]
      ],
      //tab 2
      [
          'title' => _x( 'Tab 2', 'options', PREFIX ),
          'options' => [
              // add here other option fields
          ]
      ]
   ],
   'attr' => array( 'class' => 'custom-class', 'data-foo' => 'bar' ), // custom attributes added to the group
   'description' => _x( 'Tabs description', 'options', PREFIX ), // group description
   'tooltip' => _x( 'More description in tooltip', 'options', PREFIX ), // group tooltip
   'divider' => true // add a border at the bottom
]
  ```

![Tabs Preview](https://res.cloudinary.com/dzuieskuw/image/upload/v1735494178/tabs_j2x9by.png)

**Fullwidth:**

![Tabs Fullwidth Preview](https://res.cloudinary.com/dzuieskuw/image/upload/v1735494177/tabs-fullwidth_sppbvu.png)

- <span id="panel">**Panel**</span>

```php
[
   'id'          => 'panel', // group id
   'type'        => 'panel', // group type
   'title'       => _x( 'Panel Title', 'options', PREFIX ), // group title
   'fullwidth' => true, // if panels should be fullwidth
   'options'     => [
      [
          'panel_title' => _x( 'Panel 1', 'options', PREFIX ),
          'options'     => [
             // add here other option fields
          ]
      ],
      [
          'panel_title' => _x( 'Panel 2', 'options', PREFIX ),
          'options'     => [
             // add here other option fields
          ]
      ]
   ],
   'attr' => array( 'class' => 'custom-class', 'data-foo' => 'bar' ), // custom attributes added to the group
   'description' => _x( 'Panel description', 'options', PREFIX ), // group description
   'tooltip' => _x( 'More description in tooltip', 'options', PREFIX ), // group tooltip
   'divider' => true // add a border at the bottom
]
  ```

![Panel Preview](https://res.cloudinary.com/dzuieskuw/image/upload/v1735494177/panel_rwakpc.png)

**Fullwidth:**

![Panel Fullwidth Preview](https://res.cloudinary.com/dzuieskuw/image/upload/v1735494175/panel-fullwidth_n0lqhc.png)

- <span id="accordion">**Accordion**</span>

```php
[
   'id' => 'accordion', // group id
   'type' => 'accordion', // group type
   'title' => _x( 'Accordion Title', 'options', PREFIX ), // group title
   'options' => [
      //group 1
      [
          'title' => _x( 'Group 1', 'options', PREFIX ),
          'options' => [
              // add here other option fields
          ]
      ],
      //group 2
      [
          'title' => _x( 'Group 2', 'options', PREFIX ),
          'options' => [
              // add here other option fields
          ]
      ]
   ],
   'attr' => array( 'class' => 'custom-class', 'data-foo' => 'bar' ), // custom attributes added to the group
   'description' => _x( 'Accordion description', 'options', PREFIX ), // group description
   'tooltip' => _x( 'More description in tooltip', 'options', PREFIX ), // group tooltip
   'divider' => true // add a border at the bottom
]
  ```

![Accordion Preview](https://res.cloudinary.com/dzuieskuw/image/upload/v1735494174/accordion_swx3zf.png)

- <span id="addable-box">**Addable Box**</span>

Addable boxes, that you can add dynamically. The fields inside are loaded via ajax.

```php
[
   'id' => 'addable', // group id
   'type' => 'addable-box', // group type
   'title' => _x( 'Addable Box Title', 'options', PREFIX ), // group title
   'sortable' => true, // sort the boxes
   'limit' => -1, // -1 for unlimited items - number of max items you can add
   'box-title'   => _x( 'Box Title', 'options', PREFIX ), // Box title 
   'options' => [
      // add here other option fields
   ],
   'attr' => array( 'class' => 'custom-class', 'data-foo' => 'bar' ), // custom attributes added to the group
   'description' => _x( 'Addable Box description', 'options', PREFIX ), // group description
   'tooltip' => _x( 'More description in tooltip', 'options', PREFIX ), // group tooltip
   'divider' => true // add a border at the bottom
]
  ```

![Addable Box Preview](https://res.cloudinary.com/dzuieskuw/image/upload/v1735494174/addable-box_rb49gb.png)

<h3 id="toggles">Toggles</h3>

===================================

- <span id="toggle">**Toggle**</span>

A toggle field to show hide specific fields.

```php
[
   'id' => 'toggle', // toggle id
   'type' => 'toggle', // toggle type
   'title' => _x( 'Toogle Title', 'options', PREFIX ), // toggle title
   "size"         => "small", //medium, large - button size
   'value' => 'off', // default value
   'left-choice' => array( 
      'value' => 'on',
      'label' => _x( 'Enable', 'options', PREFIX ), // toggle left label
      'options' => [
          // add here other option fields
      ]
   ),
   'right-choice' => array(
      'value' => 'off',
      'label' => _x( 'Disable', 'options', PREFIX ), // toggle right label
      'options' => [
          // add here other option fields
      ]
   ),
   
   'attr' => array( 'class' => 'custom-class', 'data-foo' => 'bar' ), // custom attributes added to the toggle
   'description' => _x( 'Toggle description', 'options', PREFIX ), // toggle description
   'tooltip' => _x( 'More description in tooltip', 'options', PREFIX ), // toggle tooltip
   'divider' => true // add a border at the bottom
]
  ```

![Toggle Preview](https://res.cloudinary.com/dzuieskuw/image/upload/v1735494179/toggle_etvbjh.png)

<h3 id="fields">Fields</h3>

===================================

- <span id="input">**Input**</span>

```php
[
   'id' => 'input', // field id
   'type' => 'input', // field type
   'title' => _x( 'Input Title', 'options', PREFIX ), // field title
   'value' => '', // default value
   'subtype' => '', //(can be email, password...)
   'attr' => array( 'class' => 'custom-class', 'data-foo' => 'bar' ), // custom attributes added to the field
   'description' => _x( 'Input description', 'options', PREFIX ), // field description
   'tooltip' => _x( 'More description in tooltip', 'options', PREFIX ), // field tooltip
   'divider' => true // add a border at the bottom
]
  ```

![Input Preview](https://res.cloudinary.com/dzuieskuw/image/upload/v1735564612/input_n8uxil.png)

- <span id="textarea">**Textarea**</span>

```php
[
   'id' => 'textarea', // field id
   'type' => 'textarea', // field type
   'title' => _x( 'Textarea Title', 'options', PREFIX ), // field title
   'value' => '', // default value
   'rows' => 6, // number of textarea rows
   'default' => 'Textarea placeholder', // textarea placeholder value
   'attr' => array( 'class' => 'custom-class', 'data-foo' => 'bar' ), // custom attributes added to the field
   'description' => _x( 'Textarea description', 'options', PREFIX ), // field description
   'tooltip' => _x( 'More description in tooltip', 'options', PREFIX ), // field tooltip
   'divider' => true // add a border at the bottom
]
  ```

![Textarea Preview](https://res.cloudinary.com/dzuieskuw/image/upload/v1735564621/textarea_p6w1bg.png)

- <span id="checkbox">**Checkbox**</span>

```php
[
   'id' => 'checkbox', // field id
   'type' => 'checkbox', // field type
   'title' => _x( 'Checkbox Title', 'options', PREFIX ), // field title
   'value' => [], //['checkbox_field1', 'checkbox_field2'] - default value
   'choices' => [ // checkboxes
      [
          'id' => 'checkbox_field1',
          'label' => _x( 'Checkbox 1', 'options', PREFIX ),
          'value' => 'value1',
      ],
      [
          'id' => 'checkbox_field2',
          'label' => _x( 'Checkbox 2', 'options', PREFIX ),
          'value' => 'value2',
      ]
   ],
   'attr' => array( 'class' => 'custom-class', 'data-foo' => 'bar' ), // custom attributes added to the field
   'description' => _x( 'Checkbox description', 'options', PREFIX ), // field description
   'tooltip' => _x( 'More description in tooltip', 'options', PREFIX ), // field tooltip
   'divider' => true // add a border at the bottom
]
  ```

![Checkbox Preview](https://res.cloudinary.com/dzuieskuw/image/upload/v1735564601/checkbox_b7m9oh.png)

- <span id="radio">**Radio**</span>

```php
[
    'id' => 'radio', // field id
    'type' => 'radio', // field type
    'title' => _x( 'Radio Title', 'options', PREFIX ), // field title
    'value' => 'value1', // radio field value to be checked
    'choices' => [ // number of radio boxes
        'value1' => _x( 'Radio 1', 'options', PREFIX ),
        'value2' => _x( 'Radio 2', 'options', PREFIX ),
    ],
    'attr' => array( 'class' => 'custom-class', 'data-foo' => 'bar' ), // custom attributes added to the field
    'description' => _x( 'Radio description', 'options', PREFIX ), // field description
    'tooltip' => _x( 'More description in tooltip', 'options', PREFIX ), // field tooltip
    'divider' => true // add a border at the bottom
]
  ```

![Radio Preview](https://res.cloudinary.com/dzuieskuw/image/upload/v1735564616/radio_weytnk.png)

- <span id="text">**Text**</span>

```php
[
    'id' => 'text', // field id
    'type' => 'text', // field type
    'title' => _x( 'Text Title', 'options', PREFIX ), // field title
    'value' => 'This field is to display some simple text',
    'attr' => array( 'class' => 'custom-class', 'data-foo' => 'bar' ), // custom attributes added to the field
    'tooltip' => _x( 'More description in tooltip', 'options', PREFIX ), // field description
    'divider' => true // add a border at the bottom
]
  ```

![Text Preview](https://res.cloudinary.com/dzuieskuw/image/upload/v1735564620/text_r8tww5.png)

- <span id="wpeditor">**WPEditor**</span>

```php
[
    'id' => 'editor', // field id
    'type' => 'wpeditor', // field type
    'title' => _x( 'WP Editor Title', 'options', PREFIX ), // field title
    'value' => '', // default value
    'rows' => 6, // number of field rows
    'media_button' => true, // enable the media button
    'attr' => array( 'class' => 'custom-class', 'data-foo' => 'bar' ), // custom attributes added to the field
    'description' => _x( 'WP Editor description', 'options', PREFIX ), // field description
    'tooltip' => _x( 'More description in tooltip', 'options', PREFIX ), // field tooltip
    'divider' => true // add a border at the bottom
]
  ```

![WPEditor Preview](https://res.cloudinary.com/dzuieskuw/image/upload/v1735564626/wpeditor_l1xsny.png)

- <span id="switch">**Switch**</span>

```php
[
    'id' => 'switch', // field id
    'type' => 'switch', // field type
    'title' => _x( 'Switch Title', 'options', PREFIX ), // field title
    "size"  => "small", //medium, large - button size
    'value' => 'off', // default value
    'left-choice' => array(
        'value' => 'on',
        'label' => _x( 'Enable', 'options', PREFIX ),
    ),
    'right-choice' => array(
        'value' => 'off',
        'label' => _x( 'Disable', 'options', PREFIX ),
    ),
    
    'attr' => array( 'class' => 'custom-class', 'data-foo' => 'bar' ), // custom attributes added to the field
    'description' => _x( 'Input description', 'options', PREFIX ), // field description
    'tooltip' => _x( 'More description in tooltip', 'options', PREFIX ), // field tooltip
    'divider' => true // add a border at the bottom
]
  ```

![Switch Preview](https://res.cloudinary.com/dzuieskuw/image/upload/v1735564619/switch_p5hguz.png)

- <span id="dropdown">**Dropdown**</span>

```php
[
    'id' => 'dropdown', // field id
    'type' => 'dropdown', // field type
    'title' => _x( 'Dropdown Title', 'options', PREFIX ), // field title
    'value' => 'value2', // default value
    'choices' => [
        'value1' => _x( 'Option 1', 'options', PREFIX ),
        'value2' => _x( 'Option 2', 'options', PREFIX ),
        'value3' => _x( 'Option 3', 'options', PREFIX ),
        'value4' => _x( 'Option 4', 'options', PREFIX ),
        array( // optgroup - you can group the dropdown values
            [
                'label' => _x( 'Group 1', 'options', PREFIX ),
                'choices' => array(
                    'value5' => _x( 'Option 5', 'options', PREFIX ),
                    'value6' => _x( 'Option 6', 'options', PREFIX ),
                )
            ],
            [
                'label' => _x( 'Group 2', 'options', PREFIX ),
                'choices' => array(
                    'value7' => _x( 'Option 7', 'options', PREFIX ),
                    'value8' => _x( 'Option 8', 'options', PREFIX ),
                )
            ]
        )
    ],
    'attr' => array( 'class' => 'custom-class', 'data-foo' => 'bar' ), // custom attributes added to the field
    'description' => _x( 'Dropdown description', 'options', PREFIX ), // field description
    'tooltip' => _x( 'More description in tooltip', 'options', PREFIX ),  // field tooltip
    'divider' => true // add a border at the bottom
]

// Groups Only
[
    'id' => 'dropdown_group', // field id
    'type' => 'dropdown', // field type
    'title' => _x( 'Dropdown Group Title', 'options', PREFIX ), // field title
    'value' => 'value7', // default value
    'choices' => [
        array( // optgroup - groups of values
            [
                'label' => _x( 'Group 1', 'options', PREFIX ),
                'choices' => array(
                    'value5' => _x( 'Option 5', 'options', PREFIX ),
                    'value6' => _x( 'Option 6', 'options', PREFIX ),
                )
            ],
            [
                'label' => _x( 'Group 2', 'options', PREFIX ),
                'choices' => array(
                    'value7' => _x( 'Option 7', 'options', PREFIX ),
                    'value8' => _x( 'Option 8', 'options', PREFIX ),
                )
            ]
        )
    ],
    'attr' => array( 'class' => 'custom-class', 'data-foo' => 'bar' ), // custom attributes added to the field
    'description' => _x( 'Dropdown description', 'options', PREFIX ), // field description
    'tooltip' => _x( 'More description in tooltip', 'options', PREFIX ), // field tooltip
    'divider' => true // add a border at the bottom
]
  ```

![Dropdown Preview](https://res.cloudinary.com/dzuieskuw/image/upload/v1735564609/dropdown_vypptd.png)

- <span id="dropdown-multiple">**Dropdown Multiple**</span>

```php
[
    'id' => 'dropdown_multiple', // field id
    'type' => 'dropdown-multiple', // field type
    'title' => _x( 'Dropdown Multiple Title', 'options', PREFIX ), // field title
    'value' => [ 'value2', 'value4' ], // default value
    'size' => 6, // field area height
    'choices' => [
        'value1' => _x( 'Option 1', 'options', PREFIX ),
        'value2' => _x( 'Option 2', 'options', PREFIX ),
        'value3' => _x( 'Option 3', 'options', PREFIX ),
        'value4' => _x( 'Option 4', 'options', PREFIX )
    ],
    'attr' => array( 'class' => 'custom-class', 'data-foo' => 'bar' ), // custom attributes added to the field
    'description' => _x( 'Dropdown Multiple description', 'options', PREFIX ), // field description
    'tooltip' => _x( 'More description in tooltip', 'options', PREFIX ), // field tooltip
    'divider' => true // add a border at the bottom
]

// Groups Only
[
    'id' => 'dropdown__multiple_group', // field id
    'type' => 'dropdown-multiple', // field type
    'title' => _x( 'Dropdown Multiple Title', 'options', PREFIX ), // field title
    'value' => [ 'value5', 'value7' ], // default value
    'size' => 6, // field area height
    'choices' => [
        array( // optgroup - groups of values
            [
                'label' => _x( 'Group 1', 'options', PREFIX ),
                'choices' => array(
                    'value5' => _x( 'Option 5', 'options', PREFIX ),
                    'value6' => _x( 'Option 6', 'options', PREFIX )
                )
            ],
            [
                'label' => _x( 'Group 2', 'options', PREFIX ),
                'choices' => array(
                    'value7' => _x( 'Option 7', 'options', PREFIX ),
                    'value8' => _x( 'Option 8', 'options', PREFIX )
                )
            ]
        )
    ],
    'attr' => array( 'class' => 'custom-class', 'data-foo' => 'bar' ), // custom attributes added to the field
    'description' => _x( 'Dropdown Multiple description', 'options', PREFIX ), // field description
    'tooltip' => _x( 'More description in tooltip', 'options', PREFIX ),  // field tooltip
    'divider' => true  // add a border at the bottom
]
  ```

![Dropdown Multiple Preview](https://res.cloudinary.com/dzuieskuw/image/upload/v1735564608/dropdown-multiple_djirt6.png)

- <span id="multiinput">**MultiInput**</span>

```php
[
    'id' => 'multiinput', // field id
    'type' => 'multi-input', // field type
    'title' => _x( 'Multi Input Title', 'options', PREFIX ), // field title
    'value' => [ 'default value' ], // default value
    'limit' => 5, // max number of items allowed to be added dynamically
    'attr' => array( 'class' => 'custom-class', 'data-foo' => 'bar' ),  // custom attributes added to the field
    'description' => _x( 'Multi Input description', 'options', PREFIX ), // field description
    'tooltip' => _x( 'More description in tooltip', 'options', PREFIX ), // field tooltip
    'divider' => true // add a border at the bottom
]
```

![MultiInput Preview](https://res.cloudinary.com/dzuieskuw/image/upload/v1735564613/multiinput_kg3jfw.png)

- <span id="aceeditor">**AceEditor**</span>

```php
// css
[
    'id' => 'ace_editor2', // field id
    'type' => 'ace-editor', // field type
    'title' => _x( 'Ace Editor CSS', 'options', PREFIX ), // field title
    'value' => '.css{ display:block; }', // default value
    'mode' => 'css', //or javascript - editor mode
    'height' => 300, // field height
    'attr' => array( 'class' => 'custom-class', 'data-foo' => 'bar' ), // custom attributes added to the field
    'description' => _x( 'Ace Editor CSS description', 'options', PREFIX ), // field description
    'tooltip' => _x( 'More description in tooltip', 'options', PREFIX ), // field tooltip
    'divider' => true // add a border at the bottom
]

// javascript
[
    'id' => 'ace_editor', // field id
    'type' => 'ace-editor', // field type
    'title' => _x( 'Ace Editor Javascript', 'options', PREFIX ), // field title
    'value' => 'console.log("hello")', // default value
    'mode' => 'javascript', //or css - editor mode
    'height' => 300, // field height
    'attr' => array( 'class' => 'custom-class', 'data-foo' => 'bar' ), // custom attributes added to the field
    'description' => _x( 'Ace Editor Javascript description', 'options', PREFIX ), // field description
    'tooltip' => _x( 'More description in tooltip', 'options', PREFIX ), // field tooltip
    'divider' => true // add a border at the bottom
]
```

**CSS:**

![AceEditor CSS Preview](https://res.cloudinary.com/dzuieskuw/image/upload/v1735564600/aceeditor-css_yxrizy.png)

**JS:**

![AceEditor JS Preview](https://res.cloudinary.com/dzuieskuw/image/upload/v1735564601/aceeditor-js_hfciok.png)

- <span id="colorpicker">**ColorPicker**</span>

```php
//default
[
    'id' => 'colorpicker', // field id
    'type' => 'colorpicker', // field type
    'title' => _x( 'Colorpicker Title', 'options', PREFIX ), // field title
    'subtype' => 'default', //or default
    'palettes' => [ '#ba4e4e', '#0ce9ed', '#941940' ], // this colors pallets will be displayed in the colorpicker as default colors
    'value' => '#0ce9ed', // default value
    'attr' => array( 'class' => 'custom-class', 'data-foo' => 'bar' ), // custom attributes added to the field
    'description' => _x( 'Colorpicker description', 'options', PREFIX ), // field description
    'tooltip' => _x( 'More description in tooltip', 'options', PREFIX ), // field tooltip
    'divider' => true // add a border at the bottom
]

//rgba
[
    'id' => 'colorpicker_rgba', // field id
    'type' => 'colorpicker', // field type
    'title' => _x( 'Colorpicker RGBA Title', 'options', PREFIX ), // field title
    'subtype' => 'rgba', //or default
    'palettes' => [ // this colors pallets will be displayed in the colorpicker as default colors
        'rgba(0, 0, 0, 0.65)',
        'rgba(255, 255, 255, 0.8)',
        'rgba(255, 0, 0, 1)',
        'rgba(0, 255, 0, 0.5)',
        'rgba(0, 0, 255, 0.75)'
    ],
    'value' => 'rgba(255, 255, 255, 0.8)', // default value
    'attr' => array( 'class' => 'custom-class', 'data-foo' => 'bar' ), // custom attributes added to the field
    'description' => _x( 'Colorpicker description', 'options', PREFIX ), // field description
    'tooltip' => _x( 'More description in tooltip', 'options', PREFIX ), // field tooltip
    'divider' => true // add a border at the bottom
]
```

![ColorPicker Preview](https://res.cloudinary.com/dzuieskuw/image/upload/v1735564604/colorpicker_bmhlys.png)

**RGBA:**

![ColorPicker RGBA Preview](https://res.cloudinary.com/dzuieskuw/image/upload/v1735564603/colorpicker-rgba_jofvhy.png)

- <span id="datepicker">**DatePicker**</span>

```php
[
    'id' => 'datepicker', // field id
    'type' => 'datepicker', // field type
    'title' => _x( 'Datepicker Title', 'options', PREFIX ), // field title
    'format' => 'yy-mm-dd', // time format
    'value' => '2024-05-15', // default value
    'attr' => array( 'class' => 'custom-class', 'data-foo' => 'bar' ), // custom attributes added to the field
    'description' => _x( 'Datepicker description', 'options', PREFIX ), // field description
    'tooltip' => _x( 'More description in tooltip', 'options', PREFIX ), // field tooltip
    'divider' => true // add a border at the bottom
]
```

![DatePicker Preview](https://res.cloudinary.com/dzuieskuw/image/upload/v1735564605/datepicker_ar8szn.png)

- <span id="timepicker">**TimePicker**</span>

```php
[
    'id' => 'timepicker', // field id
    'type' => 'timepicker', // field type
    'title' => _x( 'TimePicker Title', 'options', PREFIX ), // field title
    'format' => 'HH:mm:ss', // time format
    'value' => '02:31:47', // default value
    'attr' => array( 'class' => 'custom-class', 'data-foo' => 'bar' ), // custom attributes added to the field
    'description' => _x( 'TimePicker description', 'options', PREFIX ), // field description
    'tooltip' => _x( 'More description in tooltip', 'options', PREFIX ), // field tooltip
    'divider' => true // add a border at the bottom
]
```

![TimePicker Preview](https://res.cloudinary.com/dzuieskuw/image/upload/v1735564622/timepicker_uezbxi.png)

- <span id="datetimepicker">**DateTimePicker**</span>

```php
[
    'id' => 'datetimepicker', // field id
    'type' => 'datetimepicker', // field type
    'title' => _x( 'DateTimePicker Title', 'options', PREFIX ), // field title
    'date-format' => 'yy-mm-dd', // date format
    'time-format' => 'HH:mm:ss', // time format
    'value' => '2024-05-14 08:11:00', // default value
    'attr' => array( 'class' => 'custom-class', 'data-foo' => 'bar' ), // custom attributes added to the field
    'description' => _x( 'DateTimePicker description', 'options', PREFIX ), // field description
    'tooltip' => _x( 'More description in tooltip', 'options', PREFIX ), // field tooltip
    'divider' => true // add a border at the bottom
]
```

![DateTimePicker Preview](https://res.cloudinary.com/dzuieskuw/image/upload/v1735564606/datetimepicker_o1kqa7.png)

- <span id="range-slider">**Range Slider**</span>

```php
[
    'id' => 'range-default', // field id
    'type' => 'range-slider', // field type
    'title' => _x( 'Range Slider Title', 'options', PREFIX ), // field title
    'range' => false, //default false
    'min' => 5, // min slider value
    'max' => 50, // max slider value
    'value' => [20], // default value
    'attr' => array( 'class' => 'custom-class', 'data-foo' => 'bar' ), // custom attributes added to the field
    'description' => _x( 'Range Slider description', 'options', PREFIX ), // field description
    'tooltip' => _x( 'More description in tooltip', 'options', PREFIX ), // field tooltip
    'divider' => true // add a border at the bottom
]

//subtype -> range
[
    'id' => 'range', // field id
    'type' => 'range-slider', // field type
    'title' => _x( 'Range Slider Range Title', 'options', PREFIX ), // field title
    'range' => true, //default false
    'min' => 5, // min slider value
    'max' => 50, // max slider value
    'value' => [ 20, 30 ], // default values
    'attr' => array( 'class' => 'custom-class', 'data-foo' => 'bar' ), // custom attributes added to the field
    'description' => _x( 'Range Slider Range description', 'options', PREFIX ), // field description
    'tooltip' => _x( 'More description in tooltip', 'options', PREFIX ), // field tooltip
    'divider' => true // add a border at the bottom
]
```

![Range Slider Preview](https://res.cloudinary.com/dzuieskuw/image/upload/v1735564618/range-slider_jseptx.png)

**Range True:**

![Range Slider Range Preview](https://res.cloudinary.com/dzuieskuw/image/upload/v1735564617/range-slider-range_h4ae1a.png)

- <span id="radio-image">**Radio Image**</span>

```php
[
    'id' => 'radio_image', // field id
    'type' => 'radio-image', // field type
    'title' => _x( 'Radio Image Title', 'options', PREFIX ), // field title
    'value' => 'value2', // radio field value to be checked
    'choices' => [
        'value1' => [
            'label' => _x( 'Radio Image 1', 'options', PREFIX ),
            'image' => 'images/demo1.png' // image preview
        ],
        'value2' => [
            'label' => _x( 'Radio Image 2', 'options', PREFIX ),
            'image' => 'images/demo2.png' // image preview
        ],
        'value3' => [
            'label' => _x( 'Radio Image 2', 'options', PREFIX ),
            'image' => 'images/demo3.png' // image preview
        ],
    ],
    'attr' => array( 'class' => 'custom-class', 'data-foo' => 'bar' ), // custom attributes added to the field
    'description' => _x( 'Radio Image description', 'options', PREFIX ), // field description
    'tooltip' => _x( 'More description in tooltip', 'options', PREFIX ), // field tooltip
    'divider' => true // add a border at the bottom
]
```

![Radio Image Preview](https://res.cloudinary.com/dzuieskuw/image/upload/v1735564615/radio-image_zjbjbi.png)

- <span id="multi-options">**Multi Options**</span>

```php
[
    'id' => 'multioptions', // field id
    'type' => 'multi-options', // field type
    'title' => _x( 'Multi Options Title', 'options', PREFIX ), // field title
    'value' => [], // default values
    'ajax' => false, // dont use ajax to load values
    'ajax-action' => '', // ajax action function to be used to retrieve the values
    'minimumInputLength' => 3, // type three letters to start the search
    'choices' => get_my_posts(), // get the choices from a function ( ex: post_id => post_title)
    'attr' => array( 'class' => 'custom-class', 'data-foo' => 'bar' ), // custom attributes added to the field
    'description' => _x( 'Multi Options description', 'options', PREFIX ), // field description
    'tooltip' => _x( 'More description in tooltip', 'options', PREFIX ), // field tooltip
    'divider' => true // add a border at the bottom
],

//load options via ajax -each typing will send an ajax request
// !!! Not Implemented Yet
[
    'id' => 'multioptions_ajax', // field id
    'type' => 'multi-options', // field type
    'title' => _x( 'Multi Options Title', 'options', PREFIX ), // field title
    'value' => [], // default values
    'ajax' => true, // use ajax to load values
    'ajax-action' => 'my_ajax_action_function', // ajax action function to be used to retrieve the values
    'minimumInputLength' => 0, // start the search when starting to type
    'choices' => [],
    'attr' => array( 'class' => 'custom-class', 'data-foo' => 'bar' ), // custom attributes added to the field
    'description' => _x( 'Multi Options description', 'options', PREFIX ), // field description
    'tooltip' => _x( 'More description in tooltip', 'options', PREFIX ), // field tooltip
    'divider' => true // add a border at the bottom
]
```

![Multi Options Preview](https://res.cloudinary.com/dzuieskuw/image/upload/v1735564614/multioptions_qzo2w7.png)

- <span id="dimensions">**Dimensions**</span>

```php
[
    'id'            => 'dimensions', // field id
    'type'          => 'dimension', // field type
    'title'         => _x( 'Dimensions Title', 'options', PREFIX ), // field title
    'value'         => [
        'size-1'       => 0, // first input field
        'size-2'       => 0, // second input field
        'size-3'       => 0, // third input field
        'size-4'       => 0, // fourth input field
        'unit'         => 'px',
        'border-style' => 'solid',
        'color'        => '#fff'
    ],  // default values
    //px,em,rem...
    "units-values"  => ["px" => "px", "%" => "%"], // sizes that should be displayed in the units dropdown
    // first input can't be disabled
    'size-2'        => true, // enable/disable second input field
    'size-3'        => true, // enable/disable third input field
    'size-4'        => true, // enable/disable fourth input field
    'units'         => true, // enable/disable units dropdown
    'border-styles' => true, // enable/disable border-styles dropdown
    'color'         => true, // enable/disable colorpicker field
    'input-icons'   => true, // enable/disable input icons
    'attr' => array( 'class' => 'custom-class', 'data-foo' => 'bar' ), // custom attributes added to the field
    'description' => _x( 'Borders description', 'options', PREFIX ), // field description
    'tooltip' => _x( 'More description in tooltip', 'options', PREFIX ), // field tooltip
    'divider' => true // add a border at the bottom
]
```

![Dimensions Preview](https://res.cloudinary.com/dzuieskuw/image/upload/v1735565150/dimension_itt1ov.png)

- <span id="upload">**Upload**</span>

```php
[
    'id' => 'upload', // field id
    'type' => 'upload', // field type
    'title' => _x( 'Upload Title', 'options', PREFIX ), // field title
    'value' => [
        'item' => 'http://mysite.com/wp-content/uploads/2024/05/pdf-sample.pdf', // attachment link
        'item_id' => 101 // attachment id - can be skipped
    ], // default value
    //Image: 'image' - This type displays only image files.
    //Video: 'video' - This type displays only video files.
    //Audio: 'audio' - This type displays only audio files.
    //Document: 'document' - This type displays document files such as PDFs.
    //Application: 'application' - This type displays application files.
    //PDF: 'application/pdf' - This type displays pdf files.
    'file_type' => 'application/pdf', // file type format used in the field
    'attr' => array( 'class' => 'custom-class', 'data-foo' => 'bar' ), // custom attributes added to the field
    'description' => _x( 'Upload description', 'options', PREFIX ), // field description
    'tooltip' => _x( 'More description in tooltip', 'options', PREFIX ), // field tooltip
    'divider' => true // add a border at the bottom
]
```

![Upload Preview](https://res.cloudinary.com/dzuieskuw/image/upload/v1735564624/upload_fymtap.png)

- <span id="upload-image">**Upload Image**</span>

```php
[
    'id' => 'upload_image', // field id
    'type' => 'upload-image', // field type
    'title' => _x( 'Upload Image Title', 'options', PREFIX ), // field title
    'value' => [
        'image' => 'http://mysite.com/wp-content/uploads/2024/img.jpg', // attachment link
        'image_id' => 12 // attachment id - can be skipped
    ],
    'attr' => array( 'class' => 'custom-class', 'data-foo' => 'bar' ), // custom attributes added to the field
    'description' => _x( 'Upload Image description', 'options', PREFIX ), // field description
    'tooltip' => _x( 'More description in tooltip', 'options', PREFIX ), // field tooltip
    'divider' => true // add a border at the bottom
]
```

![Upload Image Preview](https://res.cloudinary.com/dzuieskuw/image/upload/v1735564626/upoad-image_ayztnv.png)

- <span id="upload-gallery">**Upload Gallery**</span>

```php
[
    'id' => 'upload_gallery', // field id
    'type' => 'upload-gallery', // field type
    'title' => _x( 'Upload Gallery Title', 'options', PREFIX ), // field title
    'value' => [ 14, 12 ], //attachment ids
    'attr' => array( 'class' => 'custom-class', 'data-foo' => 'bar' ), // custom attributes added to the field
    'description' => _x( 'Upload Gallery description', 'options', PREFIX ), // field description
    'tooltip' => _x( 'More description in tooltip', 'options', PREFIX ), // field tooltip
    'divider' => true // add a border at the bottom
]
```

![Upload Gallery Preview](https://res.cloudinary.com/dzuieskuw/image/upload/v1735564624/upload-gallery_rdhcai.png)

- <span id="icon">**Icon**</span>

```php
[
    'id' => 'icon', // field id
    'type' => 'icon', // field type
    'title' => _x( 'Icon Title', 'options', PREFIX ), // field title
    'value' => [
        'icon-type' => 'dashicons', // icon type (available types: dashicons, fontawesome, divi, elusive, line, dev, bootstrap)
        'icon-class' => 'dashicons dashicons-universal-access-alt', //the icon class to be displayed
        'icon-code' => '\f507' // icon code 
    ],
    'attr' => array( 'class' => 'custom-class', 'data-foo' => 'bar' ), // custom attributes added to the field
    'description' => _x( 'Icon description', 'options', PREFIX ), // field description
    'tooltip' => _x( 'More description in tooltip', 'options', PREFIX ), // field tooltip
    'divider' => true // add a border at the bottom
]
```

![Icon Preview](https://res.cloudinary.com/dzuieskuw/image/upload/v1735564611/icon_qctacq.png)

![Icon Preview 2](https://res.cloudinary.com/dzuieskuw/image/upload/v1735564610/icon-preview_byfgch.png)

- <span id="typography">**Typography**</span>

```php
[
    'id' => 'typography', // field id
    'type' => 'typography', // field type
    'title' => _x( 'Typography Title', 'options', PREFIX ), // field title
    'value'          => [
        "font-family"    => [ "font" => "Gabarito" ], // default font family (you can check the font dropdown select options ids to grab the one you nee)
        "font-weight"    => 600,
        "font-style"     => "normal",
        "text-transform" => "uppercase",
        "text-decoration"=> "underline",
        "text-align"     => "left",
        "font-size"      => [ "value" => 16, "size" => "px" ], // it should have the value and also the unit type like px, em, rem...
        "line-height"    => [ "value" => 24, "size" => "px" ], // it should have the value and also the unit type like px, em, rem...
        "letter-spacing" => [ "value" => "", "size" => "px" ], // it should have the value and also the unit type like px, em, rem...
        "color"          => 'rgb(3, 7, 18)'
    ],
    'preview'        => true, // enable/disable preview area where you can see the changes live
    'upload'         => false, // not done yet
    'font-size'      => true, // enable/disable font size field
    'line-height'    => true, // enable/disable line height field
    'text-align'     => true, // enable/disable text align dropdown
    'letter-spacing' => true, // enable/disable line height field
    'color'          => true, // enable/disable colorpicker field
    'attr' => array( 'class' => 'custom-class', 'data-foo' => 'bar' ), // custom attributes added to the field
    'description' => _x( 'Typography description', 'options', PREFIX ), // field description
    'tooltip' => _x( 'More description in tooltip', 'options', PREFIX ), // field tooltip
    'divider' => true // add a border at the bottom
]
```

![Typography Preview](https://res.cloudinary.com/dzuieskuw/image/upload/v1735564623/typography_j60akd.png)

<span id="fields-settings-eleborations">**Fields Settings Elaboration:**</span>

`'id' => 'general-side-menu-settings'`- the fields is saved under this id, make sure that it is unique.

`'save' => 'separately'`- this setting will save each container individual field under its separate id,
that you can retrieve
via the standard WordPess
function [get_option("field id")](https://developer.wordpress.org/reference/functions/get_option/).
If the value is **group**, then all the options inside the container will be saved under the container id.

`'attr' => array( 'class' => 'custom-class', 'data-foo' => 'bar' )`- this will add any attributes that you
want or class to the container div tag.

`'value' => 'off'`- the field default value.

`'sortable' => true`- make the fields sortable (this is supported by some fields only)

`'fullwidth' => false`- make the field fullwidth instead of 3 columns view (this is supported by some fields only)

`'limit' => -1`- max number of items that can be added dynamically. -1 means that there is no limit.

`'tooltip' => _x( 'More description in tooltip', 'options', PREFIX )`- additional description in a tooltip (this can be
removed)

![Tooltip Preview](https://res.cloudinary.com/dzuieskuw/image/upload/v1735565328/tooltip_rkrefw.png)

`'divider' => true`- this will add a border after the field

![Divider Preview](https://res.cloudinary.com/dzuieskuw/image/upload/v1735565327/divider_hgy4pf.png)

<h3 id="live-fields">Live Fields Editing</h3>

===================================

Some of the custom fields can be used to add live changes. When you change the field value, you can target another
elements on your page like HTML attributes, styles or text.

![Live Editing Preview](https://res.cloudinary.com/dzuieskuw/image/upload/v1735645306/live-editing_w96lir.gif)

![Live Editing 2 Preview](https://res.cloudinary.com/dzuieskuw/image/upload/v1735645515/live-editing-2_k2vl1p.gif)

**Fields that support live editing:**

```php
//input
[
    'id'          => 'input',
    'type'        => 'input',
    'title'       => _x( 'Title', 'options', PREFIX ),
    'value'       => '',
    'live'    => [
        "revert"    => true,
        "target"    => "content",
        "selectors" => [ ".custom-class .title", ".custom-class .description" ]
    ]
]

//textarea
[
    'id'      => 'textarea',
    'type'    => 'textarea',
    'title'   => _x( 'Title', 'options', PREFIX ),
    'value'   => '',
    'rows'    => 6,
    'default' => '',
    'live'    => [
        "revert"    => true,
        "target"    => "content",
        "selectors" => [ ".custom-class .title", ".custom-class .description" ]
    ]
    'description' => _x( 'Textarea description', 'options', PREFIX ),
]

//wp editor
[
    'id'           => 'editor',
    'type'         => 'wpeditor',
    'title'        => _x( 'Title', 'options', PREFIX ),
    'value'        => '',
    'rows'         => 6,
    'media_button' => true,
    'live'    => [
        "revert"    => true,
        "target"    => "content",
        "selectors" => [ ".custom-class .title", ".custom-class .description" ]
    ]
]

//dropdown
[
    'id'          => 'dropdown',
    'type'        => 'dropdown',
    'title'       => _x( 'Title', 'options', PREFIX ),
    'value'       => 'no-repeat',
    'choices'     => [
        'no-repeat' => _x( 'No Repeat', 'options', PREFIX ),
        'repeat'    => _x( 'Repeat All', 'options', PREFIX ),
        'repeat-x'  => _x( 'Repeat Horizontally', 'options', PREFIX ),
    ],
    //apply styles
    'live'        => [
        "revert"    => true,
        "target"    => "style",
        "selectors" => [
            "background-repeat" => [ ".custom-class .custom-class-content" ],
        ]
    ],
    //show hide elements
    'live'        => [
        "target"    => "display",
        "selectors" => [
            "revert"    => true,
            //keys must match the choices keys
            "show" => [ ".custom-class .icon" ],
            "hide" => [ ".custom-class .img" ]
        ]
    ]
]

//dimension
[
    'id'            => 'dimensions',
    'type'          => 'dimension',
    'title'         => _x( 'Title', 'options', PREFIX ),
    'value'         => [
        'size-1'    => 8,
        'size-2'  => 8,
        'size-3' => 8,
        'size-4'   => 8,
        'unit'         => 'px',
        'border-style' => 'solid',
        'color'        => '#000000'
    ],
    "units-values"  => [ "%" => "%", "px" => "px", "em" => "em" ],
    'size-2'        => true,
    'size-3'        => true,
    'size-4'        => true,
    'units'         => true,
    'border-styles' => true,
    'color'         => true,
    'input-icons'   => true,
    'palettes'      => [],
    'live'          => [
        "revert"    => true,
        "target"    => "style",
        "selectors" => [
            "border"        => [ ".custom-class .custom-class-content" ],
            "border-radius" => [ ".custom-class .custom-class-content" ]
        ]
    ]
]

//range slider 
[
    'id'          => 'range-slider',
    'type'        => 'range-slider',
    'title'       => "",
    'range'       => false,
    'min'         => 0,
    'max'         => 500,
    'value'       => [48],
    'live'        => [
        "revert"    => true,
        "target"    => "style",
        "selectors" => [
            "width" => [ ".custom-class .img" ],
        ]
    ]
]

//range slider - range true
[
    'id'          => 'range-slider',
    'type'        => 'range-slider',
    'title'       =>  _x( 'Title', 'options', PREFIX ),
    'range'       => true,
    'min'         => 0,
    'max'         => 500,
    'value'       => [ 48, 150 ],
    'live'        => [
        "revert"    => true,
        "target"    => "style",
        "selectors" => [
            //always add 2 CSS properties here for 2 range slider inputs
            "width,height" => [ ".custom-class .img" ]
        ]
    ]
]

//upload image
[
    'id'          => 'modal_image',
    'type'        => 'upload-image',
    'title'       => _x( 'Title', 'options', PREFIX ),
    'value'       => [],
    'live'        => [
        "revert"    => true,
        "target"    => "attr",
        "selectors" => [
            "src"      => [ ".custom-class .img" ],
            "data-src" => [ ".custom-class .img" ],
        ]
    ],
    //or
    'live'        => [
        "revert"    => true,
        "target"    => "style",
        "selectors" => [
            "background-image" => [ ".custom-class .img" ],
            "border-image"     => [ ".custom-class" ],
            "background"       => [ ".custom-class" ],
        ]
    ]
]

//icon
[
    'id'          => 'icon',
    'type'        => 'icon',
    'title'       => _x( 'Title', 'options', PREFIX ),
    'value'       => [],
    //change icon class
    'live'        => [
        "revert"    => true,
        "target"    => "class",
        "selectors" => [ ".custom-class .icon i" ]
    ],
]

//colorpicker
[
    'id'          => 'colorpicker',
    'type'        => 'colorpicker',
    'title'       => _x( 'Title', 'options', PREFIX ),
    'subtype'     => 'rgba',
    'palettes'    => [],
    'value'       => 'rgba(229, 231, 235, 0.75)',
    'live'        => [
        "revert"    => true,
        "target"    => "style",
        "selectors" => [
            "background-color" => [ ".custom-class" ],
        ]
    ]
]

//typography
[
    'id'             => 'typography',
    'type'           => 'typography',
    'title'          => _x( 'Title', 'options', PREFIX ),
    'value'          => [
        "font-family"    => [ "font" => "Gabarito" ],
        "font-weight"    => 600,
        "font-style"     => "normal",
        "font-size"      => [ "value" => 16, "size" => "px" ],
        "text-align"     => "left",
        "line-height"    => [ "value" => 24, "size" => "px" ],
        "letter-spacing" => [ "value" => "", "size" => "px" ],
        "color"          => 'rgb(3, 7, 18)'
    ],
    'preview'        => false,
    'upload'         => false,
    'font-size'      => true,
    'line-height'    => true,
    'text-align'     => true,
    'letter-spacing' => true,
    'color'          => true,
    'live'           => [
        "revert"    => true,
        "target"    => "style",
        "selectors" => [ ".custom-class .title" ]
    ]
]

//switch
[
    'id'           => 'switch',
    'type'         => 'switch',
    'title'        => _x( 'Title', 'options', PREFIX ),
    'value'        => 'off',
    'left-choice'  => array(
        'value' => 'on',
        'label' => _x( 'Enable', 'options', PREFIX ),
    ),
    'right-choice' => array(
        'value' => 'off',
        'label' => _x( 'Disable', 'options', PREFIX ),
    ),
    'live'         => [
        "revert"    => true,
        "target"    => "display",
        "selectors" => [
            //keys must match the right-choice/left-choice values
            "on"  => [ ".custom-class .icon" ],
            "off" => [ ".custom-class .img" ]
        ]
    ]
]

//toggle - show - hide options
[
    'id'           => 'toggle',
    'type'         => 'toggle',
    'title'        => _x( 'Title', 'options', PREFIX ),
    "size"         => "small",
    'value'        => 'off',
    'left-choice'  => array(
        'value'   => 'on',
        'label'   => _x( 'Yes', 'options', PREFIX ),
        'options' => [
        ]
    ),
    'right-choice' => array(
        'value'   => 'off',
        'label'   => _x( 'No', 'options', PREFIX ),
        'options' => [
        ]
    ),
    'live'         => [
        "revert"    => true,
        "target"    => "display",
        "selectors" => [
            //keys must match the right-choice/left-choice values
            "on"  => [ ".custom-class .icon" ],
            "off" => [ ".custom-class .img" ]
        ]
    ]
]
```

**Live Editing Elaboration:**

- A field can contain only one live setting.
- `revert`- is used for the VB modal, because if you change something there and then close the popup without saving it,
  then the `revert => true`, will restore the previous saved values.
- `target`- what exactly do you want to target on live editing. There are several available targets and each field
  support one or several of them, but not all of them. See above what target each field supports.
    - `target : content`        - change content / html content
    - `target : class`          - change class attribute
    - `target : style`          - change item styles
    - `target : display`        - show / hide elements
    - `target : attr`           - change element attribute, selectors has the attribute name and the selectors of this
      attribute
- `"selectors" => [ ".custom-class" ]` - an array of selectors that you want to target
    - For VB modals, if you have several elements on the page and want to target that specific element when
      opening its modal, then you can add {{module-id}} to your selectors area.
      `"selectors" => [ "#{{module-id}}.ppht-box .pht-box-title" ]` - `{{module-id}}` will insert the module id. Each
      module has a generated unique id, that match the modal id. This way it will know what element exactly to target.

<h3 id="how-to-use-fields">How To Use:</h3>

============

You can use the custom fields by adding them in your `settings/options` folder in `dashboard-pages`, `posts`,
`terms` and `vb` folders, see <a href="#how-to-use-in-a-plugin">How to use in a Plugin</a> section.

1. `"dashboard-pages-options-folder" => "options/dashboard-pages/"`- this is the default folder where it will look for
   the settings, you can override it.

   Inside this folder, you will create php files with the custom fields. The files should match the menu slug, used when
   creating the dashboard menus:
    - `"menu_slug" => "general-settings"` - will be `general-settings.php` file
    - `"menu_slug" => "testing-settings"` - will be `testing-settings.php` file


2. `"post-types-options-folder" => "options/posts/"`- this is the default folder where it will look for the settings,
   you can override it.

   Inside this folder, you will create php files with the custom fields. The files should match the post types names (
   slugs):
    - `"post"` - will be `post.php` file
    - `"page"` - will be `page.php` file
    - `"cpt-name"` - will be `cpt-name.php` file


3. `"terms-options-folder" => "options/terms/"`- this is the default folder where it will look for the settings, you can
   override it.

   Inside this folder, you will create php files with the custom fields. The files should match the terms and category
   names (slugs):
    - `"category"` - will be `category.php` file
    - `"custom-term-name"` - will be `custom-term-name.php` file


4. `"vb-modal-options-folder" => "options/vb/"`- this is the default folder where it will look for the settings,
   you can override it.

   Inside this folder, you will create php files or folders with the custom fields. The folders should match the post
   types where you enabled the VB from `"vb-register-on-post-types" => ["cpt1", "cpt2"]` setting. Inside these folders
   you can add the modules files that will be available only inside that post type. You can add modules
   PHP files inside the `vb` folder and these modules will be available across all post types where you enabled the VB.
   The modules files can have any names.

    - `"vb/cpt-name/my-module.php"` - **my-module module** will be available only inside the cpt-name post type
    - `"vb/cpt-name/my-second-module.php"` - **my-second-module** module will also be available only inside the cpt-name
      post type
    - `"vb/my-other-module.php"` - **my-other-module** module will be available across all post types where VB is
      present

```php
[
    "paths" => [
        "options" => [
            "dashboard-pages-options-folder" => "options/dashboard-pages/", // the folder where the dashboard menu options are located
            "post-types-options-folder"      => "options/posts/",  // the folder where the posts and custom posts options are located
            "terms-options-folder"           => "options/terms/",  // the folder where the terms and categories options are located
            "vb-modal-options-folder"        => "options/vb/",  // the folder where the visual builder modals options are located
        ],
    ],
    "features" => [
        ...
    ]
]
```

**Default Folders Structure Preview:**

![Options Folder Structure Preview](https://res.cloudinary.com/dzuieskuw/image/upload/v1735917446/settings-folder-strucutre_adiexw.png)

<h2 id="dashboard-menus">Dashboard Menus</h2>

===================================

You can easily create dashboard menus items by adding these settings to your plugin:

For more info, check the [WordPress Docs](https://developer.wordpress.org/reference/functions/add_menu_page/).

```php
$main_menu_slug = 'main-settings'; // this is the parent menu item slug.
$settings_slug  = 'general-settings'; // this is a submenu items slug

$template_path = ''; // you can add your own PHP template here to display the content of the menu item, default is the views/main-view.php file

$main_menu = [
    'type'            => 'default', // menu type - you can remove it as it is default implicitly
	'page_title'      => _x( 'Parent Page', 'menu', PREFIX ),
	'menu_title'      => _x( 'Parent Page', 'menu', PREFIX ),
	'capability'      => 'manage_options',
	'menu_slug'       => $main_menu_slug, // menu item slug
	'icon_url'        => 'images/menu-icon.png',
	'position'        => 99,
	'template_path'   => $template_path, // PHP template path to display the content of your menu item 
	'additional_args' => [] // additional arguments to be passed to menu template
];

$submenu_items_values = [
    'settings'        => [
        'type'            => 'default', // menu type - you can remove it as it is default implicitly
        'parent_slug'     => $main_menu_slug, // menu item slug
        'page_title'      => _x( 'Settings', 'menu', PREFIX ),
        'menu_title'      => _x( 'Settings', 'menu', PREFIX ),
        'capability'      => 'manage_options',
        'menu_slug'       => $settings_slug,
        'template_path'   => $template_path, // PHP template path to display the content of your menu item 
        'api_endpoint'    => $settings_slug,
        'additional_args' => [], // additional arguments to be passed to menu template
    ],
    
    //cpt - in case you want to add a menu item of your custom post under the parent page
    'cpt'         => [
        'type'            => 'custom', // menu type - custom is if you want to add custom links instead of stadard dashboard menu item
        'parent_slug'     => $main_menu_slug, // menu item slug
        'page_title'      => _x( 'Post Page', 'menu', PREFIX ),
        'menu_title'      => _x( 'Custom Posts', 'menu', PREFIX ),
        'capability'      => 'manage_options',
        'menu_slug'       => 'edit.php?post_type=cpt', // link to your custom post
        'template_path'   => '', // Here it is not needed because it will be redirected to your custom post
        'additional_args' => [] // additional arguments to be passed to menu template
    ]
];

return [
    'main_menu' => $main_menu,
    'submenus'  => $submenu_items_values
];
```

<h3 id="how-to-use-dashboard-menus">How To Use:</h3>

============

You can create custom dashboard menus by adding the above code in your `settings` folder in `dashboard-pages.php` file,
see <a href="#how-to-use-in-a-plugin">How to use in a Plugin</a> section.

`"dash-menus-settings-file" => "dashboard-pages.php"`- by default the file is `dashboard-pages.php`, but you can
override it or add it
to another folder like `my-menus/my-menus.php`

```php
[
    "paths" => [
        "features" => [
             "dash-menus-settings-file" => "dashboard-pages.php", // the file where the dashboard menus settings are located
        ],
    ],
    "features" => [
        ...
    ]
]
```

<h2 id="custom-posts">Custom Posts</h2>

===================================

You can create custom posts and terms via these settings in your plugin:

For more info, check the [WordPress Docs](https://developer.wordpress.org/reference/functions/register_post_type/).

```php
$post_types = [
    'cpt1' => [
        'args' => [
            'public'              => false,
            'show_ui'             => true,
            'publicly_queryable'  => false,
            'exclude_from_search' => true,
            'show_in_nav_menus'   => false,
            'labels'              => [
                'name'                     => _x( 'Posts', 'cpt', PREFIX ),
                'singular_name'            => _x( 'Post', 'cpt', PREFIX ),
                'add_new'                  => _x( 'Add New Post', 'cpt', PREFIX ),
                'add_new_item'             => _x( 'Add New Post', 'cpt', PREFIX ),
                'edit_item'                => _x( 'Edit Post', 'cpt', PREFIX ),
                'new_item'                 => _x( 'New Post', 'cpt', PREFIX ),
                'all_items'                => _x( 'All Posts', 'cpt', PREFIX ),
                'view_item'                => _x( 'View Post', 'cpt', PREFIX ),
                'view_items'               => _x( 'View Posts', 'cpt', PREFIX ),
                'archives'                 => _x( 'Post Archives', 'cpt', PREFIX ),
                'attributes'               => _x( 'Post Attributes', 'cpt', PREFIX ),
                'insert_into_item'         => _x( 'Add into post', 'cpt', PREFIX ),
                'uploaded_to_this_item'    => _x( 'Uploaded to this post', 'cpt', PREFIX ),
                'featured_image'           => _x( 'Post Image', 'cpt', PREFIX ),
                'set_featured_image'       => _x( 'Set post image', 'cpt', PREFIX ),
                'remove_featured_image'    => _x( 'Remove post image', 'cpt', PREFIX ),
                'use_featured_image'       => _x( 'Use as post image', 'cpt', PREFIX ),
                'filter_items_list'        => _x( 'Filter posts list', 'cpt', PREFIX ),
                'filter_by_date'           => _x( 'Filter by date', 'cpt', PREFIX ),
                'items_list_navigation'    => _x( 'Posts list navigation', 'cpt', PP HT_PREFIX ),
                'items_list'               => _x( 'Post list', 'cpt', PREFIX ),
                'item_published'           => _x( 'Post published.', 'cpt', PREFIX ),
                'item_published_privately' => _x( 'Post published privately.', 'cpt', PREFIX ),
                'item_reverted_to_draft'   => _x( 'Post reverted to draft.', 'cpt', PREFIX ),
                'item_scheduled'           => _x( 'Post scheduled.', 'cpt', PREFIX ),
                'item_updated'             => _x( 'Post updated.', 'cpt', PREFIX ),
                'item_link'                => _x( 'Post Link', 'cpt', PREFIX ),
                'item_link_description'    => _x( 'A link to the post', 'cpt', PREFIX ),
                'search_items'             => _x( 'Search Posts', 'cpt', PREFIX ),
                'not_found'                => _x( 'No posts found', 'cpt', PREFIX ),
                'not_found_in_trash'       => _x( 'No posts found in Trash', 'cpt', PREFIX ),
                'menu_name'                => _x( 'Posts', 'cpt', PREFIX ),
                'name_admin_bar'           => _x( 'Post', 'cpt', PREFIX ),
                'parent_item_colon'        => _x( 'Parent Post', 'cpt', PREFIX )
            ],
            'description'         => _x( 'A post post type', 'cpt', PREFIX ),
            'hierarchical'        => false,
            'has_archive'         => false,
            'can_export'          => true,
            'taxonomies'          => array( "custom_term1", "custom_term2" ),
            'menu_position'       => 80,
            'show_in_menu'        => false,
            'show_in_admin_bar'   => true,
            'query_var'           => false,
            'show_in_rest'        => false,
            'template'            => true,
            'template_lock'       => false,
            'map_meta_cap'        => true,
            'rewrite'             => array(
                'slug'       => 'cpt1',
                'with_front' => false,
                'pages'      => true,
                'feeds'      => true,
                'ep_mask'    => EP_PERMALINK,
            ),
            'supports'            => [ 'title', ]
        ],
    ],
    'cpt2' => [...]
];

$taxonomies = [
    $post_type_name => [
        "custom_term1" => [
            'public'             => false,
            'publicly_queryable' => false,
            'hierarchical'       => true,
            'labels'             => [
                'name'                  => _x( 'Terms', 'cpt', PREFIX ),
                'singular_name'         => _x( 'Term', 'cpt', PREFIX ),
                'menu_name'             => _x( 'Terms', 'cpt', PREFIX ),
                'name_admin_bar'        => _x( 'Term', 'cpt', PREFIX ),
                'search_items'          => _x( 'Search Terms', 'cpt', PREFIX ),
                'popular_items'         => _x( 'Popular Terms', 'cpt', PREFIX ),
                'all_items'             => _x( 'All Terms', 'cpt', PREFIX ),
                'edit_item'             => _x( 'Edit Term', 'cpt', PREFIX ),
                'view_item'             => _x( 'View Term', 'cpt', PREFIX ),
                'update_item'           => _x( 'Update Term', 'cpt', PREFIX ),
                'add_new_item'          => _x( 'Add New Term', 'cpt', PREFIX ),
                'new_item_name'         => _x( 'New Term Name', 'cpt', PREFIX ),
                'not_found'             => _x( 'No terms found.', 'cpt', PREFIX ),
                'no_terms'              => _x( 'No terms', 'cpt', PREFIX ),
                'items_list_navigation' => _x( 'Terms list navigation', 'cpt', PREFIX ),
                'items_list'            => _x( 'Terms list', 'cpt', PREFIX ),
                'select_name'           => _x( 'Select Term', 'cpt', PREFIX ),
                'parent_item'           => _x( 'Parent Term', 'cpt', PREFIX ),
                'parent_item_colon'     => _x( 'Parent Term:', 'cpt', PREFIX )
            ],
            'query_var'          => false,
            'show_in_rest'       => false,
            'show_ui'            => true,
            'show_in_menu'       => false,
            'show_in_nav_menus'  => false,
            'show_tagcloud'      => false,
            'show_admin_column'  => true,
            'rewrite'            => [
                'slug'         => "custom_term1",
                'with_front'   => false,
                'hierarchical' => false,
                'ep_mask'      => EP_NONE
            ],
        ],
        "custom_term2" => [...]
    ]
];

return [
	'post_types' => $post_types,
	'taxonomies' => $taxonomies
];
```

<h3 id="how-to-use-custom-posts">How To Use:</h3>

============

You can create custom posts by adding the above code in your `settings` folder in `cpts.php` file,
see <a href="#how-to-use-in-a-plugin">How to use in a Plugin</a> section.

`"cpts-settings-file" => "cpts.php"`- by default the file is `cpts.php`, but you can override it or add it
to another folder like `my-cpts/my-cpts.php`

```php
[
    "paths" => [
        "features" => [
             "cpts-settings-file" => "cpts.php" // the file where custom posts creation settings are located
        ],
    ],
    "features" => [
        ...
    ]
]
```

<h2 id="custom-sidebars">Custom Sidebars</h2>

===================================

You can create custom sidebars via these settings in your plugin:

For more info, check the [WordPress Docs](https://developer.wordpress.org/themes/functionality/sidebars/).

```php
[
    [
        'name' => _x( 'First Sidebar', 'sidebar', PREFIX ),
        'id' => 'first-sidebar',
        'description' => _x( 'Add widgets here to appear in your First sidebar.', 'sidebar', PREFIX ),
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
        'name' => _x( 'Second Sidebar', 'sidebar', PREFIX ),
        'id' => 'second-sidebar',
        'description' => _x( 'Add widgets here to appear in your First sidebar.', 'sidebar', PREFIX ),
        'class' => '',
        'before_widget' => '<section id="%1$s" class="widget %2$s">',
        'after_widget' => '</section>',
        'before_title' => '<h2 class="widget-title">',
        'after_title' => '</h2>',
        'before_sidebar' => '',
        'after_sidebar' => '',
        'show_in_rest' => false
    ]
]
```

<h3 id="how-to-use-custom-sidebars">How To Use:</h3>

============

You can create custom sidebars by adding the above code in your `settings` folder in `sidebars.php` file,
see <a href="#how-to-use-in-a-plugin">How to use in a Plugin</a> section.

`"sidebars-settings-file"   => "sidebars.php"`- by default the file is `sidebars.php`, but you can override it or add it
to another folder like `sidebars/my-sidebars.php`

```php
[
    "paths" => [
        "features" => [
            "sidebars-settings-file" => "sidebars.php" // the file where custom sidebars creation settings are located
        ],
    ],
    "features" => [
        ...
    ]
]
```

<h2 id="dynamic-sidebars">Dynamic Sidebars</h2>

===================================

You can enable the dynamic sidebar creation form in the Widgets area to dynamically create and remove sidebars.

![Dynamic sidebars Preview](https://res.cloudinary.com/dzuieskuw/image/upload/v1735824902/dynamic_sidebars_ssmuhu.gif)

<h3 id="how-to-use-dynamic-sidebars">How To Use:</h3>

============

You can enable this form by adding this code on your plugin, see <a href="#how-to-use-in-a-plugin">How to use in a
Plugin</a> section.

`"enable-dynamic-sidebars"   => true` - default is false

```php
[
    "paths"    => [
        ...
    ],
    "features" => [
        "enable-dynamic-sidebars"   => true, // enable the dynamic sidebars form creation, default no
    ]
]
```

<h2 id="framework-utilities">Framework Utilities</h2>

All framework helpers that you can use in your plugin

<h3 id="manifest">Manifest</h3>

===================================

<h3 id="makefile">MakeFile</h3>

===================================

<h3 id="functions">Functions</h3>

===================================

<h3 id="custom-hooks">Custom Hooks</h3>

===================================

<h3 id="custom-filters">Custom Filters</h3>

===================================

<h2 id="license">License</h2>

The framework is released under the MIT License. See the **[LICENSE](https://opensource.org/license/MIT)** link
for details.

<h2 id="authors">Authors</h2>

The framework was created by **[Alex](https://github.com/puyaalexxx)**.
