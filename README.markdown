# *ClassLoader*
## Class loader for PHP 5.3

* version : 1.0
* status : alpha
* license : GNU v2
* irc : #menthol-classloader

### Usage examples

#### Registry management

```php
<?php
// Register ClassLoder.
\menthol\ClassLoader\ClassLoader::register();

// Unregister ClassLoader.
\menthol\ClassLoader\ClassLoader::unregister();
```

#### Classic

```php
<?php
// Register namespace.
\menthol\ClassLoader::addNamespace('myapp', my_app_base_dir() . '/classes');

// Autoload file {my_app_base_dir}/classes/Controllers/MainController.php.
$app = new /myapp/Controllers/MainController();
```

#### Classic many namespaces

```php
<?php
// Register namespaces.
\menthol\ClassLoader::addNamespaces(array(
  array('myapp1', my_app_base_dir() . '/classes/myapp1'),
  array('myapp2', my_app_base_dir() . '/classes/myadd2'),
  array('myapp3', my_app_base_dir() . '/classes/myadd3'),
));

// Autoload file {my_app_base_dir}/classes/myapp1/Controllers/MainController.php.
$app = new /myapp1/Controllers/MainController();
```


#### Pear style class

```php
<?php
// Register namespace classic method.
\menthol\ClassLoader\ClassLoader::addNamespace('myapp', my_app_base_dir() . '/classes', '_');

// Register namespace handler method.
\menthol\ClassLoader\ClassLoader::addNamespaceHandler(array(
  'namespace prefix' => 'myapp',
  'namespace separator' => '_',
  'path prefix' => my_app_base_dir() . '/classes',
));

// Autoload file {my_app_base_dir}/classes/Controllers/MainController.php.
$app = new myapp_Controllers_MainController();
```

#### One class

```php
<?php
\menthol\ClassLoader\ClassLoader::setClassPath('Namespace\\ClassName', '/path/to/class.php');
$class = new Namespace\ClassName();
```

#### Many classes

```php
<?php
\menthol\ClassLoader\ClassLoader::setClassesPath(array(
  array('Namespace\\ClassName1', '/path/to/class1.php'),
  array('Namespace\\ClassName2', '/path/to/class2.php'),
  array('Namespace\\ClassName3', '/path/to/class3.php'),
  array('Namespace\\ClassName4', '/path/to/class4.php'),
  array('Namespace\\ClassName5', '/path/to/class5.php'),
));
$class = new Namespace\ClassName();
```

### configuration
You have to config the class loader before the first use of unknown class.
Use `ClassLoader::addNamespaceHandler(array $handler)` to config yours namespaces.

the handler array can take this properties :

* "namespace prefix" : *required* the full class name must start with.
  > ex `menthol\Controller`
* "path prefix" : *required* current file path of the namespace.
  > ex `__DIR__ . '/../classes'`
* "file extension" : extension of the final filename.
  > default : `.php`
* "file prefix" : prefix of final filename
* "namespace separator" : namespace separator char.
  > default : `\`
* "path namespace separator" : the namespace separator in final path.
  > default : `DIRECTORY_SEPARATOR`
* "path separator" : char between path and class filename.
  > default : `DIRECTORY_SEPARATOR`
* "path builder callback" : *advanced user Only* a callback to build the full filename.
  > default : `Classloader::buildClassPath(array $handler, $classname)`
* "filename builder callback" : *advanced user Only* a callback to build the final class filename.
  > default : `ClassLoader::buildClassFilename(array $handler, $classname)`
