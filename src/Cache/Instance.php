<?php

namespace ClassLoader\Cache;

class Instance extends Cache {

  private $_cache = array();

  public static function init() {
    return new Instance();
  }

  public function getPaths($class) {
    if (!isset($this->_cache[$class])) {
      $this->_cache[$class] = array();
    }
    return $this->_cache[$class];
  }

  public function savePaths(array $paths, $class) {
    $this->_cache[$class] = $paths;
    return true;
  }

}
