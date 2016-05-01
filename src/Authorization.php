<?php

/*Класс работы с cookie*/
class Authorization {
    private $gateway;

    public function __construct(AbiturientDataGateway $gateway)
    {
        $this->gateway = $gateway;
    }

    /*Метод установки куки с ID абитуриента*/
    public function setCookie()
    {
        setcookie("abiturientID", $this->gateway->getLastInsertID() , time() + (10 * 365 * 24 * 60 * 60));
    }

    /*Метод проверки куки*/
    public function checkCookie($abiturientID)
    {
        $abiturientID = strval($abiturientID);
        if ($this->gateway->isAbiturientIDExist($abiturientID)) {
            return $abiturientID;
        }
        return false;
    }

    /*Метод получения абитуриента*/
    public function logIn($abiturientID)
    {
        /*Если кука есть, достаем абитуриента из нашей бд*/
        if ($this->checkCookie($abiturientID)) {
            return $this->gateway->selectAbiturient($abiturientID);
        /*В противном случае - создаем нового абитируиента*/
        } else {
            return new Abiturient();
        }
    }


    /*Метод удаления куки*/
    public function logOut()
    {
        setcookie("abiturientID", "", time() - 3600);
        header("Location: index.php");
        exit();
    }
}