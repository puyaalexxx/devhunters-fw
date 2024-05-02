# devhunters framework
**Version 1.0.0**

**The framework used in my plugins**


### **<span style="color: #2271b1">->Steps to do when used as a folder inside the plugin</span>**

1. git clone the framework inside the plugin
2. add this line in composer.json psr4 object from the plugin folder 
   `"DHT\\" : "devhunters-fw/"`
3. run `composer update` in the framework folder to include the vendor folder
4. add this line in the **_plugin folder > plugin.php_** file somewhere on top <br>
`   require_once (plugin_dir_path(__FILE__)  . "devhunters-fw/vendor/autoload.php");`

### **<span style="color: #2271b1">->Steps to do when used as a composer package</span>**

1. use this code to add the package from git inside composer.json file
```json
{
   "repositories": [
      {
         "type": "vcs",
         "url": "https://github.com/puyaalexxx/devhunters-fw"
      }
   ],
   "require": {
      "devhunters/devhunters-fw"   : "dev-main"
   },
   "autoload" : {
      "files": [
         "src/constants.php",
         "src/helpers/general.php"
      ],
      "psr-4" : {

         "DHT\\" : "vendor/devhunters/devhunters-fw/",

         "RHT\\Src\\" : "src/"

      }
   }
}
```
2. don't forget the auth json file with the git token
3. run `compose update` to load the package
4. comment this line from the plugin.php file if exist <br />
`   require_once (plugin_dir_path(__FILE__)  . "devhunters-fw/vendor/autoload.php");
`
