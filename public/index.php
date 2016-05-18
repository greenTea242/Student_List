<?php

/*Подключаем необходимые нам файлы*/
require_once __DIR__ . "/../src/ini.php";
/*Если студент собирается выйти из аккаунта*/
if (isset($_GET["action"])      &&
    $_GET["action"] == "logout" &&
    isset($_GET["CSRF_token"])  &&
    $abiturient->isAbiturientRegistred()) {
    /*Проверяем GET токен на CSRF*/
    if (!$tokenHelper->check_CSRF_token($_GET["CSRF_token"], $CSRF_token)) {
        throw new Exception("The token is not verified. Possible CSRF.");
    }
    $authorizator->logOut();
    header("Location: index.php");
    exit();
}
/*Получаем внешние переменные и преобразуем их в строку. Если же переменных нет, задаем значения по умолчанию*/
$notify   = isset($_GET["notify"]) ? strval($_GET["notify"]) : "";
$myPage   = isset($_GET["page"])   ? strval($_GET["page"])   : 1;
$sort     = isset($_GET["sort"])   ? strval($_GET["sort"])   : "points";
$order    = isset($_GET["order"])  ? strval($_GET["order"])  : "desc";
$search   = isset($_GET["search"]) ? strval($_GET["search"]) : "";
/*Считаем количество абитуриентов в бд*/
$numberOfAbiturients = $gateway->countAbiturients($search);
/*Создаем класс pager*/
$pager = new Pager($numberOfAbiturients, $config["recordsPerPage"], 'index.php?page={page}');
/*Защита от вызова страниц page=Ы, page=-10*/
if ($pager->checkPossiblePages($myPage)) {
    $abiturients = $gateway->getAbiturientsInPage($config["recordsPerPage"], $pager->getOffsetForDB($myPage), $sort, $search, $order);
}
/*Страницы доступные для навигации*/
$visiblePages = $pager->getListOfVisiblePages($myPage);
/*Название шапки*/
$pageTitle = "Список студентов";
/*Ссылка на главную страницу без GET параметров*/
$indexHref = $_SERVER["PHP_SELF"];
/*Вставляем шаблон*/
require_once __DIR__ . "/../templates/index.html";
