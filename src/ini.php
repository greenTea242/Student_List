<?php

require_once __DIR__ . "/../autoload.php";
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
/*Массив с конфигурацией*/
$config = parse_ini_file(__DIR__ . "/../src/config.ini");
$dsn    = "mysql:host=localhost;dbname={$config['dbname']}";
$link   = new PDO($dsn, $config["userName"], $config["password"], $options);
$link->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
/*Создаем объект-маппер*/
$gateway      = new AbiturientDataGateway($link);
/*Создаем валидатор с внедрением зависимости от маппера*/
$validator    = new AbiturientValidator($gateway);
$tokenHelper  = new TokenHelper($gateway);
/*Создаем класс работы с куки и тоже внедряем маппер*/
$authorizator = new Authorization($gateway, $tokenHelper);
/*Достаем куки*/
$authToken    = isset($_COOKIE["authToken"]) ? strval($_COOKIE["authToken"]) : "";
$csrfToken    = isset($_COOKIE["csrfToken"]) ? strval($_COOKIE["csrfToken"]) : $tokenHelper->createToken();
$tokenHelper->setCsrfToken($csrfToken);
$abiturient   = $authorizator->getAbiturient($authToken);
