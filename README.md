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
        - [Fields Settings Elaborations](#fields-settings-eleborations)
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

---

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
     'id' => 'group', // container id
     'type' => 'group', // container type
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
     'id' => 'tabs', // container id
     'type' => 'tabs', // container type
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
     'id'          => 'panel', // container id
     'type'        => 'panel', // container type
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
     'id' => 'accordion', // container id
     'type' => 'accordion', // container type
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
     'id' => 'addable', // container id
     'type' => 'addable-box', // container type
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

- <span id="toggle">**Toggle**</span>

A toggle field to show hide specific fields.

```php
 [
     'id' => 'toggle', // container id
     'type' => 'toggle', // container type
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

===================================

<h3 id="fields">Fields</h3>

===================================

<span id="fields-settings-eleborations">**Field Settings Elaborations:**</span>

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

`'divider' => true`- this will add a border after the field

<h2 id="framework-utilities">Framework Utilities</h2>

All framework helpers that you can use in your plugin

<h2 id="license">License</h2>

The framework is released under the MIT License. See the **[LICENSE](https://opensource.org/license/MIT)** link
for details.

<h2 id="authors">Authors</h2>

The framework was created by **[Alex](https://github.com/puyaalexxx)**.
