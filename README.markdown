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
$instance = \ClassLoader\ClassLoader::init();
$instance->register();

// Unregister ClassLoader.
$instance->unregister();
```

#### Classic

```php
<?php
// Register namespace.
$instance = \ClassLoader\ClassLoader::init();
$instance->register();

// Add a path builder
$path_builder = \Extensions\ClassLoader\PathBuilder\Spl::initWithNamespace('myapp', '/my/app/directory');
$instance->addPathBuilder($path_builder);

// Autoload file {my_app_base_dir}/classes/Controllers/MainController.php.
$app = new /myapp/Controllers/MainController();
```

#### Fast methode

```php
<?php
// Register namespace.
$path_builder = \Extensions\ClassLoader\PathBuilder\Spl::initWithNamespace('myapp', '/my/app/directory');
\ClassLoader\ClassLoader::initWithPathBuilder($path_builder)->register();

// Autoload file {my_app_base_dir}/classes/Controllers/MainController.php.
$app = new /myapp/Controllers/MainController();
```


