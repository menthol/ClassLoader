<?php

namespace menthol\ClassLoader;

final class ClassLoader {

  static private $namespaces = array();
  static private $classes = array();

  private function __construct() {}
  private function __clone() {}

  static public function register() {
    return spl_autoload_register(array(__CLASS__, 'loadClass'));
  }

  static public function unregister() {
    return spl_autoload_unregister(array(__CLASS__, 'loadClass'));
  }

  static public function setClassPath($class, $path) {
    self::$classes[$class] = $path;
  }

  static public function getClassPath($class) {
    if (!isset(self::$classes[$class]) || empty(self::$classes[$class]) || !is_readable(self::$classes[$class])) {
      $namespace_handlers = self::getNamespaceHandlers($class);
      self::$classes[$class] = null;
      foreach($namespace_handlers as $handler) {
        $path = call_user_func($handler['path builder callback'], $handler, $class);
        if (is_readable($path)) {
          self::$classes[$class] = $path;
          break;
        }
      }
    }
    return self::$classes[$class];
  }

  static public function addNamespaceHandler(array $namespace_handler) {
    if (!isset($namespace_handler['path prefix']) || !isset($namespace_handler['namespace prefix'])) {
      throw new \BadMethodCallException('Both path and namespace are required.');
    }
    $namespace_handler += self::getNamespaceInfoDefaults();
    self::$namespaces[$namespace_handler['namespace prefix']][$namespace_handler['path prefix']] = $namespace_handler;
  }

  static public function getNamespaceInfoDefaults() {
    return array(
      'file prefix' => '',
      'file extension' => '.php',
      'namespace separator' => '\\',
      'namespace prefix' => null,
      'path namespace separator' => DIRECTORY_SEPARATOR,
      'path separator' => DIRECTORY_SEPARATOR,
      'path builder callback' => array(__CLASS__, 'buildClassPath'),
      'path prefix' => '',
      'filename builder callback' => array(__CLASS__, 'buildClassFilename'),
    );
  }

  static public function getNamespaceHandlers($namespace) {
    $build_namespace_handler = array();
    foreach(self::$namespaces as $namespace_prefix => $namespace_info) {
      if (strpos($namespace, $namespace_prefix) === 0) {
        $build_namespace_handler += $namespace_info;
      }
    }
    return $build_namespace_handler;
  }

  static public function buildClassPath($namespace_info, $class) {
    if (strpos($class, $namespace_info['namespace prefix']) !== 0) {
      return null;
    }
    $return = substr($class, strlen($namespace_info['namespace prefix']) + 1);
    $return = substr($return, 0 , strrpos($return, $namespace_info['namespace separator']));
    $return = str_replace($namespace_info['namespace separator'], $namespace_info['path namespace separator'], $return);
    $return = (empty($return) ? '' : $namespace_info['path separator'] . $return);
    $return .= $namespace_info['path separator'];
    $return .= call_user_func($namespace_info['filename builder callback'], $namespace_info, $class);
    return  $namespace_info['path prefix'] . $return;
  }

  static public function buildClassFilename($namespace_info, $class) {
    return $namespace_info['file prefix']
          . substr($class, strrpos($class, $namespace_info['namespace separator']) + 1)
          . $namespace_info['file extension'];
  }

  static public function setCachedData(array $data) {
    if (isset($data['classes']) && is_array($data['classes'])) {
      self::$classes += $data['classes'];
    }
  }

  static public function getCachableData() {
    $data['classes'] = self::$classes;
    return $data;
  }

  static public function loadClass($class) {
    $path = self::getClassPath($class);
    if (isset($path)) {
      require_once $path;
    }
  }
}
