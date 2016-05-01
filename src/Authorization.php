<?php

/*Класс работы с cookie*/
class Authorization {
    private $gateway;

    public function __construct(AbiturientDataGateway $gateway)
    {
        $this->gateway = $gateway;
    }

    public function setAbiturientIDToCookie($abiturientID)
    {
        setcookie("abiturientID", $abiturientID, time() + (10 * 365 * 24 * 60 * 60), "", "", "", 1);
    }

    public function setTokenToCookie($token)
    {
        setcookie("token", $token, time() + (10 * 365 * 24 * 60 * 60), "", "", "", 1);
    }

    /*Метод проверки токена для защиты от CSRF*/
    public function checkTokenForCSRF($token, $cookieToken)
    {
        if((strcmp($token, $cookieToken) !== 0)) {
            return false;
        }
        return true;
    }

    /*Метод получения абитуриента*/
    public function logIn($abiturientID, $token)
    {

        if (!empty($abiturientID) &&
            !empty($token)        &&
            $this->gateway->isAbiturientExist($abiturientID, $token)) {
            /*Если куки подтвердились - продлеваем ее и достаем абитуриента из нашей бд*/
            $this->setTokenToCookie($token);
            return $this->gateway->selectAbiturient($abiturientID);
        }
        /**
         * Если абитуриент еще не получил личный токен.
         * В отличии от ID, токены имеют и зарег-ые и незарег-ые пол-ли
         */
        elseif (empty($token)) {
            $token = $this->createToken();
        }
        $abiturient = new Abiturient();
        /*В дальнейшем токен будет вызываться через модель*/
        $abiturient->setToken($token);
        /*Продлеваем токен*/
        $this->setTokenToCookie($token);
        return $abiturient;
    }

    /*Метод создания случайного токена*/
    public function createToken()
    {
        $token = "";
        $chars = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789";
        $numChars = strlen($chars);
        for ($i = 0; $i < 32; $i++) {
            $symbol = substr($chars, mt_rand(0, $numChars - 1), 1);
            $token = $token . $symbol;
        }
        return $token;
    }

    /*Метод удаления куки*/
    public function logOut()
    {
        setcookie("abiturientID", "", time() - 3600);
        setcookie("token",        "", time() - 3600);
    }
}