<?php

/*Достаем токен и id из куки, если они там есть*/
$abiturientID = isset($_COOKIE["abiturientID"]) ? strval($_COOKIE["abiturientID"]) : "";
$token        = isset($_COOKIE["token"])        ? strval($_COOKIE["token"])        : "";
$abiturient   = $authorizator->logIn($abiturientID, $token);