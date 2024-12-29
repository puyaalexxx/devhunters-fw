# DevHunters framework : A framework to easier create WordPress plugins

**Version 1.0.0**

## **Introduction**

___

This is a framework that makes it easier to create WordPress plugins. It offers many features, such as:

1. custom fields
2. simple visual builder with modals
3. creating dashboard menus via settings
4. creating custom post types via settings
5. dynamic sidebars feature
6. registering custom sidebars via settings

## Table of Contents

___

1. [Installation](#Installation)
2. [Features](#Features)
    - [Custom Fields](#custom-fields)
        - [Containers](#containers)
            - [Simple](#simple)
            - [SideMenu](#sidemenu)
            - [TabsMenu](#tabsmenu)
        - [Groups](#groups)
        - [Toggles](#toggles)
        - [Fields](#fields)
    - [Creating Dashboard Menus](#Dasboard-Menus)
    - [Creating Custom Posts](#Custom-Posts)
    - [Creating Custom Sidebars](#Custom-Sidebars)
    - [Enabling Dynamic Sidebars](#Dynamic-Sidebars)
    - [Visual Builder](#Visual-Builder)
    - [CLI](#CLI)
3. [Framework Utilities](#Framework-Utilities)
    - [Manifest](#Manifest)
    - [Functions](#Functions)
    - [Custom Hooks](#Custom-Hooks)
    - [Custom Filters](#Custom-Filters)
4. [Licence](#License)
5. [Authors](#Authors)

## **Installation**

___

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

## **Features**

---

All the framework features that you can use.

<h3 id="custom-fields">Custom Fields</h3>

---

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

SideMenu via refresh links - each menu link will open the provided **page_link** via refresh

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

SideMenu as tabs - `'subtype' => 'tabs'` - each menu item will be opened as a tab on the same page:

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
];
  ```

![TabsMenu Preview](https://res.cloudinary.com/dzuieskuw/image/upload/v1735481674/tabsmenu_f6bq9a.png)

**Some Explanations:**

`'id'      => 'general-side-menu-settings'`- the fields is saved under this id, make sure that it is unique.

`'save' => 'separately'`- this setting will save each container individual field under its separate id,
that you can retrieve
via the standard WordPess
function [get_option("field id")](https://developer.wordpress.org/reference/functions/get_option/).
If the value is **group**, then all the options inside the container will be saved under the container id.

`'attr' => array( 'class' => 'custom-class', 'data-foo' => 'bar' )`- this will add any attributes that you
want or class to the container div tag.

<h3 id="groups">Groups</h3>

---

<h3 id="toggles">Toggles</h3>

---

<h3 id="fields">Fields</h3>

---

## **Framework Utilities**

___

All framework helpers that you can use in your plugin

## **License**

___

The framework is released under the MIT License. See the **[LICENSE](https://opensource.org/license/MIT)** link
for details.

## **Authors**

___

The framework was created by **[Alex](https://github.com/puyaalexxx)**.
