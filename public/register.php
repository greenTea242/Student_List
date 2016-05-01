<?php

/*Подключаем необходимые нам файлы*/
require_once "../src/ini.php";
require_once "./inc/login.php";

/*Добавляем абитуриента в валидатор*/
$validator->addAbiturient($abiturient);
if($_SERVER["REQUEST_METHOD"] == "POST") {
    /*Проверяем post токен на CSRF*/
    if (!$authorizator->checkTokenForCSRF($_POST["token"], $abiturient->getToken())) {
        throw new Exception("The token is not verified. Possible CSRF.");
    }
    /*Массив свойств для заполнения модели*/
    $properties = [
        "email",
        "groupNumber",
        "name",
        "surname",
        "year",
        "points",
        "gender",
        "loko"
    ];
    /*Будущий массив значений*/
    $values = [];
    foreach ($properties as $property) {
        if (!empty($_POST[$property])) {
            /*Убираем лишние пробелы из принятых данных*/
            $values[$property] = ViewHelper::fixRegistrationInput($_POST[$property]);
        }
    }
    /*Инициализурем свойства объекта*/
    $abiturient->setProperties($values);
    /*Проверяем на ошибки*/
    $errorList = $validator->createErrorsList();
    /*Если ошибок нет*/
    if (empty($errorList)) {
        /*Если студент редактирует данные*/
        if ($abiturient->isAbiturientRegistred()) {
            /*Обновляем запись в бд*/
            $gateway->updateAbiturient($abiturient);
            /*Делаем редирект*/
            header("Location: index.php");
            exit();
        }
        /*Если студент первый раз на сайте*/
        /*Добавляем его в бд*/
        $gateway->addAbiturient($abiturient);
        /*Ставим куки*/
        $authorizator->setAbiturientIDToCookie($gateway->getLastInsertID());
        $authorizator->setTokenToCookie($abiturient->getToken());
        /*Делаем редирект*/
        header("Location: index.php?notify=registred");
        exit();
    }
}
/*Название шапки*/
$pageTitle = "Регистрация";
/*Вставляем шаблон*/
include "../templates/register.html";