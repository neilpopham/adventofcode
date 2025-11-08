<?php

spl_autoload_register(
    function (string $class) {
        $x = DIRECTORY_SEPARATOR;
        $class = str_replace('\\', '/', $class);
        require_once(dirname(__FILE__, 2) . "/classes/{$class}.php");
    }
);

define('YEAR', 2017);

define('ROOT', dirname(__FILE__, 2));
