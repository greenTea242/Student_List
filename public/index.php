<?php

/*Подключаем необходимые нам файлы*/
require_once "../src/ini.php";

/*Если студент выходит из аккаунта - удаляем куки*/
if (isset($_GET["action"]) && $_GET["action"] == "logout") {
    $authorizator->logOut();
}
/*Если в браузере клиента есть куки - ее надо проверить*/
if (isset($_COOKIE["abiturientID"])) {
    $abiturientID = $authorizator->checkCookie($_COOKIE["abiturientID"]);
} else {
    $abiturientID = "";
}
/*Получаем внешние переменные и преобразуем их в строку. Если же переменных нет, задаем значения по умолчанию*/
$notify   = isset($_GET["notify"]) ? strval($_GET["notify"]) : "";
$myPage   = isset($_GET["page"])   ? strval($_GET["page"])   : 1;
$sort     = isset($_GET["sort"])   ? strval($_GET["sort"])   : "points";
$order    = isset($_GET["order"])  ? strval($_GET["order"])  : "desc";
/*Поисковую строку дополнительно пропускаем через сервис-функцию*/
$search   = isset($_GET["search"]) ? ViewHelper::fixSearchString(strval($_GET["search"])) : "";
/*Считаем количество абитуриентов в бд*/
$counter = $gateway->countAbiturients($search);
/*Количество записей на одной странице*/
$recordsPerPage = 16;
/*Считаем необходимое количество страниц*/
$totalPages = ceil($counter/$recordsPerPage);
/*Создаем класс pager*/
$pager = new Pager($totalPages, $recordsPerPage, 'index.php?page={page}');
$abiturients = [];
/*Защита от вызова страниц page=Ы, page=-10*/
if ($pager->checkPossiblePages($myPage)) {
    $abiturients = $gateway->getAbiturientsInPage($recordsPerPage, $pager->getOffsetForDB($myPage), $sort, $search, $order);
}
/*Вовзращаем пробел (один) поисковой строки для вывода сообщения в шаблоне "вы искали a б", а не "вы искали a%б"*/
if (!empty($search)) {
    $search = preg_replace("/%/", " ", $search);
}
/*Название шапки*/
$pageTitle = "Список студентов";
/*Если абитуриент уже зарегистрировался, навигационное меню такое-то*/
if (!empty($abiturientID)) {
    $navigationList = file_get_contents("../templates/inc/navigationMenu1.html");
} else {
    $navigationList = file_get_contents("../templates/inc/navigationMenu2.html");
}
/*Вставляем шаблон*/
include "../templates/index.html";