# *ClassLoader*
## Class loader for PHP 5.3

* version : 1.0
* status : alpha
* license : GNU v2
* irc : [#menthol|classloader](irc://irc.freenode.net#menthol|classloader "menthol classloader chatroom") [menthol (pipe) classloader]

### Usage examples

#### Registry management

```php
<?php
// register
\menthol\ClassLoader\ClassLoader::register();

// unregister
\menthol\ClassLoader\ClassLoader::unregister();
```

#### Classic

```php
<?php
\menthol\ClassLoader\ClassLoader::setNamespaceHandler(array(
  'path prefix' => my_app_base_dir() . '/classes',
  'namespace prefix' => 'myapp',
));

// Autoload file {my_app_base_dir}/classes/Controllers/MainController.php
$app = new /myapp/Controllers/MainController();
```
#### Pear style class

```php
<?php
\menthol\ClassLoader\ClassLoader::setNamespaceHandler(array(
  'path prefix' => my_app_base_dir() . '/classes',
  'namespace prefix' => 'myapp',
  'namespace separator' => '_',
));

// Autoload file {my_app_base_dir}/classes/Controllers/MainController.php
$app = new myapp_Controllers_MainController();
```

#### One class

```php
<?php
\menthol\ClassLoader\ClassLoader::setClassPath('Namespace\\ClassName', '/path/to/class.php');
$class = new Namespace\ClassName();
```

### configuration
You have to config the class loader before the first use of unknown class.
Use `ClassLoader::setNamespaceHandler(array $handler)` to config yours namespaces.

the handler array can take this properties :

* "namespace prefix" : *required* the full class name must start with, ex `menthol\Controller`
* "path prefix" : *required* current file path of the namespace, ex `__DIR__ . '/../classes'`
* "file extension" : extension of the final filename, default : `.php`
* "file prefix" : prefix of final filename
* "namespace separator" : namespace separator char, default : `\`
* "path namespace separator" : the namespace separator in final path, default : `DIRECTORY_SEPARATOR`
* "path separator" : char between path and class filename, default : `DIRECTORY_SEPARATOR`
* "path builder callback" : *advanced user Only* a callback to build the full filename, default : `Classloader::buildClassPath(array $handler, $classname)`
* "filename builder callback" : *advanced user Only* a callback to build the final class filename, default : `ClassLoader::buildClassFilename(array $handler, $classname)`
