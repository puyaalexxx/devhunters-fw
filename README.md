# devhunters framework
**The framework used in my plugins**


#### **->Steps to do when used as a folder inside the plugin**

1. git clone the framework inside the plugin
2. add this line in composer.json psr4 object from the plugin folder 
   `"DHT\\" : "devhunters_framework/"`
3. run `composer update` in the framework folder to include the vendor folder
4. add this line in the **_plugin folder > plugin.php_** file somewhere on top <br>
`   require_once (plugin_dir_path(__FILE__)  . "devhunters_framework/vendor/autoload.php");`

#### **->Steps to do when used as a composer package**

1. use this code to add the package from git inside composer.json file
```json
{
   "repositories": [
      {
         "type": "vcs",
         "url": "https://github.com/puyaalexxx/devhunters_framework"
      }
   ],
   "require": {
      "devhunters/devhunters_framework"   : "dev-main"
   },
   "autoload" : {
      "files": [
         "src/constants.php",
         "src/helpers/general.php"
      ],
      "psr-4" : {

         "DHT\\" : "vendor/devhunters/devhunters_framework/",

         "RHT\\Src\\" : "src/"

      }
   }
}
```
2. don't forget the auth json file with the git token
3. run `compose update` to load the package
4. comment this line from the plugin.php file if exist <br />
`   require_once (plugin_dir_path(__FILE__)  . "devhunters_framework/vendor/autoload.php");
`
