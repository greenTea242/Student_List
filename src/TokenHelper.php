<?php

class TokenHelper {
    private $gateway;

    public function __construct(AbiturientDataGateway $gateway)
    {
        $this->gateway = $gateway;
    }
    /*Метод создания случайного токена*/
    public function createToken($tokenForCsrf = false)
    {
        $token = "";
        $chars = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789";
        $numChars = strlen($chars);
        for ($i = 0; $i = 5; $i++) {
            for ($j = 0; $j < 32; $j++) {
                $symbol = substr($chars, mt_rand(0, $numChars - 1), 1);
                $token = $token . $symbol;
            }
            /*Токены для CSRF не хранятся в базе*/
            if (!$tokenForCsrf &&
                !$this->gateway->isAbiturientExist($token)) {
                return $token;
            }
        }
        throw new Exception("All tokens are occupied. 2.2726579e+57 students!");
    }

    /*Метод проверки токена для защиты от CSRF*/
    public function checkCsrfToken($csrfToken, $cookieCsrfToken)
    {
        if((strcmp($csrfToken, $cookieCsrfToken) !== 0)) {
            return false;
        }
        return true;
    }

    public function setCsrfToken($csrfToken)
    {
        setcookie("csrfToken", $csrfToken, time() + (10 * 365 * 24 * 60 * 60), "", "", "", 1);
    }
}
