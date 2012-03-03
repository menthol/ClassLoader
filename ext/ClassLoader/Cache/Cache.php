<?php

namespace Extensions\ClassLoader\Cache;

abstract class Cache {

  protected function __construct() {}
  protected function __clone() {}
  protected function __wakeup() {}
  protected function __set_state() {}

  abstract public function getPaths($class);
  abstract public function savePaths(array $paths, $class);

}
