<?php
namespace ClassLoader\tests\units;

require_once dirname(__DIR__) . '/scripts/init.php';
require_once dirname(__DIR__) . '/../atoum/scripts/runner.php';

use \mageekguy\atoum;

class ClassLoader extends atoum\test {

  public function testInit() {
    $class_loader = \ClassLoader\ClassLoader::init();
    $this->assert->object($class_loader)->isInstanceOf('\\ClassLoader\\ClassLoader');

    $autoload_callback = array($class_loader, 'loadClass');
    $class_loader->unregister();
    $this->assert
      ->phpArray(spl_autoload_functions())
      ->notContains($autoload_callback);
    $this->assert
      ->boolean($class_loader->register())
      ->isTrue();
    $this->assert
      ->boolean($class_loader->register())
      ->isTrue();
    $this->assert
      ->array(spl_autoload_functions())
      ->contains($autoload_callback);
    $this->assert
      ->boolean($class_loader->unregister())
      ->isTrue();
    $this->assert
      ->boolean($class_loader->unregister())
      ->isFalse();
  }
}
