<?php

namespace Extensions\ClassLoader\PathBuilder;

class Spl extends PathBuilder {

  private $_options = array();

  public static function initWithNamespace($namespace, $path, array $options = array()) {
    return self::initWithPath($path, array('namespace' => $namespace) + $options);
  }

  public static function initWithPath($path, array $options = array()) {
    $instance = new Spl();
    $instance->_options = array('path' => $path) + $options + self::getDefaultOptions();
    return $instance;
  }

  public static function initWithPrefix($prefix, $path, array $options = array()) {
    return self::initWithPath($path, array('prefix' => $prefix) + $options);
  }

  private static function getDefaultOptions() {
    return array(
      'path separator' => DIRECTORY_SEPARATOR,
      'namespace' => '',
      'namespace separator' => '\\',
      'prefix' => '',
      'prefix separator' => '_',
      'extension' => '.php',
    );
  }


  public function getPath($class) {
    $namespace = '';
    $class_part = $class;
    if (strpos($class, $this->_options['namespace separator']) !== false) {
      $namespace = substr($class, 0, strrpos($class, $this->_options['namespace separator']));
      $class_part = substr($class, strlen($namespace)  + strlen($this->_options['namespace separator']));
    }
    $prefix = '';
    $file = $class_part;
    if (strpos($class_part, $this->_options['prefix separator']) !== false) {
      $prefix = substr($class_part, 0, strrpos($class_part, $this->_options['prefix separator']));
      $file = substr($class_part, strlen($prefix)  + strlen($this->_options['prefix separator']));
    }

    if ((empty($this->_options['namespace']) || $namespace == $this->_options['namespace'] || strpos($namespace, $this->_options['namespace'] . $this->_options['namespace separator']) === 0)
          && (empty($this->_options['prefix']) || $prefix == $this->_options['prefix'] || strpos($prefix, $this->_options['prefix'] . $this->_options['prefix separator']) === 0)) {
      $path = rtrim($this->_options['path'], $this->_options['path separator']) . $this->_options['path separator'];
      if ($namespace != $this->_options['namespace']) {
        $exposed_namespace = $namespace;
        if (!empty($this->_options['namespace'])) {
          $exposed_namespace = substr($namespace, strlen($this->_options['namespace'] . $this->_options['namespace separator']));
        }
        $path .= str_replace($this->_options['namespace separator'], $this->_options['path separator'], $exposed_namespace);
        $path .= $this->_options['path separator'];
      }
      if ($prefix != $this->_options['prefix']) {
        $exposed_prefix = $prefix;
        if (!empty($this->_options['prefix'])) {
          $exposed_prefix = substr($prefix, strlen($this->_options['prefix'] . $this->_options['prefix separator']));
        }
        $path .= str_replace($this->_options['prefix separator'], $this->_options['path separator'], $exposed_prefix);
        $path .= $this->_options['path separator'];
      }
      $path .= $file . $this->_options['extension'];
      return $path;
    }
    return null;
  }

}
