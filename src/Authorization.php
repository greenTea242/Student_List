<?php

/*Класс работы с cookie*/
class Authorization {
    private $gateway;

    public function __construct(AbiturientDataGateway $gateway)
    {
        $this->gateway = $gateway;
    }

    public function logIn($authToken, $CSRF_token)
    {
        setcookie("authToken",  $authToken,  time() + (10 * 365 * 24 * 60 * 60), "", "", "", 1);
        setcookie("CSRF_token", $CSRF_token, time() + (10 * 365 * 24 * 60 * 60), "", "", "", 1);
    }

    public function checkCookie($authToken)
    {
        if (empty($authToken)        ||
            !$this->gateway->isAbiturientExist($authToken)) {
            return false;
        }
        return true;
    }

    /*Метод удаления куки*/
    public function logOut()
    {
        setcookie("authToken",  "", time() - 3600);
        setcookie("CSRF_token", "", time() - 3600);
    }
}
