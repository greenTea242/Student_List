<?php

/*Класс работы с cookie*/
class Authorization {
    private $gateway;

    public function __construct(AbiturientDataGateway $gateway)
    {
        $this->gateway = $gateway;
    }

    public function getStudent($abiturientID)
    {
        return $this->gateway->selectAbiturient($abiturientID);
    }


    public function logIn($abiturientID, $token)
    {
        setcookie("abiturientID", $abiturientID, time() + (10 * 365 * 24 * 60 * 60), "", "", "", 1);
        $this->setToken($token);
    }

    public function setToken($token)
    {
        setcookie("token", $token, time() + (10 * 365 * 24 * 60 * 60), "", "", "", 1);
    }

    /*Метод удаления куки*/
    public function logOut()
    {
        setcookie("abiturientID", "", time() - 3600);
        setcookie("token",        "", time() - 3600);
    }
}