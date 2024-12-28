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

___

All the framework features that you can use.

<h3 id="custom-fields" style="text-align:center">Custom Fields</h3>

<hr style="width: 75%; margin: 0 auto;"/>

You have 4 types or custom fields.

- <p style="color: #3CB371;"><strong>Containers</strong></p>
- <p style="color: #3CB371;"><strong>Groups</strong></p>
- <p style="color: #3CB371;"><strong>Toggles</strong></p>
- <p style="color: #3CB371;"><strong>Fields</strong></p>

You can use them from top to bottom. You can add fields inside toggles, toggles inside groups and groups
inside containers, however you can't use them otherwise. You can't add containers inside fields, groups
inside fields or containers inside toggles.

So it should be like this - **Containers > Groups > Toggles > Fields**

<h3 style="text-align:center">Containers</h3>
<hr style="width: 50%; margin: 0 auto; "/>

Containers are the top level custom fields that you can add to place other fields inside.
There are 3 container types at the moment:

- <p style="color: #3CB371;"><strong>Simple</strong></p>

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

- <p style="color: #3CB371;"><strong>SideMenu</strong></p>
- <p style="color: #3CB371;"><strong>TabsMenu</strong></p>

'save' => 'separately'

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
