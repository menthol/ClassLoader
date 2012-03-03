<?php

use ClassLoader\ClassLoader;
use Extensions\ClassLoader\PathBuilder\SplPathBuilder;

if (!class_exists('ClassLoader\\ClassLoader')) {
  require dirname(__DIR__) . DIRECTORY_SEPARATOR . 'src' . DIRECTORY_SEPARATOR . 'ClassLoader.php';
}
if (!class_exists('Extensions\\ClassLoader\\Cache\\Cache')) {
  require dirname(__DIR__) . DIRECTORY_SEPARATOR . 'ext' . DIRECTORY_SEPARATOR . 'ClassLoader' . DIRECTORY_SEPARATOR . 'Cache' . DIRECTORY_SEPARATOR . 'Cache.php';
}
if (!class_exists('Extensions\\ClassLoader\\Cache\\Instance')) {
  require dirname(__DIR__) . DIRECTORY_SEPARATOR . 'ext' . DIRECTORY_SEPARATOR . 'ClassLoader' . DIRECTORY_SEPARATOR . 'Cache' . DIRECTORY_SEPARATOR . 'Instance.php';
}
if (!class_exists('Extensions\\ClassLoader\\PathBuilder\\PathBuilder')) {
  require dirname(__DIR__) . DIRECTORY_SEPARATOR . 'ext' . DIRECTORY_SEPARATOR . 'ClassLoader' . DIRECTORY_SEPARATOR . 'PathBuilder' . DIRECTORY_SEPARATOR . 'PathBuilder.php';
}
if (!class_exists('Extensions\\ClassLoader\\PathBuilder\\SplPathBuilder')) {
  require dirname(__DIR__) . DIRECTORY_SEPARATOR . 'ext' . DIRECTORY_SEPARATOR . 'ClassLoader' . DIRECTORY_SEPARATOR . 'PathBuilder' . DIRECTORY_SEPARATOR . 'SplPathBuilder.php';
}

$instance = ClassLoader::init();
$instance->addPathBuilder(SplPathBuilder::initWithNamespace('Extensions', dirname(__DIR__) . DIRECTORY_SEPARATOR . 'ext'));
