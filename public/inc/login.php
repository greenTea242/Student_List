<?php

/*Достаем куки*/
$abiturientID = isset($_COOKIE["abiturientID"]) ? strval($_COOKIE["abiturientID"]) : "";
$token        = isset($_COOKIE["token"])        ? strval($_COOKIE["token"])        : "";
if ($gateway->isAbiturientExist($abiturientID, $token)) {
    $abiturient = $authorizator->getStudent($abiturientID);
    $authorizator->logIn($abiturientID, $token);
/*Если студента не существует, т.е. либо куки не подошли, либо студент на сайте первый раз*/
} else {
    /**
     * Если токена нет(студент первый раз) или токен присутсвует в бд.
     * В последнем случае его надо заново создать, иначе будет повтор токенов в бд
     */
    if (empty($token) ||
        $tokenHelper->isTokenExist($token)) {
        $token = $tokenHelper->createToken();
    }
    $authorizator->setToken($token);
    $abiturient = new Abiturient();
}