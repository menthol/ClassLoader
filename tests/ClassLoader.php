<?php
namespace menthol\ClassLoader\tests\units;
require_once dirname(__DIR__).'/classes/ClassLoader.php';
require_once dirname(__DIR__) . '/vendor/mageekguy.atoum.phar';

use \mageekguy\atoum, \menthol\ClassLoader\ClassLoader as CL;

class ClassLoader extends atoum\test {

  public function testRegistryManagers() {
    $autoload_callback = array('menthol\\ClassLoader\\ClassLoader', 'loadClass');
    CL::unregister();
    $this->assert
      ->phpArray(spl_autoload_functions())
      ->notContains($autoload_callback);
    $this->assert
      ->boolean(CL::registerClassLoader())
      ->isTrue();
    $this->assert
      ->boolean(CL::registerClassLoader())
      ->isTrue();
    $this->assert
      ->phpArray(spl_autoload_functions())
      ->contains($autoload_callback);
    $this->assert
      ->boolean(CL::unregister())
      ->isTrue();
    $this->assert
      ->boolean(CL::unregister())
      ->isFalse();
    $this->assert
      ->phpClass('menthol\\ClassLoader\\ClassLoader')
      ->hasMethod('__construct');
  }

  public function testClassBasicManagement() {
    CL::setClassPath(__CLASS__, __FILE__);
    $this->assert
      ->string(CL::getClassPath(__CLASS__, false))
      ->isEqualTo(__FILE__);
  }

  public function testNamespaceManagement() {
    $namespace_info = array();
    $this->assert
      ->exception(function() use ($namespace_info) {
        CL::setNamespaceHandler($namespace_info);
      })
      ->isInstanceOf('BadMethodCallException');

    $namespace_info = array(
      'path prefix' => '/',
    );
    $this->assert
      ->exception(function() use ($namespace_info) {
        CL::setNamespaceHandler($namespace_info);
      })
      ->isInstanceOf('BadMethodCallException');

    $namespace_info = array(
      'namespace' => 'menthol',
    );
    $this->assert
      ->exception(function() use ($namespace_info) {
        CL::setNamespaceHandler($namespace_info);
      })
      ->isInstanceOf('BadMethodCallException');
  }

  public function testBuildClassPath() {
    $namespace_info = CL::getNamespaceInfoDefaults();
    $namespace_info['path prefix'] = 'test://tests';
    $namespace_info['namespace prefix'] = 'menthol\\ClassLoader';
    $namespace_info['file prefix'] = 'test.';
    $namespace_info['file extension'] = '.class.php';
    $class = 'menthol\\ClassLoader\\FakeNamespace\\Asserts\\TestAssert';
    $this->assert
      ->callTo(array('\menthol\ClassLoader\ClassLoader', 'buildClassPath'))
      ->withArguments($namespace_info, $class)
      ->return('test://tests/FakeNamespace/Asserts/test.TestAssert.class.php');

    $namespace_info = CL::getNamespaceInfoDefaults();
    $namespace_info['namespace prefix'] = 'menthol';
    $class = 'menthol\\TestAssert';
    $this->assert
      ->callTo(array('\menthol\ClassLoader\ClassLoader', 'buildClassPath'))
      ->withArguments($namespace_info, $class)
      ->return('/TestAssert.php');

    $namespace_info = CL::getNamespaceInfoDefaults();
    $namespace_info['path prefix'] = 'path';
    $namespace_info['namespace prefix'] = 'menthol';
    $class = 'menthol\\Test\\TestAssert';
    $this->assert
      ->callTo(array('\menthol\ClassLoader\ClassLoader', 'buildClassPath'))
      ->withArguments($namespace_info, $class)
      ->return('path/Test/TestAssert.php');

    $namespace_info = CL::getNamespaceInfoDefaults();
    $namespace_info['path prefix'] = 'path';
    $namespace_info['namespace prefix'] = 'menthol';
    $class = 'mint\\Test\\TestAssert';
    $this->assert
      ->callTo(array('\menthol\ClassLoader\ClassLoader', 'buildClassPath'))
      ->withArguments($namespace_info, $class)
      ->return(null);

    $namespace_info = CL::getNamespaceInfoDefaults();
    $namespace_info['path prefix'] = 'test://tests';
    $namespace_info['namespace prefix'] = 'menthol_ClassLoader';
    $namespace_info['namespace separator'] = '_';
    $namespace_info['file prefix'] = 'test.';
    $namespace_info['file extension'] = '.class.php';
    $class = 'menthol_ClassLoader_FakeNamespace_Asserts_TestAssert';
    $this->assert
      ->callTo(array('\menthol\ClassLoader\ClassLoader', 'buildClassPath'))
      ->withArguments($namespace_info, $class)
      ->return('test://tests/FakeNamespace/Asserts/test.TestAssert.class.php');
  }

  public function testNamespaceHandler() {
    CL::setNamespaceHandler(array(
      'path prefix' => __DIR__ .  '/misc/classes',
      'namespace prefix' => 'menthol\\test',
    ));
    CL::setClassPath('menthol\\test\\ClassLoader\\FakeNamespace\\FakeClass', null);
    $this->assert
      ->variable(CL::getClassPath('menthol\\test\\ClassLoader\\FakeNamespace\\FakeClass'))
      ->isNull();
    CL::loadClass('menthol\\test\\TestClass');
    $this->assert
      ->boolean(class_exists('menthol\\test\\TestClass', false))
      ->isTrue();
  }
}
