# *ClassLoader*
## Class loader for PHP 5.3

* version : 1.0
* status : beta
* license : GNU v2
* irc : freenode #menthol-classloader

### Usage examples

#### Registry management

```php
<?php
// Register ClassLoder.
$cache = \ClassLoader\ClassLoader::init();
$cache->register();

// Unregister ClassLoader.
$cache->unregister();
```

#### Classic

```php
<?php
// Register namespace.
$cache = \ClassLoader\ClassLoader::init();
$cache->register();

// Add a path builder
$cache->addPathBuilder(\Extensions\ClassLoader\PathBuilder\SplPathBuilder::initWithNamespace('myapp', '/my/app/directory'));

// Autoload file {my_app_base_dir}/classes/Controllers/MainController.php.
$app = new /myapp/Controllers/MainController();
```
