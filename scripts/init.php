<?php

if (!class_exists('ClassLoader\\ClassLoader', FALSE)) {
  require_once dirname(__DIR__) . '/src/ClassLoader.php';
}
if (!class_exists('ClassLoader\\Cache\\Cache', FALSE)) {
  require_once dirname(__DIR__) . '/src/Cache/Cache.php';
}
if (!class_exists('ClassLoader\\Cache\\Instance', FALSE)) {
  require_once dirname(__DIR__) . '/src/Cache/Instance.php';
}
if (!class_exists('ClassLoader\\PathBuilder\\PathBuilder', FALSE)) {
  require_once dirname(__DIR__) . '/src/PathBuilder/PathBuilder.php';
}
if (!class_exists('ClassLoader\\PathBuilder\\Spl', FALSE)) {
  require_once dirname(__DIR__) . '/src/PathBuilder/Spl.php';
}

