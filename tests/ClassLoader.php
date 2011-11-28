<?php
namespace ClassLoader\tests\units;
require_once dirname(__DIR__) . '/src/ClassLoader.php';

use \mageekguy\atoum, \ClassLoader\ClassLoader as CL;

class ClassLoader extends atoum\test {

  public function testRegistryManagers() {
    $autoload_callback = array('ClassLoader\\ClassLoader', 'loadClass');
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
      ->phpClass('ClassLoader\\ClassLoader')
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
        CL::addNamespaceHandler($namespace_info);
      })
      ->isInstanceOf('BadMethodCallException');

    $namespace_info = array(
      'path prefix' => '/',
    );
    $this->assert
      ->exception(function() use ($namespace_info) {
        CL::addNamespaceHandler($namespace_info);
      })
      ->isInstanceOf('BadMethodCallException');

    $namespace_info = array(
      'namespace' => 'ClassLoader',
    );
    $this->assert
      ->exception(function() use ($namespace_info) {
        CL::addNamespaceHandler($namespace_info);
      })
      ->isInstanceOf('BadMethodCallException');
  }

  public function testBuildClassPath() {
    $namespace_info = CL::getNamespaceInfoDefaults();
    $namespace_info['path prefix'] = 'test://tests';
    $namespace_info['namespace prefix'] = 'ClassLoader';
    $namespace_info['file prefix'] = 'test.';
    $namespace_info['file extension'] = '.class.php';
    $class = 'ClassLoader\\FakeNamespace\\Asserts\\TestAssert';
    $this->assert
      ->callTo(array('\\ClassLoader\\ClassLoader', 'buildClassPath'))
      ->withArguments($namespace_info, $class)
      ->return('test://tests/FakeNamespace/Asserts/test.TestAssert.class.php');

    $namespace_info = CL::getNamespaceInfoDefaults();
    $namespace_info['namespace prefix'] = 'ClassLoader';
    $class = 'TestAssert';
    $this->assert
      ->callTo(array('\\ClassLoader\\ClassLoader', 'buildClassPath'))
      ->withArguments($namespace_info, $class)
      ->return('/TestAssert.php');

    $namespace_info = CL::getNamespaceInfoDefaults();
    $namespace_info['path prefix'] = 'path';
    $namespace_info['namespace prefix'] = 'ClassLoader';
    $class = 'Test\\TestAssert';
    $this->assert
      ->callTo(array('\\ClassLoader\\ClassLoader', 'buildClassPath'))
      ->withArguments($namespace_info, $class)
      ->return('path/Test/TestAssert.php');

    $namespace_info = CL::getNamespaceInfoDefaults();
    $namespace_info['path prefix'] = 'path';
    $namespace_info['namespace prefix'] = 'ClassLoader';
    $class = 'mint\\Test\\TestAssert';
    $this->assert
      ->callTo(array('\\ClassLoader\\ClassLoader', 'buildClassPath'))
      ->withArguments($namespace_info, $class)
      ->return(null);

    $namespace_info = CL::getNamespaceInfoDefaults();
    $namespace_info['path prefix'] = 'test://tests';
    $namespace_info['namespace prefix'] = 'app_ClassLoader';
    $namespace_info['namespace separator'] = '_';
    $namespace_info['file prefix'] = 'test.';
    $namespace_info['file extension'] = '.class.php';
    $class = 'app_ClassLoader_FakeNamespace_Asserts_TestAssert';
    $this->assert
      ->callTo(array('\\ClassLoader\\ClassLoader', 'buildClassPath'))
      ->withArguments($namespace_info, $class)
      ->return('test://tests/FakeNamespace/Asserts/test.TestAssert.class.php');
  }

  public function testNamespaceHandler() {
    CL::addNamespaceHandler(array(
      'path prefix' => __DIR__ .  '/misc/classes',
      'namespace prefix' => 'test',
    ));
    CL::setClassPath('test\\ClassLoader\\FakeNamespace\\FakeClass', null);
    $this->assert
      ->variable(CL::getClassPath('test\\ClassLoader\\FakeNamespace\\FakeClass'))
      ->isNull();
    CL::loadClass('test\\TestClass');
    $this->assert
      ->boolean(class_exists('test\\TestClass', false))
      ->isTrue();
  }
}
