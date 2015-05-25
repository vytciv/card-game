<?php

require_once('vendor/autoload.php');

//require_once 'Mockery/Loader.php';
//require_once 'Hamcrest/Hamcrest.php';

//$loader = new \Mockery\Loader;
//$loader->register();

Phake::setClient(Phake::CLIENT_PHPUNIT);

spl_autoload_register(function ($className) {
    $classPath = str_replace(array('_', '\\'), '/', $className) . '.php';

    if (@fopen($classPath, 'r', true)) {
        require $classPath;
    }
});

