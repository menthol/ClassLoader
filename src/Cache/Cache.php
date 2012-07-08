<?php

namespace ClassLoader\Cache;

abstract class Cache {

  protected function __construct() {}
  protected function __clone() {}
  protected function __wakeup() {}
  protected function __set_state() {}

  public abstract function getPaths($class);
  public abstract function savePaths(array $paths, $class);

}
