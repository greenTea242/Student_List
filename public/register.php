<?php

/*Подключаем необходимые нам файлы*/
require_once __DIR__ . "/../src/ini.php";

if($_SERVER["REQUEST_METHOD"] == "POST") {
    /*Проверяем POST токен на CSRF*/
    if (!$tokenHelper->check_CSRF_token($_POST["CSRF_token"], $CSRF_token)) {
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
    $abiturient->setProperties($values, $authToken);
    /*Добавляем студента для проверки*/
    $errorList = $validator->createErrorsList($abiturient);
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
        $abiturient = $gateway->addAbiturient($abiturient);
        /*Ставим куки*/
        $authorizator->logIn($authToken, $CSRF_token);
        /*Делаем редирект*/
        header("Location: index.php?notify=registred");
        exit();
    }
}
/*Название шапки*/
$pageTitle = "Регистрация";
/*Вставляем шаблон*/
require_once __DIR__ . "/../templates/register.html";
