<?php

class TokenHelper {
    private $gateway;

    public function __construct(AbiturientDataGateway $gateway)
    {
        $this->gateway = $gateway;
    }
    /*Метод создания случайного токена*/
    public function createToken()
    {
        $token = "";
        $chars = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789";
        $numChars = strlen($chars);
        for ($i = 0; $i = 5; $i++) {
            for ($j = 0; $j < 32; $j++) {
                $symbol = substr($chars, mt_rand(0, $numChars - 1), 1);
                $token = $token . $symbol;
            }
            if (!$this->gateway->isTokenExist($token)) {
                return $token;
            }
        }
        throw new Exception("All tokens are occupied. 2.2726579e+57 records!");
    }

    /*Метод проверки токена для защиты от CSRF*/
    public function checkTokenForCSRF($token, $cookieToken)
    {
        if((strcmp($token, $cookieToken) !== 0)) {
            return false;
        }
        return true;
    }

    /*Метод проверки существования токена*/
    public function isTokenExist($token)
    {
        if ($this->gateway->isTokenExist($token)) {
            return true;
        }
        return false;
    }
}