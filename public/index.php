<?php

/*Подключаем необходимые нам файлы*/
require_once "../src/ini.php";
require_once "./inc/login.php";
/*Если студент собирается выйти из аккаунта*/
if (isset($_GET["action"])      &&
    $_GET["action"] == "logout" &&
    isset($_GET["token"])       &&
    $abiturient->isAbiturientRegistred()) {
    /*Проверяем get токен на CSRF*/
    if (!$tokenHelper->checkTokenForCSRF($_GET["token"], $token)) {
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
$pager = new Pager($numberOfAbiturients, $recordsPerPage, 'index.php?page={page}');
/*Защита от вызова страниц page=Ы, page=-10*/
if ($pager->checkPossiblePages($myPage)) {
    $abiturients = $gateway->getAbiturientsInPage($recordsPerPage, $pager->getOffsetForDB($myPage), $sort, $search, $order);
}
/*Название шапки*/
$pageTitle = "Список студентов";
/*Вставляем шаблон*/
include "../templates/index.html";