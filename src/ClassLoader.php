<?php

namespace ClassLoader;

use ClassLoader\Cache\Cache;
use ClassLoader\Cache\Instance;
use ClassLoader\PathBuilder\PathBuilder;
use ClassLoader\PathBuilder\Spl;

final class ClassLoader {

  private $_cache;
  private $_path_builders = array();

  private function __construct() {}
  private function __clone() {}
  private function __wakeup() {}
  private function __set_state() {}

  public static function init() {
    return self::initWithCache(Instance::init());
  }

  public static function initWithCache(Cache $cache) {
    $instance = new ClassLoader();
    $instance->_cache = $cache;
    return $instance;
  }

  public static function initWithPathBuilder(PathBuilder $pathbuilder, Cache $cache = null) {
    if ($cache == null) {
      $instance = self::init();
    }
    else {
      $instance = self::initWithCache($cache);
    }
    $instance->addPathBuilder($pathbuilder);
    return $instance;
  }

  public function register() {
    return spl_autoload_register(array($this, 'loadClass'));
  }

  public function unregister() {
    return spl_autoload_unregister(array($this, 'loadClass'));
  }

  public function loadClass($class) {
    $class = ltrim($class, '\\');
    if (class_exists($class, false)) {
      return true;
    }
    $paths = array_values($this->_cache->getPaths($class));
    foreach($paths as $key => $path) {
      if ($this->checkPath($path, $class)) {
        if ($key != 0) {
          unset($paths[$key]);
          array_unshift($paths, $path);
          $this->_cache->savePaths($paths, $class);
        }
        return true;
      }
    }
    $paths = array();
    foreach($this->_path_builders as $path_builder) {
      $paths[] = $path_builder->getPath($class);
    }
    foreach($paths as $key => $path) {
      if ($this->checkPath($path, $class)) {
        if ($key != 0) {
          unset($paths[$key]);
          array_unshift($paths, $path);
        }
        $this->_cache->savePaths($paths, $class);
        return true;
      }
    }
    return false;
  }

  public function addPathBuilder(PathBuilder $path_builder) {
    $this->_path_builders[] = $path_builder;
  }

  private function checkPath($path, $class) {
    static $cache = array();
    if (!isset($cache[$class][$path])) {
      if (is_readable($path)) {
        include_once $path;
      }
      $cache[$class][$path] = class_exists($class, false);
    }
    return $cache[$class][$path];
  }
}
