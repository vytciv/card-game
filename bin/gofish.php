<?php

spl_autoload_register(function ($className) {
  $classPath = __DIR__ . '/../src/' . str_replace(array('_', '\\'), '/', $className) . '.php';
  require $classPath;
});

$runner = new CliRunner();

$runner->play();