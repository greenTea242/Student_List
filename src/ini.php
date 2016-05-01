<?php

require      "config.php";
require_once "../autoload.php";
/*Обработчик исключений*/

set_exception_handler(function($exception) {
    header('HTTP/1.1 503 Service Temporarily Unavailable');
    header('Status: 503 Service Temporarily Unavailable');
    error_log($exception->__toString(), 0);
    $pageTitle = "Ошибка";
    include(__DIR__ . "/../templates/error.html");
});

/*Инициализация нашей базы и создания DataGateway объекта*/
$options = array(
    PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8, sql_mode=STRICT_ALL_TABLES'
);
$link = new PDO($dsn, $userName, $password, $options);
$link->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
/*Создаем объект-маппер*/
$gateway = new AbiturientDataGateway($link);
/*Создаем валидатор с внедрением зависимости от маппера*/
$validator = new AbiturientValidator($gateway);
/*Создаем класс работы с куки и тоже внедряем маппер*/
$authorizator = new Authorization($gateway);
$tokenHelper  = new TokenHelper($gateway);