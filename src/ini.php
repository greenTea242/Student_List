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
$dsn    = "mysql:host=localhost;dbname=studentlist";
/*Массив с конфигурацией*/
$config = parse_ini_file(__DIR__ . "/../src/config.ini");
$link   = new PDO($dsn, $config["userName"], $config["password"], $options);
$link->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
/*Создаем объект-маппер*/
$gateway      = new AbiturientDataGateway($link);
/*Создаем валидатор с внедрением зависимости от маппера*/
$validator    = new AbiturientValidator($gateway);
/*Создаем класс работы с куки и тоже внедряем маппер*/
$authorizator = new Authorization($gateway);
$tokenHelper  = new TokenHelper($gateway);
/*Достаем куки*/
$authToken  = isset($_COOKIE["authToken"])  ? strval($_COOKIE["authToken"])  : "";
$CSRF_token = isset($_COOKIE["CSRF_token"]) ? strval($_COOKIE["CSRF_token"]) : $tokenHelper->createToken();
if ($authorizator->checkCookie($authToken)) {
    $abiturient = $gateway->selectAbiturient($authToken);
    $authorizator->logIn($authToken, $CSRF_token);
} else {
    /**
     * Если токена нет(студент первый раз) или токен присутсвует в бд(авторизация
     * до этого момента была провалена, поэтому скорее всего
     * пользователь - злоумышленник(подделывает другим имена и баллы, бессовестный!)).
     * В последнем случае его надо заново создать, иначе будет повтор токенов в бд
     */
    $authToken = $tokenHelper->createToken();
    $abiturient = new Abiturient();
    $authorizator->logIn($authToken, $CSRF_token);
}
