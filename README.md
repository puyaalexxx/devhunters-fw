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
2. [Features](#features)
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
    - [Dashboard Menus](#dasboard-menus)
    - [Custom Posts](#custom-posts)
    - [Custom Sidebars](#custom-sidebars)
    - [Dynamic Sidebars](#dynamic-sidebars)
    - [Visual Builder](#visual-builder)
    - [CLI](#cli)
3. [Framework Utilities](#framework-utilities)
    - [Manifest](#manifest)
    - [Functions](#functions)
    - [Custom Hooks](#custom-hooks)
    - [Custom Filters](#custom-filters)
4. [Licence](#license)
5. [Authors](#authors)

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

<h2 id="framework-utilities">Framework Utilities</h2>

All framework helpers that you can use in your plugin

<h2 id="license">License</h2>

The framework is released under the MIT License. See the **[LICENSE](https://opensource.org/license/MIT)** link
for details.

<h2 id="authors">Authors</h2>

The framework was created by **[Alex](https://github.com/puyaalexxx)**.
