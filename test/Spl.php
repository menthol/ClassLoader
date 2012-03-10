<?php
namespace Extensions\ClassLoader\PathBuilder\tests\units;

require_once dirname(__DIR__) . '/scripts/init.php';

use \mageekguy\atoum;

class Spl extends atoum\test {

  public function testInit() {
    $path_builder = \Extensions\ClassLoader\PathBuilder\Spl::initWithPath('/base/dir');
    $this->assert->object($path_builder)->isInstanceOf('\\Extensions\\ClassLoader\\PathBuilder\\Spl');
    $this->assert->string($path_builder->getPath('Class'))->isEqualTo('/base/dir/Class.php');
    $this->assert->string($path_builder->getPath('Prefix_Class'))->isEqualTo('/base/dir/Prefix/Class.php');
    $this->assert->string($path_builder->getPath('Prefix_Sub_Class'))->isEqualTo('/base/dir/Prefix/Sub/Class.php');
    $this->assert->string($path_builder->getPath('Namespace\\Class'))->isEqualTo('/base/dir/Namespace/Class.php');
    $this->assert->string($path_builder->getPath('Namespace\\Sub\\Class'))->isEqualTo('/base/dir/Namespace/Sub/Class.php');
    $this->assert->string($path_builder->getPath('Namespace\\Prefix_Class'))->isEqualTo('/base/dir/Namespace/Prefix/Class.php');
    $this->assert->string($path_builder->getPath('Namespace\\Sub\\Prefix_Sub_Class'))->isEqualTo('/base/dir/Namespace/Sub/Prefix/Sub/Class.php');
  }

}
