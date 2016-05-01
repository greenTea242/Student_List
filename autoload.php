<?php

/*Автозагрузка классов*/
spl_autoload_register(function ($name) {
    $path = __DIR__ . "/src/" . $name  . ".php";
    if (file_exists($path)) {
        require_once $path;
    }
});