<?php

if (!class_exists('ClassLoader\\ClassLoader', false)) {
  require_once dirname(__DIR__) . '/src/ClassLoader.php';
}
if (!class_exists('Extensions\\ClassLoader\\Cache\\Cache', false)) {
  require_once dirname(__DIR__) . '/ext/ClassLoader/Cache/Cache.php';
}
if (!class_exists('Extensions\\ClassLoader\\Cache\\Instance', false)) {
  require_once dirname(__DIR__) . '/ext/ClassLoader/Cache/Instance.php';
}
if (!class_exists('Extensions\\ClassLoader\\PathBuilder\\PathBuilder', false)) {
  require_once dirname(__DIR__) . '/ext/ClassLoader/PathBuilder/PathBuilder.php';
}
if (!class_exists('Extensions\\ClassLoader\\PathBuilder\\Spl', false)) {
  require_once dirname(__DIR__) . '/ext/ClassLoader/PathBuilder/Spl.php';
}

