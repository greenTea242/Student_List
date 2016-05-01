<?php

/*Подключаем необходимые нам файлы*/
require_once "../src/ini.php";

/*Ищем куку*/
if (isset($_COOKIE["abiturientID"])) {
    $abiturientID = $authorizator->checkCookie($_COOKIE["abiturientID"]);
} else {
    $abiturientID = "";
}
/*Получаем нового или старого абитуриента, если он уже регистрировался на сайте*/
$abiturient = $authorizator->logIn($abiturientID);
/*Добавляем абитуриента в валидатор*/
$validator->addAbiturient($abiturient);
if($_SERVER["REQUEST_METHOD"] == "POST") {
    /*Массив для заполнения модели*/
    $values = [
        "name"        => "",
        "surname"     => "",
        "groupNumber" => "",
        "points"      => "",
        "email"       => "",
        "year"        => "",
        "gender"      => "",
        "loko"        => ""
    ];
    foreach ($values as $key => &$value) {
        if (!empty($_POST[$key])) {
            /*Убираем лишние пробелы из принятых данных*/
            $value = ViewHelper::fixRegistrationInput(strval($_POST[$key]));
        }
    }
    /*Инициализурем свойства объекта*/
    $abiturient->setFields($values);
    /*Проверяем на ошибки*/
    $errorList = $validator->createErrorsList($abiturientID);
    /*Если ошибок нет*/
    if (empty($errorList)) {
        /*Если студент редактирует данные*/
        if ($abiturientID) {
            /*Обновляем запись в бд*/
            $gateway->updateAbiturient($abiturient, $abiturientID);
            /*Делаем редирект*/
            header("Location: index.php");
            exit();
        /*Если студент первый раз на сайте*/
        } else {
            /*Добавляем его в бд*/
            $gateway->addAbiturient($abiturient);
            /*Ставим куку*/
            $authorizator->setCookie();
            /*Делаем редирект*/
            header("Location: index.php?notify=registred");
            exit();
        }
    }
}
/*Название шапки*/
$pageTitle = "Регистрация";
/*Навигационное меню*/
$navigationList = file_get_contents("../templates/inc/navigationMenu3.html");
/*Вставляем шаблон*/
include "../templates/register.html";