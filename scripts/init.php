<?php

use ClassLoader\ClassLoader;
use Extensions\ClassLoader\PathBuilder\SplPathBuilder;

if (!class_exists('ClassLoader\\ClassLoader')) {
  require dirname(__DIR__) . '/src/ClassLoader.php';
}
if (!class_exists('Extensions\\ClassLoader\\Cache\\Cache')) {
  require_once dirname(__DIR__) . '/ext/ClassLoader/Cache/Cache.php';
}
if (!class_exists('Extensions\\ClassLoader\\Cache\\Instance')) {
  require_once dirname(__DIR__) . '/ext/ClassLoader/Cache/Instance.php';
}
if (!class_exists('Extensions\\ClassLoader\\PathBuilder\\PathBuilder')) {
  require_once dirname(__DIR__) . '/ext/ClassLoader/PathBuilder/PathBuilder.php';
}
if (!class_exists('Extensions\\ClassLoader\\PathBuilder\\SplPathBuilder')) {
  require_once dirname(__DIR__) . '/ext/ClassLoader/PathBuilder/SplPathBuilder.php';
}

