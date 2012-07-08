<?php

namespace ClassLoader\PathBuilder;

abstract class PathBuilder {

  protected function __construct() {}
  protected function __clone() {}
  protected function __wakeup() {}
  protected function __set_state() {}

  public abstract function getPath($class);

}
